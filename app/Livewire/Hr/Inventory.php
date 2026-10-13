<?php

namespace App\Livewire\Hr;

use App\Models\ApprovalAction;
use App\Models\ApprovalRequest;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\Project;
use App\Models\PurchaseOrder;
use App\Models\PurchaseRequest;
use App\Models\Worker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Inventory extends Component
{
    public array $requestItems = [['material_id' => '', 'quantity' => '', 'notes' => '']];

    public array $stockMovement = [
        'type' => 'issue',
        'material_id' => '',
        'project_id' => '',
        'worker_id' => '',
        'quantity' => '',
        'notes' => '',
    ];

    public ?string $requiredBy = null;

    public ?string $requestNotes = null;

    public ?string $requestProjectId = null;

    public function addRequestItem(): void
    {
        $this->requestItems[] = ['material_id' => '', 'quantity' => '', 'notes' => ''];
    }

    public function removeRequestItem(int $index): void
    {
        if (count($this->requestItems) > 1 && isset($this->requestItems[$index])) {
            unset($this->requestItems[$index]);
            $this->requestItems = array_values($this->requestItems);
        }
    }

    public function submitRequest(): void
    {
        abort_unless(auth()->user()?->role?->name === 'hr', 403);

        $this->validate([
            'requestItems' => ['required', 'array', 'min:1'],
            'requestItems.*.material_id' => ['required', 'integer', 'distinct', 'exists:materials,id'],
            'requestItems.*.quantity' => ['required', 'numeric', 'gt:0'],
            'requestItems.*.notes' => ['nullable', 'string', 'max:255'],
            'requiredBy' => ['nullable', 'date', 'after_or_equal:today'],
            'requestProjectId' => ['nullable', 'integer', 'exists:projects,id'],
            'requestNotes' => ['nullable', 'string', 'max:2000'],
        ]);

        foreach ($this->requestItems as $item) {
            if (! Material::whereKey($item['material_id'])->where('is_active', true)->exists()) {
                throw ValidationException::withMessages([
                    'requestItems' => 'Inactive materials cannot be requested.',
                ]);
            }
        }

        DB::transaction(function () {
            $request = PurchaseRequest::create([
                'request_number' => 'PR-'.now()->format('Ymd').'-'.Str::upper(Str::random(6)),
                'project_id' => $this->requestProjectId ?: null,
                'requested_by' => auth()->id(),
                'status' => 'pending',
                'required_by' => $this->requiredBy,
                'notes' => $this->requestNotes,
            ]);

            foreach ($this->requestItems as $item) {
                $request->items()->create([
                    'material_id' => $item['material_id'],
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?: null,
                ]);
            }

            $approval = ApprovalRequest::create([
                'request_type' => 'purchase',
                'subject_type' => 'purchase_request',
                'subject_id' => $request->id,
                'project_id' => $request->project_id,
                'title' => 'Purchase request '.$request->request_number,
                'details' => $request->notes,
                'status' => 'pending',
                'requested_by' => auth()->id(),
            ]);
            ApprovalAction::create([
                'approval_request_id' => $approval->id,
                'user_id' => auth()->id(),
                'action' => 'submitted',
                'from_status' => 'new',
                'to_status' => 'pending',
                'notes' => 'Submitted for Admin review.',
            ]);
        });

        $this->requestItems = [['material_id' => '', 'quantity' => '', 'notes' => '']];
        $this->requiredBy = null;
        $this->requestProjectId = null;
        $this->requestNotes = null;
        session()->flash('success', 'Purchase request submitted for Admin approval.');
    }

    public function recordStockMovement(): void
    {
        abort_unless(auth()->user()?->role?->name === 'hr', 403);

        $validated = $this->validate([
            'stockMovement.type' => ['required', 'in:issue,return'],
            'stockMovement.material_id' => ['required', 'integer', 'exists:materials,id'],
            'stockMovement.project_id' => ['required', 'integer', 'exists:projects,id'],
            'stockMovement.worker_id' => ['nullable', 'integer', 'exists:workers,id'],
            'stockMovement.quantity' => ['required', 'numeric', 'gt:0'],
            'stockMovement.notes' => ['nullable', 'string', 'max:2000'],
        ])['stockMovement'];

        DB::transaction(function () use ($validated) {
            $material = Material::whereKey($validated['material_id'])->lockForUpdate()->firstOrFail();
            abort_unless($material->is_active, 422, 'Inactive materials cannot be issued or returned.');

            $balance = (float) $material->on_hand;
            $quantity = (float) $validated['quantity'];
            if ($validated['type'] === 'issue' && $quantity > $balance) {
                throw ValidationException::withMessages([
                    'stockMovement.quantity' => 'Issue quantity exceeds available stock.',
                ]);
            }

            if ($validated['type'] === 'return') {
                $issued = InventoryTransaction::where('material_id', $material->id)
                    ->where('project_id', $validated['project_id'])
                    ->where('type', 'issue');
                $returned = InventoryTransaction::where('material_id', $material->id)
                    ->where('project_id', $validated['project_id'])
                    ->where('type', 'return');

                if ($validated['worker_id']) {
                    $issued->where('worker_id', $validated['worker_id']);
                    $returned->where('worker_id', $validated['worker_id']);
                } else {
                    $issued->whereNull('worker_id');
                    $returned->whereNull('worker_id');
                }

                if ($quantity > (float) $issued->sum('quantity') - (float) $returned->sum('quantity')) {
                    throw ValidationException::withMessages([
                        'stockMovement.quantity' => 'Return quantity exceeds the outstanding issue amount.',
                    ]);
                }
            }

            $unitCost = $material->average_unit_cost;
            InventoryTransaction::create([
                'material_id' => $material->id,
                'project_id' => $validated['project_id'],
                'worker_id' => $validated['worker_id'] ?: null,
                'user_id' => auth()->id(),
                'type' => $validated['type'],
                'quantity' => $quantity,
                'unit_cost' => $unitCost,
                'transaction_date' => today(),
                'reference' => 'MANUAL-'.now()->format('YmdHis'),
                'notes' => $validated['notes'] ?: null,
            ]);
        });

        $this->stockMovement['quantity'] = '';
        $this->stockMovement['notes'] = '';
        session()->flash('success', 'Stock movement recorded.');
    }

    public function receiveOrderItem(int $orderItemId): void
    {
        abort_unless(in_array(auth()->user()?->role?->name, ['admin', 'hr'], true), 403);
        $quantity = $this->validate([
            "receivingQuantities.$orderItemId" => ['required', 'numeric', 'gt:0'],
        ])['receivingQuantities'][$orderItemId];

        DB::transaction(function () use ($orderItemId, $quantity) {
            $item = \App\Models\PurchaseOrderItem::with(['order.purchaseRequest'])
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

    public array $receivingQuantities = [];

    public function render()
    {
        return view('livewire.hr.inventory', [
            'materials' => Material::where('is_active', true)->orderBy('name')->get(),
            'stockMaterials' => Material::select('materials.*')->selectSub(
                InventoryTransaction::selectRaw("COALESCE(SUM(CASE WHEN type IN ('receipt', 'return') THEN quantity WHEN type = 'issue' THEN -quantity ELSE 0 END), 0)")
                    ->whereColumn('material_id', 'materials.id'),
                'stock_on_hand'
            )->orderBy('name')->get(),
            'projects' => Project::orderBy('name')->get(),
            'workers' => Worker::where('status', 'active')->orderBy('name')->get(),
            'requests' => PurchaseRequest::with(['items.material', 'project'])
                ->where('requested_by', auth()->id())->latest()->limit(15)->get(),
            'orders' => PurchaseOrder::with(['supplier', 'items.material'])
                ->whereIn('status', ['issued', 'partially_received'])->latest()->get(),
        ])->layout('layouts.hrmanagerdashboard');
    }
}
