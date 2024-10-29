<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Http\Requests\StorePurchaseOrderRequest;
use App\Http\Requests\UpdatePurchaseOrderRequest;
use App\Models\InventoryTransaction;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $formType = $request->input('formType', 'purchase-order');
        if ($formType == 'purchase-order') {
            $statuses = [OrderStatus::SUBMISSION_APPROVED, OrderStatus::COMPLETED, OrderStatus::CANCELLED, OrderStatus::REFUNDED];
        } else {
            $statuses = [OrderStatus::SUBMISSION_PENDING, OrderStatus::SUBMISSION_APPROVED, OrderStatus::SUBMISSION_REJECTED];
        }
        $purchaseOrders = PurchaseOrder::whereIn('status', $statuses)
            ->with('supplier')
            ->with('user')
            ->orderBy('order_date', 'desc')
            ->get();

        return Inertia::render('PurchaseOrders/Index', [
            'formType' => $formType,
            'purchaseOrders' => $purchaseOrders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $formType = $request->input('formType', 'purchase-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $po = new PurchaseOrder;
        $po->generateNumber();

        return Inertia::render('PurchaseOrders/Form', [
            'suppliers' => $suppliers,
            'purchaseOrder' => $po,
            'formType' => $formType,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseOrderRequest $request)
    {
        $formType = $request->input('formType', 'purchase-order');

        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = OrderStatus::SUBMISSION_PENDING;
        $data['total_amount'] = 0;
        try {
            $purchaseOrder = PurchaseOrder::create($data);
            foreach ($data['details'] as $key => $detail) {
                $purchaseOrder->purchaseOrderDetails()->create($detail);
                InventoryTransaction::create([
                    'product_id' => $detail['product_id'],
                    'quantity_change' => 0,
                    'transaction_type' => OrderStatus::SUBMISSION_PENDING,
                    'reference_id' => $purchaseOrder->id,
                    'transaction_date' => $purchaseOrder->order_date,
                    'user_id' => auth()->id(),
                    'note' => 'Input data pengajuan pembelian',
                ]);
            }

            return redirect()->route('purchase-orders.index', ['formType' => $request->form_type])
                ->with('success', 'PurchaseOrder created successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseOrder $purchaseOrder, Request $request): Response
    {
        $formType = $request->input('formType', 'purchase-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $data = $purchaseOrder->toArray();
        foreach ($purchaseOrder->purchaseOrderDetails()->get() as $key => $detail) {
            $data['details'][$key] = $detail->toArray();
            $data['details'][$key]['product_label'] = $detail->product->product_name;
            $data['details'][$key]['stock'] = $detail->product->inventory?->quantity ?? 0;
        }

        return Inertia::render('PurchaseOrders/Show', [
            'suppliers' => $suppliers,
            'purchaseOrder' => $data,
            'formType' => $formType,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseOrder $purchaseOrder, Request $request)
    {
        $formType = $request->input('formType', 'purchase-order');
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $data = $purchaseOrder->toArray();
        foreach ($purchaseOrder->purchaseOrderDetails()->get() as $key => $detail) {
            $data['details'][$key] = $detail->toArray();
            $data['details'][$key]['product_label'] = $detail->product->product_name;
        }

        return Inertia::render('PurchaseOrders/Form', [
            'suppliers' => $suppliers,
            'purchaseOrder' => $data,
            'formType' => $formType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseOrderRequest $request, PurchaseOrder $purchaseOrder)
    {
        $data = $request->validated();
        $data['status'] = $request->input('status', OrderStatus::SUBMISSION_PENDING);
        if ($request->form_type === 'purchase-order') {
            $data['user_id'] = auth()->id();
            $data['total_amount'] = 0;
        }

        try {
            $purchaseOrder->update($data);
            if ($request->has('details')) {
                $purchaseOrder->purchaseOrderDetails()->delete();
                foreach ($data['details'] as $key => $detail) {
                    $purchaseOrder->purchaseOrderDetails()->create($detail);
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
                        'reference_id' => $purchaseOrder->id,
                        'transaction_date' => $purchaseOrder->order_date,
                        'user_id' => auth()->id(),
                        'note' => $note,
                    ]);
                }
            }

            return redirect()->route('purchase-orders.index', ['formType' => $request->form_type])
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
    public function destroy(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->delete();

        return redirect()->route('purchase-orders.index')
            ->with('success', 'Data deleted successfully.');
    }
}
