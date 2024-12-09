<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequisitionRequest;
use App\Http\Requests\UpdatePurchaseRequisitionRequest;
use App\Models\PurchaseRequisition;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\Unit;
use App\Services\LogService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PurchaseRequisitionController extends Controller
{
    protected $logService;

    public function __construct(LogService $logService)
    {
        $this->logService = $logService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prs = PurchaseRequisition::with('user')
            ->orderBy('date_created', 'desc')
            ->get();

        return Inertia::render('PurchaseRequisitions/Index', [
            'prs' => $prs,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $tags = Tag::orderBy('tag_name')->get();
        $units = Unit::orderBy('unit_name')->get();
        $pr = new PurchaseRequisition;
        $pr->name = $pr->generateName();

        return Inertia::render('PurchaseRequisitions/Form', [
            'tags' => $tags,
            'units' => $units,
            'pr' => $pr,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePurchaseRequisitionRequest $request)
    {
        $data = $request->all();
        $data['name'] = PurchaseRequisition::generateName();
        $data['user_id'] = auth()->id();
        $data['state'] = 'pending';
        $data['total_amount'] = 0;
        try {
            $pr = PurchaseRequisition::create($data);
            foreach ($data['lines'] as $key => $detail) {
                $pr->purchaseRequisitionLines()->create($detail);
            }

            return redirect()->route('purchase-requisitions.index')
                ->with('success', 'PurchaseRequisition created successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PurchaseRequisition $pr, Request $request): Response
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $tags = [];
        $data = $pr->toArray();
        foreach ($pr->purchaseRequisitionLines()->orderBy('tag')->get() as $key => $detail) {
            $tags[] = $detail->product->tag;
            $data['products'][$key] = $detail->toArray();
            $data['products'][$key]['product_name'] = $detail->product?->product_name;
            $data['products'][$key]['tag_name'] = Tag::where('slug', $detail->product->tag)->first()->tag_name;
            $data['products'][$key]['unit_name'] = $detail->unit?->unit_name;
            $data['products'][$key]['stock'] = $detail->product->inventory?->quantity ?? 0;
            $data['products'][$key]['unit_price'] = $detail->unit_price;
            $data['products'][$key]['total_price'] = $detail->total_price;
        }

        $tags = array_unique($tags);
        $tagSuppliers = [];
        $pr->prSuppliers()->whereNotIn('tag', $tags)->delete();
        foreach ($tags as $tag) {
            $supplier = Supplier::where('tag', $tag)->first();
            if (! $supplier) {
                dd($tag);
            }
            if (! $pr->prSuppliers()->where('tag', $tag)->first()) {
                $pr->prSuppliers()->create(['tag' => $tag, 'supplier_id' => $supplier->id]);
            }
            $tagSuppliers[$tag] = Supplier::where('tag', $tag)->get();
        }

        // $tags = Tag::whereIn('slug', $tags)->get()->toArray();
        // $tags = array_map(function ($tag) {
        //     return $tag['slug'];
        // }, $tags);

        $data['suppliers'] = $pr->prSuppliers()->with(['tag', 'supplier'])->get()->toArray();

        return Inertia::render('PurchaseRequisitions/Show', [
            'suppliers' => $suppliers,
            'tagSuppliers' => $tagSuppliers,
            'prStatus' => PurchaseRequisitionStatus::toArray(),
            'pr' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PurchaseRequisition $pr, Request $request)
    {
        // $suppliers = Supplier::orderBy('supplier_name')->get();
        $tags = Tag::orderBy('tag_name')->get();
        $units = Unit::orderBy('unit_name')->get();
        $data = $pr->toArray();
        foreach ($pr->purchaseRequisitionLines()->get() as $key => $detail) {
            $data['lines'][$key] = $detail->toArray();
            $data['lines'][$key]['product_name'] = $detail->product?->product_name;
        }

        return Inertia::render('PurchaseRequisitions/Form', [
            'tags' => $tags,
            'units' => $units,
            'pr' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePurchaseRequisitionRequest $request, PurchaseRequisition $pr)
    {
        // $this->logService->createLogEntry(
        //     'error',
        //     'Failed to perform action',
        //     'error',
        //     ['action' => 'someAction']
        // );
        $data = $request->all();
        $verified = $request->input('verified', null);
        if (! empty($verified)) {
            switch (auth()->user()->division) {
                case 'kepala-divisi-logistik':
                    $data['verified_1'] = $verified;
                    break;
                case 'admin-gudang':
                    $data['verified_2'] = $verified;
                    break;
                case 'purchasing':
                    $data['verified_3'] = $verified;
                    break;
                case 'Pimpinan STP':
                    $data['verified_4'] = $verified;
                    break;
                default:
                    break;
            }
        }
        $data['status'] = $request->input('status', PurchaseRequisitionStatus::PENDING);
        if ($request->form_type === 'purchase-order') {
            $data['user_id'] = auth()->id();
            $data['total_amount'] = 0;
        }

        try {
            $pr->update($data);
            if ($request->has('products')) {

                // Products
                $pr->purchaseRequisitionLines()->delete();
                foreach ($data['products'] as $key => $detail) {
                    $pr->purchaseRequisitionLines()->create($detail);
                    switch ($data['status']) {
                        case PurchaseRequisitionStatus::PENDING->value:
                            $quantityChange = 0;
                            $note = 'Input data pengajuan pembelian';
                            break;
                        case PurchaseRequisitionStatus::APPROVED->value:
                            $quantityChange = $detail['quantity'];
                            $note = 'Pengajuan pembelian disetujui';
                            break;
                        case PurchaseRequisitionStatus::REJECTED->value:
                            $quantityChange = 0;
                            $note = 'Pembelian ditolak';
                            break;
                        default:
                            $quantityChange = 0;
                            $note = '';
                            break;
                    }
                }

                // Suppliers
                foreach ($data['suppliers'] as $key => $s) {
                    $pr->prSuppliers()
                        ->where('tag', $s['tag']['slug'])
                        ->update(['supplier_id' => $s['supplier_id']]);
                }
            }

            return redirect()->route('purchase-requisitions.index', ['formType' => $request->form_type])
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
    public function destroy(PurchaseRequisition $pr)
    {
        $pr->delete();

        return redirect()->route('purchase-requisitions.index')
            ->with('success', 'Data deleted successfully.');
    }
}
