<?php

namespace App\Http\Controllers;

use App\Enums\RfqStatus;
use App\Http\Requests\StoreRfqRequest;
use App\Http\Requests\UpdateRfqRequest;
use App\Models\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Rfq;
use App\Models\RfqDetail;
use App\Models\Supplier;
use App\Models\Tag;
use App\Models\Unit;
use App\Services\LogService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RfqController extends Controller
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
        $rfqs = Rfq::whereIn('status', array_column(RfqStatus::cases(), 'value'))
            ->with(['user', 'verified_1User', 'verified_2User', 'verified_3User', 'verified_4User'])
            ->orderBy('request_date', 'desc')
            ->get();

        return Inertia::render('Rfqs/Index', [
            'rfqStatus' => RfqStatus::toArray(),
            'rfqs' => $rfqs,
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
        $rfq = new Rfq;
        $rfq->generateNumber();

        return Inertia::render('Rfqs/Form', [
            'tags' => $tags,
            'units' => $units,
            'rfq' => $rfq,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRfqRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();
        $data['status'] = RfqStatus::PENDING;
        $data['total_amount'] = 0;
        try {
            $rfq = Rfq::create($data);
            foreach ($data['products'] as $key => $detail) {
                $rfq->rfqDetails()->create($detail);
            }

            return redirect()->route('rfqs.index')
                ->with('success', 'Rfq created successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rfq $rfq, Request $request): Response
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $tags = [];
        $data = $rfq->toArray();
        foreach ($rfq->rfqDetails()->orderBy('tag')->get() as $key => $detail) {
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
        $rfq->rfqSuppliers()->whereNotIn('tag', $tags)->delete();
        foreach ($tags as $tag) {
            $supplier = Supplier::where('tag', $tag)->first();
            if (! $supplier) {
                dd($tag);
            }
            if (! $rfq->rfqSuppliers()->where('tag', $tag)->first()) {
                $rfq->rfqSuppliers()->create(['tag' => $tag, 'supplier_id' => $supplier->id]);
            }
            $tagSuppliers[$tag] = Supplier::where('tag', $tag)->get();
        }

        // $tags = Tag::whereIn('slug', $tags)->get()->toArray();
        // $tags = array_map(function ($tag) {
        //     return $tag['slug'];
        // }, $tags);

        $data['suppliers'] = $rfq->rfqSuppliers()->with(['tag', 'supplier'])->get()->toArray();

        return Inertia::render('Rfqs/Show', [
            'suppliers' => $suppliers,
            'tagSuppliers' => $tagSuppliers,
            'rfqStatus' => RfqStatus::toArray(),
            'rfq' => $data,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rfq $rfq, Request $request)
    {
        // $suppliers = Supplier::orderBy('supplier_name')->get();
        $tags = Tag::orderBy('tag_name')->get();
        $units = Unit::orderBy('unit_name')->get();
        $data = $rfq->toArray();
        foreach ($rfq->rfqDetails()->get() as $key => $detail) {
            $data['products'][$key] = $detail->toArray();
            $data['products'][$key]['product_name'] = $detail->product?->product_name;
        }

        return Inertia::render('Rfqs/Form', [
            // 'suppliers' => $suppliers,
            'tags' => $tags,
            'units' => $units,
            'rfq' => $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRfqRequest $request, Rfq $rfq)
    {
        // $this->logService->createLogEntry(
        //     'error',
        //     'Failed to perform action',
        //     'error',
        //     ['action' => 'someAction']
        // );
        $data = $request->validated();
        foreach ($data['suppliers'] as $i => $supplierData) {
            if (isset($supplierData['file_proof_path'])) {
                $path = $supplierData['file_proof_path']->store('uploads', 'public');
                $data['suppliers'][$i]['file_proof'] = $path;
            }
            if (isset($supplierData['file_invoice_path'])) {
                $path = $supplierData['file_invoice_path']->store('uploads', 'public');
                $data['suppliers'][$i]['file_invoice'] = $path;
            }
            if (isset($supplierData['file_receipt_path'])) {
                $path = $supplierData['file_receipt_path']->store('uploads', 'public');
                $data['suppliers'][$i]['file_receipt'] = $path;
            }
        }

        $verified = $request->input('verified', null);
        if (! empty($verified)) {
            switch (auth()->user()->teamRole(auth()->user()->currentTeam)->name) {
                case 'pimpinan-gudang':
                    $data['verified_1'] = $verified;
                    $data['verified_1_user_id'] = auth()->id();
                    break;
                case 'admin-gudang':
                    $data['verified_2'] = $verified;
                    $data['verified_2_user_id'] = auth()->id();
                    break;
                case 'purchasing':
                    $data['verified_3'] = $verified;
                    $data['verified_3_user_id'] = auth()->id();
                    $rfq->rfqSuppliers()
                        ->update(['date_sent' => date('Y-m-d'), 'sent' => true]);
                    break;
                case 'Pimpinan STP':
                    if ($verified && $rfq->verified_3) {
                        $data['verified_3'] = null;
                    }
                    $data['verified_4'] = $verified;
                    $data['verified_4_user_id'] = auth()->id();
                    break;
                default:
                    break;
            }
        }
        $data['status'] = $request->input('status', RfqStatus::PENDING);
        if ($request->form_type === 'purchase-order') {
            $data['user_id'] = auth()->id();
            $data['total_amount'] = 0;
        }

        try {
            $rfq->update($data);
            if ($request->has('products')) {

                // Products
                $rfq->rfqDetails()->delete();
                foreach ($data['products'] as $key => $detail) {
                    $rfq->rfqDetails()->create($detail);
                    switch ($data['status']) {
                        case RfqStatus::PENDING->value:
                            $quantityChange = 0;
                            $note = 'Input data pengajuan pembelian';
                            break;
                        case RfqStatus::APPROVED->value:
                            $quantityChange = $detail['quantity'];
                            $note = 'Pengajuan pembelian disetujui';
                            break;
                        case RfqStatus::REJECTED->value:
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
                    $s['tag'] = $s['tag']['slug'];
                    $no = RfqDetail::whereYear('request_date', date('Y'))
                        ->whereMonth('request_date', date('m'))
                        ->count() + 1;
                    $supplier_name = Supplier::find($s['supplier_id'])->supplier_name;
                    $s['po_number'] = implode('/', [$no, $supplier_name, date('m'), date('Y')]);
                    $s = array_filter($s, function ($value) {
                        return ! is_null($value);
                    });
                    unset($s['file_proof_path']);
                    unset($s['file_invoice_path']);
                    unset($s['file_receipt_path']);
                    $rfq->rfqSuppliers()
                        ->where('tag', $s['tag'])
                        ->update($s);
                }
            }

            return redirect()->route('rfqs.index', ['formType' => $request->form_type])
                ->with('success', 'Data updated successfully.');
        } catch (\Exception $e) {
            throw $e;

            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    public function received(Request $request, Rfq $rfq, string $tag)
    {
        // try {
        $rfqSupplier = $rfq->rfqSuppliers()->where('tag', $tag)->first();
        if ($rfqSupplier) {
            $rfqSupplier->update(['received' => true, 'date_received' => date('Y-m-d')]);
        }

        $rfqDetails = $rfq->rfqDetails()->with('product')->whereHas('product', function ($query) use ($tag) {
            $query->where('tag', $tag);
        })->get();

        foreach ($rfqDetails as $product) {
            InventoryTransaction::create([
                'product_id' => $product->product_id,
                'quantity_change' => $product->quantity,
                'transaction_type' => 'RECEIVED_PRODUCT',
                'reference_id' => $rfqSupplier->po_number,
                'transaction_date' => $product->created_at,
                'user_id' => auth()->id(),
                'note' => 'Barang ditambah dari penerimaan Purchase Order No. '.
                    $rfqSupplier->po_number.
                    ' dan Pengajuan No. '.
                    $rfq->rfq_number,
            ]);
            $inv = Inventory::where('product_id', $product->product_id)->first();
            Inventory::updateOrCreate(
                ['product_id' => $product->product_id],
                ['quantity' => ($inv->quantity ?? 0) + $product->quantity]
            );
        }

        return response()->json(['message' => 'Success'], 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Failed'], 500);
        // }
    }

    public function paid(Request $request, Rfq $rfq, string $tag)
    {
        try {
            $rfqSupplier = $rfq->rfqSuppliers()->where('tag', $tag)->first();
            if ($rfqSupplier) {
                $rfqSupplier->update(['paid' => true]);
            }

            return response()->json(['message' => 'Success'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed'], 500);
        }
    }

    public function poPrint(Request $request, Rfq $rfq, string $tag)
    {
        // try {
        // $rfq = $rfq->where('rfq_number', $rfq->rfq_number)->first();
        $supplier = $rfq->rfqSuppliers()->with(['supplier'])->where('tag', $tag)->first();
        $products = $rfq->rfqDetails()->with(['product', 'unit'])->whereHas('product', function ($query) use ($tag) {
            $query->where('tag', $tag);
        })->get();

        return Inertia::render('Rfqs/Print', [
            'rfq' => $rfq,
            'supplier' => $supplier,
            'products' => $products,
        ]);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Failed'], 500);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rfq $rfq)
    {
        $rfq->delete();

        return redirect()->route('rfqs.index')
            ->with('success', 'Data deleted successfully.');
    }
}
