<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentGateway;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    protected $paymentService;
    protected $paymentRepository;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
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
