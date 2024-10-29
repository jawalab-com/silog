<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StoreSalesOrderRequest;
use App\Http\Requests\UpdateSalesOrderRequest;
use App\Models\InventoryTransaction;
use App\Models\SalesOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SalesOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $formType = $request->input('formType', 'sales-order');
        if ($formType == 'sales-order') {
            $statuses = [OrderStatus::SUBMISSION_APPROVED, OrderStatus::COMPLETED, OrderStatus::CANCELLED, OrderStatus::REFUNDED];
        } else {
            $statuses = [OrderStatus::SUBMISSION_PENDING, OrderStatus::SUBMISSION_APPROVED, OrderStatus::SUBMISSION_REJECTED];
        }
        $salesOrders = SalesOrder::whereIn('status', $statuses)
            ->with('supplier')
            ->with('user')
            ->orderBy('order_date', 'desc')
            ->get();

        return Inertia::render('SalesOrders/Index', [
            'formType' => $formType,
            'salesOrders' => $salesOrders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $formType = $request->input('formType', 'sales-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $po = new SalesOrder;
        $po->generateNumber();

        return Inertia::render('SalesOrders/Form', [
            'suppliers' => $suppliers,
            'salesOrder' => $po,
            'formType' => $formType,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSalesOrderRequest $request)
    {
        $formType = $request->input('formType', 'sales-order');

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = OrderStatus::SUBMISSION_PENDING;
        $data['total_amount'] = 0;
        try {
            $salesOrder = SalesOrder::create($data);
            foreach ($data['details'] as $key => $detail) {
                $salesOrder->salesOrderDetails()->create($detail);
                InventoryTransaction::create([
                    'product_id' => $detail['product_id'],
                    'quantity_change' => 0,
                    'transaction_type' => OrderStatus::SUBMISSION_PENDING,
                    'reference_id' => $salesOrder->id,
                    'transaction_date' => $salesOrder->order_date,
                    'user_id' => auth()->id(),
                    'note' => 'Input data pengajuan pembelian',
                ]);
            }

            return redirect()->route('sales-orders.index', ['formType' => $request->form_type])
                ->with('success', 'SalesOrder created successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesOrder $salesOrder, Request $request): Response
    {
        $formType = $request->input('formType', 'sales-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $data = $salesOrder->toArray();
        foreach ($salesOrder->salesOrderDetails()->get() as $key => $detail) {
            $data['details'][$key] = $detail->toArray();
            $data['details'][$key]['product_label'] = $detail->product->product_name;
        }

        return Inertia::render('SalesOrders/Show', [
            'suppliers' => $suppliers,
            'salesOrder' => $data,
            'formType' => $formType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesOrder $salesOrder, Request $request)
    {
        $formType = $request->input('formType', 'sales-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $data = $salesOrder->toArray();
        foreach ($salesOrder->salesOrderDetails()->get() as $key => $detail) {
            $data['details'][$key] = $detail->toArray();
            $data['details'][$key]['product_label'] = $detail->product->product_name;
        }

        return Inertia::render('SalesOrders/Form', [
            'suppliers' => $suppliers,
            'salesOrder' => $data,
            'formType' => $formType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSalesOrderRequest $request, SalesOrder $salesOrder)
    {
        $data = $request->validated();
        $data['status'] = $request->input('status', OrderStatus::SUBMISSION_PENDING);
        if ($request->form_type === 'sales-order') {
            $data['user_id'] = auth()->id();
            $data['total_amount'] = 0;
        }

        try {
            $salesOrder->update($data);
            if ($request->has('details')) {
                $salesOrder->salesOrderDetails()->delete();
                foreach ($data['details'] as $key => $detail) {
                    $salesOrder->salesOrderDetails()->create($detail);
                    switch ($data['status']) {
                        case OrderStatus::SUBMISSION_PENDING->value:
                            $quantityChange = 0;
                            $note = 'Input data pengajuan pembelian';
                            break;
                        case OrderStatus::SUBMISSION_APPROVED->value:
                            $quantityChange = $detail['quantity'];
                            $note = 'Pengajuan pembelian disetujui';
                            break;
                        case OrderStatus::SUBMISSION_REJECTED->value:
                            $quantityChange = 0;
                            $note = 'Pembelian ditolak';
                            break;
                        default:
                            $quantityChange = 0;
                            $note = '';
                            break;
                    }
                    InventoryTransaction::create([
                        'product_id' => $detail['product_id'],
                        'quantity_change' => $quantityChange,
                        'transaction_type' => $data['status'],
                        'reference_id' => $salesOrder->id,
                        'transaction_date' => $salesOrder->order_date,
                        'user_id' => auth()->id(),
                        'note' => $note,
                    ]);
                }
            }

            return redirect()->route('sales-orders.index', ['formType' => $request->form_type])
                ->with('success', 'Data updated successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesOrder $salesOrder)
    {
        $salesOrder->delete();

        return redirect()->route('sales-orders.index')
            ->with('success', 'Data deleted successfully.');
    }
}
