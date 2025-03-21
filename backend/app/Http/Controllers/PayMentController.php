<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Mail\OrderOnlineMail; //
use App\Mail\OrderPlacedMail; //
use App\Models\Cart;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Product;
use App\Models\OrderItem;
use App\Events\OrderPlaced;
use App\Models\CouponUsage;
use Illuminate\Http\Request;
use App\Models\PaymentGateway;
use App\Models\ProductVariant;
use App\Services\OrderService;
use App\Models\PaymentGateways;
use App\Models\shippingMethods;
use App\Services\CouponService;
use App\Services\CarrierService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail; //
use Illuminate\Support\Facades\Auth;
use App\Services\OrderLocationService;

class PayMentController extends Controller
{
    protected $orderService;
    protected $orderLocationService;

    protected $paymentService;
    protected $paymentRepository;
    protected $carrierService;

    protected $couponService;

    public function __construct(
        OrderService $orderService,
        OrderLocationService $orderLocationService,
        PaymentService $paymentService,
        CarrierService $carrierService,
        CouponService $couponService
    ) {
        $this->orderService = $orderService;
        $this->orderLocationService = $orderLocationService;
        $this->paymentService = $paymentService;
        $this->carrierService = $carrierService;
        $this->couponService = $couponService;
    }
    public function addOrder(Request $request)
    {
        $couponCode=[];
        $priceCoupone=0;
        if($request->has('coupons'))
        {
            $couponCode=$request->coupons;
            foreach($couponCode as $key=>$val)
            {
                $priceCoupone  +=$val['discount_amount'];
            }
        }
        $subTotal = 0;
        if ($request->has('order_item')) {
            foreach ($request->order_item as $item) {
                $productId = $item['product_id'];
                $productVariantId = $item['product_variant_id'] ?? null;
                $product = Product::find($productId);

                $price = 0;

                if ($productVariantId) {
                    $variant = ProductVariant::find($productVariantId);
                    $price = $variant ? ($variant->price_modifier ?: $variant->original_price) : 0;
                } else {
                    $price = $product->price_sale ?: $product->price_regular;
                }

                $quantity = $item['quantity'] ?? 1;
                $subTotal += $price * $quantity;
            }
        }

        $shippFe =$request->input('shipp');
        foreach($shippFe as $key =>$val){
            $shippingCost=  floatval($val);
            $carry= $this->carrierService->getByCode($key);
            if(isset($carry))
            {
                $carrier_id = $carry->id;
            }
            $carrier_id =null;
        }
        $totalPrice = $subTotal + $shippingCost-$priceCoupone;
        $dataOrder = [
            'user_id' => Auth::id(),
            'code' => 'ORDER-' . strtoupper(uniqid()),
            'total_price' => $totalPrice,
            'shipping_address_id' => $request->shipping_address_id,
            'note' => $request->note,
            'status' => Order::CHO_XAC_NHAN,
            'carrier_id'=>$carrier_id,
        ];

        $check = true;
        if ($request->has('radio_pay')) {
            $radio_pay = $request->radio_pay;
            $payment = PaymentGateway::where('name', $radio_pay)->first();
            if ($payment && $payment->name ==Payment::VNPay) {
                $dataOrder['payment_id'] = $payment->id;
                $check=false;
                $order =$this->saveOrderItemAndOrderLocation($dataOrder , $request , $check);
                $dataShipFe = [
                    'order_id'          =>$order->id,
                    'payment_gateway_id'=>$dataOrder['payment_id'],
                    'amount'            =>$dataOrder['total_price'],
                    'status'            =>shippingMethods::PENDING,
                    'transaction_id'    =>$order->code,
                    'shipping_fee'      =>$shippingCost
                ];
                shippingMethods::create($dataShipFe);
                $this->createNewCouponeUsage($couponCode, $order->id);
                return $this->createOrder($dataOrder);
            } else {
                $dataOrder['payment_id'] = $payment->id;
                $check = false;
            }
        }
        $data= $this->saveOrderItemAndOrderLocation($dataOrder , $request , $check);
        $payment=Payment::create(['order_id'=>$data->id , 'payment_gateway_id'=>$data->payment_id, 'amount'=> $data->total_price ,'status'=>Payment::Pending, 'transaction_id'=>str_replace('.', '', uniqid(mt_rand(), true))]);

        $dataShipFe = [
            'order_id'          => $data->id,
            'payment_gateway_id'=>$dataOrder['payment_id'],
            'amount'            =>$dataOrder['total_price'],
            'status'            =>shippingMethods::PENDING,
            'transaction_id'    =>$payment->transaction_id,
            'shipping_fee'      =>$shippingCost
        ];
        shippingMethods::create($dataShipFe);
        $order = Order::with(['items.product', 'items.productVariant.attributeValues.attribute', 'payment.paymentGateway','shippingMethod'])
            ->where('code', $data['code'])
            ->first();
        $this->createNewCouponeUsage($couponCode, $order->id);
        $couponUsage = $this->couponService->getByCouponUsage($order->id);
        $this->couponService->updateByOrderCoupon($order->id);

        Mail::to($order->user->email)->send(new OrderPlacedMail($order));

        $responseData= [
            'bank_code'    =>'',
            'vnp_CardType' =>'Thanh toán sau khi nhận hàng'
        ];
        $addressResponse = ApiHelper::getAddressShop();
        $address = Address::getActiveAddress(Auth::user()->id);
        $addressShop=[];
        if ($addressResponse['code']==200) {
            if (isset($addressResponse['data']) && !empty($addressResponse['data']['shops'])) {
                $shopData = $addressResponse['data']['shops'][0];
                $addressShop = [
                    'name' => $shopData['name'],
                    'phone' => $shopData['phone'],
                    'address' => $shopData['address']
                ];
            } else {
                $addressShop = null;
            }
        } else {
            $addressShop = null;
        }
        return view('client.orders.payment.return', compact('check','responseData', 'order','address','addressShop','couponUsage'));
    }

    private function saveOrderItemAndOrderLocation($dataOrder , $request , $check){
        $order = $this->orderService->saveOrUpdate($dataOrder);
        if ($request->has('order_item')) {
            foreach ($request->order_item as $value) {
                $dataItem = [
                    'order_id' => $order->id,
                    'product_id' => $value['product_id'],
                    'variant_id' => $value['product_variant_id'],
                    'quantity' => $value['quantity'],
                    'price' => $value['price'],
                    'discount' => $value['discount'] ?? null,
                ];
                 OrderItem::create($dataItem);
                 $this->updateCountProducts($value['product_id'],$value['product_variant_id'],$value['quantity']);
                if(!$check){
                    $idCard = $value['id_cart'];
                    $this->removeFromCart($idCard);
                }else{
                    $idCard[] = $value['id_cart'];
                    session(['id_cart' => $idCard]);
                }
            }
        }
        $dataOrderLocation = [
            'order_id' => $order->id,
            'address' => $request->address,
            'city' => 'Hà Nội',
            'district' => 'Bắc Từ Liêm',
            'ward' => 'Trường CD FPT PolyTechnic',
            'latitude' => null,
            'longitude' => null,
        ];
        $this->orderLocationService->saveOrUpdate($dataOrderLocation);
        $this->placeOrder($order,1);
        return $order;
    }

    private function createOrder($data)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('vnpay.return');

        $startTime = date("YmdHis");
        $expire = date('YmdHis',timestamp: strtotime('+15 minutes',strtotime($startTime)));
        $vnp_TxnRef = $data['code'];
        $vnp_Amount = $data['total_price'];
        $vnp_Locale = 'vn';
        $vnp_BankCode ='';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $vnp_OrderInfo = "Thanh toan GD:". $data['code']. "-". $data['total_price'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount* 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate"=>$expire,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret);//
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
        die();
    }

    public function vnpayReturn(Request $request)
    {
        Log::info('request' , $request->all());
        // Retrieve the response from VNPAY
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        $inputData = array();

        foreach ($request->input() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        unset($inputData['vnp_SecureHash']);
        ksort($inputData);

        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $vnp_HashSecret = "KWVSKMORO004EISIYKM91EVS2X5GSLH0"; // Your secret key
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

        $responseData = [
            'order_code' => $request->input('vnp_TxnRef'),
            'amount' => $request->input('vnp_Amount'),
            'order_info' => $request->input('vnp_OrderInfo'),
            'response_code' => $request->input('vnp_ResponseCode'),
            'transaction_no' => $request->input('vnp_TransactionNo'),
            'bank_code' => $request->input('vnp_BankCode'),
            'pay_date' => $request->input('vnp_PayDate'),
            'code_vnp_BankTranNo'=>$request->input('vnp_BankTranNo'),
            'vnp_CardType'=>$request->input('vnp_CardType')? $request->input('vnp_CardType') : '' ,


            'result' => ($secureHash == $vnp_SecureHash && $request->input('vnp_ResponseCode') == '00')
                ? 'GD Thanh cong'
                : 'GD Khong thanh cong hoặc Chu ky khong hop le',
        ];

        $order= $this->orderService->getbyCode($responseData['order_code']);
        $check= $this->paymentService->getCheckOrderById($order->id);
        if(!$check){
            if ($responseData['result'] == 'GD Thanh cong') {
                $payment= Payment::create(['order_id'=>$order->id , 'payment_gateway_id'=>$order->payment_id, 'amount'=> substr($responseData['amount'], 0, -2) ,'status'=>Payment::Pending , 'transaction_id'=> $responseData['transaction_no']]);
                Payment::where('id',$payment->id)->update(['status'=>Payment::Completed]);
                shippingMethods::where('transaction_id',$order->code)->update(['transaction_id'=> $payment->transaction_id]);
                $this->couponService->updateByOrderCoupon($order->id);
                $this->placeOrder($order ,3);

                Mail::to($order->user->email)->send(new OrderOnlineMail($order));
            }else
            {
                $payment= Payment::create(['order_id'=>$order->id , 'payment_gateway_id'=>$order->payment_id, 'amount'=>$order->total_price ,'status'=>Payment::Failed , 'transaction_id'=>$order->code]);
                Order::where('code', $order->code)->update(['status' =>Order::DA_HUY]);
                shippingMethods::where('order_id',$order->id)->update(['transaction_id'=> $payment->transaction_id,'status'=>shippingMethods::FAILED]);
                $this->placeOrder($order ,2);
                if ($order && $order->items) {
                    foreach ($order->items as $item) {
                        $this->restoreStock($item->product_id, $item->product_variant_id, $item->quantity);
                    }
                }
            }
        }
        $order = Order::with(['items.product', 'items.productVariant.attributeValues.attribute', 'payment.paymentGateway','shippingMethod'])
            ->where('code', $responseData['order_code'])
            ->first();
        $couponUsage = $this->couponService->getByCouponUsage($order->id);
        $addressResponse = ApiHelper::getAddressShop();
        $address = Address::getActiveAddress(Auth::user()->id);
        $addressShop=[];
        if ($addressResponse['code']==200) {
            if (isset($addressResponse['data']) && !empty($addressResponse['data']['shops'])) {
                $shopData = $addressResponse['data']['shops'][0];
                $addressShop = [
                    'name' => $shopData['name'],
                    'phone' => $shopData['phone'],
                    'address' => $shopData['address']
                ];
            } else {
                $addressShop = null;
            }
        } else {
            $addressShop = null;
        }
        $check=true;
        return view('client.orders.payment.return', compact('check','responseData', 'order','address','addressShop','couponUsage'));
    }
    
    public function removeFromCart($id)
    {
        $cartItem = Cart::find($id);

        if ($cartItem) {
            $cartItem->delete(); // Xóa sản phẩm khỏi giỏ hàng
            return response()->json(['message' => 'Product removed successfully']);
        }

        return response()->json(['message' => 'Product not found'], 404);
    }
    public function index()
    {
        $payments = Payment::join('payment_gateways', 'payments.payment_gateway_id', '=', 'payment_gateways.id')
                           ->select('payments.*', 'payment_gateways.name as gateway_name')
                           ->get();

        return view('admin.payments.index', compact('payments'));
    }

        public function add()
        {
            $paymentGateways = PaymentGateway::all();
            return view('admin.payments.create', compact('paymentGateways'));
        }

        public function store(Request $request)
        {
            try {

                $data = $request->only([
                    'order_id',
                    'payment_gateway_id',
                    'amount',
                    'status',
                    'transaction_id',
                ]);

                $payments = $this->paymentService->createPayment($data);

                return redirect()->route('admin.payments.index')->with([
                    'payments' => $payments
                ]);
            } catch (\Exception $e) {
                Log::error("Error creating payments: " . $e->getMessage());
                return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo người dùng.');
            }
        }

        public function show($id)
        {
            $payments = Payment::with('paymentGateway')->findOrFail($id);

            return view('admin.payments.show', compact('payments'));
        }

        public function edit($id)
        {
            $payments = Payment::findOrFail($id);
            $paymentGateways = PaymentGateway::all();

            return view('admin.payments.update', compact('payments', 'paymentGateways'));
        }

        public function update(Request $request, $id)
        {
            $data = $request->all();

            $payments = $this->paymentService->updatePayment($id, $data);

            return redirect()->route('admin.payments.index')->with([
                'payments' => $payments
            ]);
        }

        public function destroy($id, Request $request)
        {
            $payments = Payment::findOrFail($id);

            if ($request->forceDelete === 'true') {
                $payments->forceDelete();
            } else {
                $payments->delete();
            }

            return redirect()->route('admin.payments.index');
        }

        public function deleteMultiple(Request $request)
        {
            $ids = json_decode($request->ids);
            $forceDelete = $request->forceDelete === 'true';

            foreach ($ids as $id) {
                $payments = Payment::find($id);
                if ($forceDelete) {
                    $payments->forceDelete();
                } else {
                    $payments->delete();
                }
            }

            return response()->json(['success' => true, 'message' => 'Người dùng đã được xóa.']);
        }

        private function createNewCouponeUsage($couponCode=[], $id)
        {
            try {
                if (count($couponCode) > 0) {
                    foreach ($couponCode as $value) {
                        $coupone = $this->couponService->findByCode($value['code']);
                        if ($coupone) {
                            CouponUsage::create([
                                'coupon_id'       => $coupone->id,
                                'user_id'         => Auth::id(),
                                'order_id'        => $id,
                                'discount_value'  => $value['discount_amount']
                            ]);
                            if ($coupone->usage_limit > 0) {
                                $coupone->usage_limit--;
                                $coupone->save();
                            }
                        } else {
                            // Log hoặc xử lý khi không tìm thấy coupon
                            Log::warning("Coupon not found for code: $value");
                        }
                    }
                }
            } catch (\Exception $e) {
                Log::error("Error creating CouponUsage: " . $e->getMessage());
            }

        }
        private function placeOrder($order, $status)
        {
            $user = auth()->user();

            if ($order) {
                if ($status == 1) {
                    $message = "Đơn hàng $order->code | đã đặt với số tiền " . number_format($order->total_price, 0, ',', '.') . "₫";
                } elseif ($status == 2) {
                    $message = "Đơn hàng đã hủy! Mã: $order->code";
                } elseif ($status == 3) {
                    $message = "Đơn hàng $order->code | thanh toán thành công với số tiền " . number_format($order->total_price, 0, ',', '.') . "₫";
                }

                broadcast(new OrderPlaced($order, $user, $message));
            }
        }
        private function updateCountProducts($productId , $products_variant_id, $quantity)
        {
            $product = Product::find($productId);
            if (!empty($products_variant_id)) {
                $productVariant = ProductVariant::find($products_variant_id);

                $newStockVariant = $productVariant->stock - $quantity;

                $productVariant->update(['stock' => $newStockVariant]);
            }
            $newStockProduct = $product->stock - $quantity;
            $newBuyCount = $product->buycount + $quantity;
            $product->update(['stock' => $newStockProduct ,'buycount' =>$newBuyCount]);
        }
        private function restoreStock($productId, $productVariantId, $quantity)
        {
            $product = Product::find($productId);
            if (!empty($productVariantId)) {
                $productVariant = ProductVariant::find($productVariantId);
                // Cộng lại số lượng tồn kho của biến thể
                $newStockVariant = $productVariant->stock + $quantity;
                $productVariant->update(['stock' => $newStockVariant]);
            }
            // Cộng lại số lượng tồn kho của sản phẩm
            $newStockProduct = $product->stock + $quantity;
            $newBuyCount = $product->buycount - $quantity;
            $product->update(['stock' => $newStockProduct , 'buycount' =>$newBuyCount]);
        }

}
