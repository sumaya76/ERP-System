<?php

namespace App\Livewire\Admin;

use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\PurchaseRequest;
use App\Models\Supplier;
use App\Models\SupplierQuotation;
use App\Models\SupplierQuotationItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Procurement extends Component
{
    public array $supplierForm = ['name' => '', 'contact_person' => '', 'email' => '', 'phone' => '', 'tax_number' => ''];

    public array $materialForm = ['sku' => '', 'name' => '', 'category' => '', 'unit' => 'unit', 'reorder_level' => '0'];

    public ?int $quoteRequestId = null;

    public ?int $quoteSupplierId = null;

    public ?string $quoteNumber = null;

    public ?string $quoteValidUntil = null;

    public array $quoteItems = [];

    public ?string $reviewNote = null;

    public array $receivingQuantities = [];

    public function saveSupplier(): void
    {
        $this->ensureAdmin();
        $data = $this->validate([
            'supplierForm.name' => ['required', 'string', 'max:255'],
            'supplierForm.contact_person' => ['nullable', 'string', 'max:255'],
            'supplierForm.email' => ['nullable', 'email', 'max:255'],
            'supplierForm.phone' => ['nullable', 'string', 'max:50'],
            'supplierForm.tax_number' => ['nullable', 'string', 'max:100'],
        ])['supplierForm'];

        Supplier::create($data);
        $this->supplierForm = ['name' => '', 'contact_person' => '', 'email' => '', 'phone' => '', 'tax_number' => ''];
        session()->flash('success', 'Supplier added.');
    }

    public function saveMaterial(): void
    {
        $this->ensureAdmin();
        $data = $this->validate([
            'materialForm.sku' => ['required', 'string', 'max:100', 'unique:materials,sku'],
            'materialForm.name' => ['required', 'string', 'max:255'],
            'materialForm.category' => ['nullable', 'string', 'max:100'],
            'materialForm.unit' => ['required', 'string', 'max:50'],
            'materialForm.reorder_level' => ['required', 'numeric', 'min:0'],
        ])['materialForm'];

        Material::create($data);
        $this->materialForm = ['sku' => '', 'name' => '', 'category' => '', 'unit' => 'unit', 'reorder_level' => '0'];
        session()->flash('success', 'Material added to inventory catalog.');
    }

    public function approveRequest(int $requestId): void
    {
        $this->ensureAdmin();
        DB::transaction(function () use ($requestId) {
            $request = PurchaseRequest::whereKey($requestId)->where('status', 'pending')->lockForUpdate()->firstOrFail();
            $request->update([
                'status' => 'approved',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_notes' => $this->reviewNote ?: null,
            ]);
            $this->syncApprovalHistory($request->id, 'approved', $this->reviewNote);
        });
        $this->reviewNote = null;
        session()->flash('success', 'Purchase request approved. Supplier quotations can now be compared.');
    }

    public function rejectRequest(int $requestId): void
    {
        $this->ensureAdmin();
        $this->validate(['reviewNote' => ['required', 'string', 'min:3', 'max:2000']]);
        DB::transaction(function () use ($requestId) {
            $request = PurchaseRequest::whereKey($requestId)->where('status', 'pending')->lockForUpdate()->firstOrFail();
            $request->update([
                'status' => 'rejected',
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'review_notes' => $this->reviewNote,
            ]);
            $this->syncApprovalHistory($request->id, 'rejected', $this->reviewNote);
        });
        $this->reviewNote = null;
        session()->flash('success', 'Purchase request rejected with a recorded reason.');
    }

    public function prepareQuotation(int $requestId): void
    {
        $this->ensureAdmin();
        $request = PurchaseRequest::with('items.material')
            ->whereKey($requestId)->where('status', 'approved')->firstOrFail();
        $this->quoteRequestId = $request->id;
        $this->quoteSupplierId = null;
        $this->quoteNumber = null;
        $this->quoteValidUntil = null;
        $this->quoteItems = $request->items->map(fn ($item) => [
            'request_item_id' => $item->id,
            'quantity' => $item->quantity,
            'unit_price' => '',
            'lead_time_days' => 0,
        ])->all();
    }

    public function saveQuotation(): void
    {
        $this->ensureAdmin();
        $validated = $this->validate([
            'quoteRequestId' => ['required', 'integer', 'exists:purchase_requests,id'],
            'quoteSupplierId' => ['required', 'integer', 'exists:suppliers,id'],
            'quoteNumber' => [
                'required',
                'string',
                'max:100',
                Rule::unique('supplier_quotations', 'quotation_number')->where('supplier_id', $this->quoteSupplierId),
            ],
            'quoteValidUntil' => ['nullable', 'date'],
            'quoteItems' => ['required', 'array', 'min:1'],
            'quoteItems.*.request_item_id' => ['required', 'integer', 'distinct', 'exists:purchase_request_items,id'],
            'quoteItems.*.quantity' => ['required', 'numeric', 'gt:0'],
            'quoteItems.*.unit_price' => ['required', 'numeric', 'min:0'],
            'quoteItems.*.lead_time_days' => ['required', 'integer', 'min:0'],
        ]);
        if (SupplierQuotation::where('purchase_request_id', $validated['quoteRequestId'])
            ->where('supplier_id', $validated['quoteSupplierId'])->exists()) {
            throw ValidationException::withMessages([
                'quoteSupplierId' => 'This supplier already has a quotation for the selected request.',
            ]);
        }

        DB::transaction(function () use ($validated) {
            $request = PurchaseRequest::with('items')
                ->whereKey($validated['quoteRequestId'])->where('status', 'approved')->firstOrFail();
            $requestItems = $request->items->keyBy('id');
            $quotedItems = collect($validated['quoteItems'])->keyBy('request_item_id');

            if ($requestItems->count() !== $quotedItems->count()) {
                throw ValidationException::withMessages(['quoteItems' => 'Quote every requested material exactly once.']);
            }
            foreach ($requestItems as $requestItem) {
                $quoted = $quotedItems->get($requestItem->id);
                if (! $quoted || (float) $quoted['quantity'] < (float) $requestItem->quantity) {
                    throw ValidationException::withMessages([
                        'quoteItems' => 'Each quotation must cover the full requested quantity.',
                    ]);
                }
            }

            $quotation = SupplierQuotation::create([
                'purchase_request_id' => $request->id,
                'supplier_id' => $validated['quoteSupplierId'],
                'quotation_number' => $validated['quoteNumber'],
                'valid_until' => $validated['quoteValidUntil'],
                'entered_by' => auth()->id(),
            ]);

            foreach ($validated['quoteItems'] as $item) {
                SupplierQuotationItem::create([
                    'supplier_quotation_id' => $quotation->id,
                    'purchase_request_item_id' => $item['request_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                    'lead_time_days' => $item['lead_time_days'],
                ]);
            }
        });

        $this->quoteRequestId = null;
        $this->quoteSupplierId = null;
        $this->quoteNumber = null;
        $this->quoteValidUntil = null;
        $this->quoteItems = [];
        session()->flash('success', 'Supplier quotation saved for comparison.');
    }

    public function createPurchaseOrder(int $quotationId): void
    {
        $this->ensureAdmin();
        DB::transaction(function () use ($quotationId) {
            $quotation = SupplierQuotation::with(['purchaseRequest.items', 'items'])
                ->whereKey($quotationId)->lockForUpdate()->firstOrFail();
            $request = PurchaseRequest::whereKey($quotation->purchase_request_id)
                ->where('status', 'approved')->lockForUpdate()->firstOrFail();

            if ($request->order()->exists()) {
                throw ValidationException::withMessages(['quoteRequestId' => 'A purchase order already exists for this request.']);
            }
            $quoted = $quotation->items->keyBy('purchase_request_item_id');
            if ($request->items->count() !== $quoted->count()) {
                throw ValidationException::withMessages(['quoteRequestId' => 'The selected quotation is incomplete.']);
            }

            $order = PurchaseOrder::create([
                'order_number' => 'PO-'.now()->format('Ymd').'-'.Str::upper(Str::random(8)),
                'purchase_request_id' => $request->id,
                'supplier_id' => $quotation->supplier_id,
                'supplier_quotation_id' => $quotation->id,
                'created_by' => auth()->id(),
                'status' => 'issued',
                'ordered_at' => now(),
            ]);

            foreach ($request->items as $requestItem) {
                $quoteItem = $quoted->get($requestItem->id);
                if (! $quoteItem || (float) $quoteItem->quantity < (float) $requestItem->quantity) {
                    throw ValidationException::withMessages(['quoteRequestId' => 'The selected quotation does not cover the request.']);
                }
                $order->items()->create([
                    'purchase_request_item_id' => $requestItem->id,
                    'material_id' => $requestItem->material_id,
                    'quantity' => $requestItem->quantity,
                    'unit_price' => $quoteItem->unit_price,
                ]);
            }

            $request->update(['status' => 'ordered']);
        });

        session()->flash('success', 'Purchase order created. Record deliveries when goods arrive.');
    }

    public function receiveItem(int $orderItemId): void
    {
        $this->ensureAdmin();
        $quantity = $this->validate([
            "receivingQuantities.$orderItemId" => ['required', 'numeric', 'gt:0'],
        ])['receivingQuantities'][$orderItemId];

        DB::transaction(function () use ($orderItemId, $quantity) {
            $item = PurchaseOrderItem::with(['order.purchaseRequest', 'material'])
                ->whereKey($orderItemId)->lockForUpdate()->firstOrFail();
            $order = PurchaseOrder::whereKey($item->purchase_order_id)->lockForUpdate()->firstOrFail();
            if (! in_array($order->status, ['issued', 'partially_received'], true)) {
                throw ValidationException::withMessages(['receivingQuantities' => 'This order is not open for receiving.']);
            }
            $remaining = (float) $item->quantity - (float) $item->received_quantity;
            if ((float) $quantity > $remaining) {
                throw ValidationException::withMessages([
                    "receivingQuantities.$orderItemId" => 'Received quantity cannot exceed the outstanding order quantity.',
                ]);
            }

            Material::whereKey($item->material_id)->lockForUpdate()->firstOrFail();
            $item->update(['received_quantity' => (float) $item->received_quantity + (float) $quantity]);
            InventoryTransaction::create([
                'material_id' => $item->material_id,
                'project_id' => $order->purchaseRequest->project_id,
                'user_id' => auth()->id(),
                'purchase_order_item_id' => $item->id,
                'type' => 'receipt',
                'quantity' => $quantity,
                'unit_cost' => $item->unit_price,
                'transaction_date' => today(),
                'reference' => $order->order_number,
                'notes' => 'Received against purchase order '.$order->order_number,
            ]);

            $allReceived = $order->items()->whereColumn('received_quantity', '<', 'quantity')->doesntExist();
            $order->update(['status' => $allReceived ? 'received' : 'partially_received']);
            if ($allReceived) {
                $order->purchaseRequest()->update(['status' => 'completed']);
            }
        });

        unset($this->receivingQuantities[$orderItemId]);
        session()->flash('success', 'Delivery quantity received into inventory.');
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->user()?->role?->name === 'admin', 403);
    }

    private function syncApprovalHistory(int $purchaseRequestId, string $decision, ?string $note): void
    {
        $approval = ApprovalRequest::where('subject_type', 'purchase_request')
            ->where('subject_id', $purchaseRequestId)->where('status', 'pending')->first();
        if (! $approval) {
            return;
        }

        $approval->update([
            'status' => $decision,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
        ApprovalAction::create([
            'approval_request_id' => $approval->id,
            'user_id' => auth()->id(),
            'action' => $decision,
            'from_status' => 'pending',
            'to_status' => $decision,
            'notes' => $note,
        ]);
    }

    public function render()
    {
        $this->ensureAdmin();

        return view('livewire.admin.procurement', [
            'suppliers' => Supplier::where('is_active', true)->orderBy('name')->get(),
            'materials' => Material::select('materials.*')->selectSub(
                InventoryTransaction::selectRaw("COALESCE(SUM(CASE WHEN type IN ('receipt', 'return') THEN quantity WHEN type = 'issue' THEN -quantity ELSE 0 END), 0)")
                    ->whereColumn('material_id', 'materials.id'),
                'stock_on_hand'
            )->orderBy('name')->get(),
            'requests' => PurchaseRequest::with(['items.material', 'project', 'requester', 'quotations.supplier', 'quotations.items'])
                ->whereIn('status', ['pending', 'approved'])->latest()->get(),
            'orders' => PurchaseOrder::with(['supplier', 'purchaseRequest.project', 'items.material'])
                ->latest()->limit(30)->get(),
        ])->layout('layouts.admindashboard');
    }
}
