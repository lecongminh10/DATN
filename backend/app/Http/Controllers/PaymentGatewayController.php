<?php

namespace App\Http\Controllers;

use App\Events\AdminActivityLogged;
use App\Http\Requests\PaymentGatewayRequest;
use App\Models\PaymentGateway;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentGatewayController extends Controller
{
    protected $paymentGatewayService;
    protected $paymentGatewayRepository;

    public function __construct(PaymentGatewayService $paymentGatewayService)
    {
        $this->paymentGatewayService = $paymentGatewayService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $paymentGateway = PaymentGateway::query();

        if ($search) {
            $paymentGateway = $paymentGateway->where('name', 'LIKE', "%$search%");
        }

        $paymentGateway = $paymentGateway->get();

        return view('admin.paymentgateways.index', compact('paymentGateway'));
    }
    public function add()
    {
        return view('admin.paymentgateways.create');
    }

    public function store(PaymentGatewayRequest $request)
    {
        try {
            $data = $request->only(['name', 'api_key', 'secret_key', 'gateway_type']);

            $existing = PaymentGateway::where('name', $data['name'])->exists();
            if ($existing) {
                return redirect()->back()->withErrors(['name' => 'Tên đã tồn tại'])->withInput();
            }

            $paymentGateway = $this->paymentGatewayService->createPaymentGateway($data);

            $logDetails = sprintf(
                'Thêm mới cổng thanh toán: Tên - %s',
                $paymentGateway->name,
            );

            event(new AdminActivityLogged(
                auth()->user()->id,
                'Thêm mới',
                $logDetails
            ));

            return redirect()->route('admin.paymentgateways.index')->with('success', 'Thêm mới cổng thanh toán thành công');
        } catch (\Exception $e) {
            Log::error("Error creating payment gateways: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi tạo cổng.')->withInput();
        }
    }

    public function show($id)
    {
        $paymentGateway = $this->paymentGatewayService->getById($id);

        return view('admin.paymentgateways.show', compact('paymentGateway'));
    }

    public function edit($id)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);

        return view('admin.paymentgateways.update', compact('paymentGateway'));
    }

    public function update(PaymentGatewayRequest $request, $id)
    {
        try {
            $data = $request->only(['name', 'api_key', 'secret_key', 'gateway_type']);

            $existing = PaymentGateway::where('name', $data['name'])
                ->where('id', '!=', $id)
                ->exists();
            if ($existing) {
                return redirect()->back()->withErrors(['name' => 'Tên đã tồn tại'])->withInput();
            }

            $paymentGateway = $this->paymentGatewayService->updatePaymentGateway($id, $data);

            $logDetails = sprintf(
                'Sửa cổng thanh toán: Tên - %s',
                $paymentGateway->name,
            );

            event(new AdminActivityLogged(
                auth()->user()->id,
                'Sửa',
                $logDetails
            ));

            return redirect()->route('admin.paymentgateways.index')->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            Log::error("Error updating payment gateways: " . $e->getMessage());
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật.')->withInput();
        }
    }

    public function destroy($id, Request $request)
    {
        $paymentGateway = PaymentGateway::findOrFail($id);

        if ($request->forceDelete === 'true') {
            $paymentGateway->forceDelete();
        } else {
            $paymentGateway->delete();
        }

        $logDetails = sprintf(
            'Xóa cổng thanh toán: Tên - %s',
            $paymentGateway->name,
        );

        event(new AdminActivityLogged(
            auth()->user()->id,
            'Xóa',
            $logDetails
        ));

        return redirect()->route('admin.paymentgateways.index')->with('success', 'Xóa thành công');
    }

    public function deleteMultiple(Request $request)
    {
        $ids = json_decode($request->ids);
        $forceDelete = $request->forceDelete === 'true';

        foreach ($ids as $id) {
            $paymentGateway = PaymentGateway::find($id);
            if ($forceDelete) {
                $paymentGateway->forceDelete();
            } else {
                $paymentGateway->delete();
            }
        }

        return response()->json(['success' => true, 'message' => 'Cổng thanh toán đã được xóa.']);
    }
}
