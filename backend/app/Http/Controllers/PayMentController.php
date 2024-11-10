<?php

namespace App\Http\Controllers;

use App\Helpers\ApiHelper;
use App\Models\Address;
use App\Models\Cart;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Models\PaymentGateways;
use App\Services\OrderLocationService;
use App\Services\OrderService;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PayMentController extends Controller
{
    protected $orderService;
    protected $orderLocationService;

    protected $paymentService;
    protected $paymentRepository;
    
    public function __construct(
        OrderService $orderService,
        OrderLocationService $orderLocationService,
        PaymentService $paymentService
    ) {
        $this->orderService = $orderService;
        $this->orderLocationService = $orderLocationService;
        $this->paymentService = $paymentService;
    }
    public function addOrder(Request $request)
    {
        // Validate request data
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

        $shippingCost = floatval($request->input('radio-ship'));
        $totalPrice = $subTotal + $shippingCost;
        $dataOrder = [
            'user_id' => Auth::id(),
            'code' => 'ORDER-' . strtoupper(uniqid()),
            'total_price' => $totalPrice,
            'shipping_address_id' => $request->shipping_address_id,
            'note' => $request->note,
            'status' => Order::CHO_XAC_NHAN,
        ];

        $check = false;
        if ($request->has('radio_pay')) {
            $radio_pay = $request->radio_pay;
            $payment = PaymentGateway::where('name', $radio_pay)->first();
            if ($payment && $payment->name ==Payment::VNPay) {
                $dataOrder['payment_id'] = $payment->id;
                $check=false;
                $this->saveOrderItemAndOrderLocation($dataOrder , $request , $check);
                return $this->createOrder($dataOrder);
            } else {
                $dataOrder['payment_id'] = $payment->id;
                $check = false;
            }
        }
        $this->saveOrderItemAndOrderLocation($dataOrder , $request , $check);
        return redirect()->route('client')->with('message', 'Đơn hàng đã được đặt thành công!');
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
                if(!$check){
                    $idCard = $value['id_cart'];
                    $this->removeFromCart($idCard);
                }else{
                    $idCard[] = $value['id_cart'];
                    session(['id_cart' => $idCard]);
                    //check
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
        Log::info('Returning to application. Current session data: ', session()->all());
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
    
        // Prepare data for the view
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
    
        // Save order information to the database if the transaction was successful
        if ($responseData['result'] == 'GD Thanh cong') {
            $order= $this->orderService->getbyCode($responseData['order_code']);
            Payment::create(['order_id'=>$order->id , 'payment_gateway_id'=>$order->payment_id, 'amount'=> substr($responseData['amount'], 0, -2) ,'status'=>Payment::Completed , 'transaction_id'=> $responseData['transaction_no']]);
        }
        $order = Order::with(['items.product', 'items.productVariant.attributeValues.attribute', 'payment.paymentGateway'])
            ->where('code', $responseData['order_code'])
            ->first();
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

        return view('client.orders.payment.return', compact('responseData', 'order','address','addressShop'));
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
}
