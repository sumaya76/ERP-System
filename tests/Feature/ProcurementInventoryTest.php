<?php

namespace Tests\Feature;

use App\Livewire\Admin\Procurement;
use App\Livewire\Hr\Inventory;
use App\Models\InventoryTransaction;
use App\Models\Material;
use App\Models\PurchaseRequest;
use App\Models\Role;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ProcurementInventoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_hr_request_admin_approval_quote_order_and_receipt_update_stock(): void
    {
        $hr = $this->createUser('hr');
        $admin = $this->createUser('admin');
        $material = Material::create([
            'sku' => 'CEM-001',
            'name' => 'Cement',
            'unit' => 'bag',
            'reorder_level' => 5,
            'is_active' => true,
        ]);
        $supplier = Supplier::create(['name' => 'Reliable Supplies', 'is_active' => true]);

        $this->actingAs($hr);
        Livewire::test(Inventory::class)
            ->set('requestItems', [['material_id' => $material->id, 'quantity' => 10, 'notes' => null]])
            ->call('submitRequest')
            ->assertHasNoErrors();

        $request = PurchaseRequest::with('items')->firstOrFail();
        $this->assertSame('pending', $request->status);
        $this->assertDatabaseHas('purchase_request_items', [
            'purchase_request_id' => $request->id,
            'material_id' => $material->id,
            'quantity' => 10,
        ]);

        $this->actingAs($admin);
        Livewire::test(Procurement::class)
            ->call('approveRequest', $request->id)
            ->assertHasNoErrors()
            ->call('prepareQuotation', $request->id)
            ->set('quoteSupplierId', $supplier->id)
            ->set('quoteNumber', 'RS-Q-1001')
            ->set('quoteItems.0.unit_price', 8.5)
            ->call('saveQuotation')
            ->assertHasNoErrors();

        $quotation = $request->fresh()->quotations()->firstOrFail();
        Livewire::test(Procurement::class)
            ->call('createPurchaseOrder', $quotation->id)
            ->assertHasNoErrors();

        $order = $request->fresh()->order()->with('items')->firstOrFail();
        $this->assertSame('ordered', $request->fresh()->status);
        $this->actingAs($hr);
        Livewire::test(Inventory::class)
            ->set("receivingQuantities.{$order->items->first()->id}", 6)
            ->call('receiveOrderItem', $order->items->first()->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('purchase_orders', ['id' => $order->id, 'status' => 'partially_received']);
        $this->assertDatabaseHas('inventory_transactions', [
            'material_id' => $material->id,
            'purchase_order_item_id' => $order->items->first()->id,
            'type' => 'receipt',
            'quantity' => 6,
        ]);
        $this->assertSame(6.0, $material->fresh()->on_hand);

        Livewire::test(Inventory::class)
            ->set("receivingQuantities.{$order->items->first()->id}", 4)
            ->call('receiveOrderItem', $order->items->first()->id)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('purchase_orders', ['id' => $order->id, 'status' => 'received']);
        $this->assertSame('completed', $request->fresh()->status);
        $this->assertSame(10.0, $material->fresh()->on_hand);
    }

    public function test_hr_stock_issue_cannot_exceed_balance_and_return_cannot_exceed_issued_stock(): void
    {
        $hr = $this->createUser('hr');
        $material = Material::create([
            'sku' => 'STEEL-001',
            'name' => 'Steel bar',
            'unit' => 'piece',
            'reorder_level' => 0,
            'is_active' => true,
        ]);
        $project = \App\Models\Project::create([
            'name' => 'Test project',
            'project_code' => 'TST-001',
            'client_name' => 'Test client',
            'status' => 'ongoing',
        ]);
        InventoryTransaction::create([
            'material_id' => $material->id,
            'user_id' => $hr->id,
            'type' => 'receipt',
            'quantity' => 8,
            'transaction_date' => today(),
        ]);

        $this->actingAs($hr);
        Livewire::test(Inventory::class)
            ->set('stockMovement', [
                'type' => 'issue',
                'material_id' => $material->id,
                'project_id' => $project->id,
                'worker_id' => '',
                'quantity' => 9,
                'notes' => '',
            ])
            ->call('recordStockMovement')
            ->assertHasErrors('stockMovement.quantity');

        Livewire::test(Inventory::class)
            ->set('stockMovement', [
                'type' => 'issue',
                'material_id' => $material->id,
                'project_id' => $project->id,
                'worker_id' => '',
                'quantity' => 5,
                'notes' => '',
            ])
            ->call('recordStockMovement')
            ->assertHasNoErrors();

        Livewire::test(Inventory::class)
            ->set('stockMovement', [
                'type' => 'return',
                'material_id' => $material->id,
                'project_id' => $project->id,
                'worker_id' => '',
                'quantity' => 6,
                'notes' => '',
            ])
            ->call('recordStockMovement')
            ->assertHasErrors('stockMovement.quantity');

        Livewire::test(Inventory::class)
            ->set('stockMovement', [
                'type' => 'return',
                'material_id' => $material->id,
                'project_id' => $project->id,
                'worker_id' => '',
                'quantity' => 2,
                'notes' => '',
            ])
            ->call('recordStockMovement')
            ->assertHasNoErrors();

        $this->assertSame(5.0, $material->fresh()->on_hand);
    }

    private function createUser(string $roleName): User
    {
        $role = Role::firstOrCreate(['name' => $roleName]);

        return User::create([
            'name' => ucfirst($roleName).' User',
            'email' => $roleName.'@example.test',
            'password' => 'password',
            'role_id' => $role->id,
            'status' => 'active',
        ]);
    }
}
