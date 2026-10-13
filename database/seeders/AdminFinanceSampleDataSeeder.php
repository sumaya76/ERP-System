<?php

namespace Database\Seeders;

use App\Models\BudgetItem;
use App\Models\ExpenseCategory;
use App\Models\InvoiceItem;
use App\Models\Project;
use App\Models\ProjectExpense;
use App\Models\SaleInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminFinanceSampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::whereHas('role', fn ($query) => $query->where('name', 'admin'))
            ->where('status', 'active')
            ->orderBy('id')
            ->firstOrFail();

        $today = Carbon::today();

        DB::transaction(function () use ($admin, $today): void {
            $budgetLines = [
                ['section' => 'Masonry', 'description' => 'Foundation and blockwork', 'unit' => 'm²', 'quantity' => 420, 'unit_price' => 85],
                ['section' => 'Electrical', 'description' => 'Electrical installation', 'unit' => 'unit', 'quantity' => 1, 'unit_price' => 18500],
                ['section' => 'Painting', 'description' => 'Interior and exterior painting', 'unit' => 'm²', 'quantity' => 650, 'unit_price' => 45],
            ];
            $quotationSubtotal = collect($budgetLines)->sum(
                fn (array $line) => $line['quantity'] * $line['unit_price']
            );
            $quotationTotal = round($quotationSubtotal * 1.21, 2);

            $quotationProject = Project::updateOrCreate(
                ['project_code' => 'DEMO-ADMIN-Q-001'],
                [
                    'name' => 'Demo Admin - Greenfield Community Center',
                    'quotation_number' => 'DEMO-Q-' . $today->year . '-001',
                    'client_name' => 'Demo Client Three',
                    'client_phone' => '0000000201',
                    'client_email' => 'client.three@example.test',
                    'client_address' => 'Demo Client Address',
                    'location' => 'Demo Site C',
                    'description' => 'Sample quotation project for checking admin finance modules.',
                    'estimated_cost' => $quotationSubtotal,
                    'contract_value' => $quotationTotal,
                    'budget_total' => $quotationTotal,
                    'vat_rate' => 21,
                    'vat_included' => false,
                    'start_date' => $today->copy()->addMonths(2)->toDateString(),
                    'end_date' => $today->copy()->addMonths(8)->toDateString(),
                    'valid_until' => $today->copy()->addDays(30)->toDateString(),
                    'status' => 'planning',
                ]
            );

            foreach ($budgetLines as $index => $line) {
                BudgetItem::updateOrCreate(
                    ['project_id' => $quotationProject->id, 'description' => $line['description']],
                    [
                        'section' => $line['section'],
                        'unit' => $line['unit'],
                        'quantity' => $line['quantity'],
                        'unit_price' => $line['unit_price'],
                        'total' => $line['quantity'] * $line['unit_price'],
                        'notes' => 'Demo admin quotation sample',
                        'sort_order' => $index,
                    ]
                );
            }

            $invoices = [
                [
                    'number' => 'DEMO-INV-' . $today->year . '-001',
                    'date' => $today->copy()->subDays(2),
                    'status' => 'paid',
                    'project_code' => 'DEMO-HR-001',
                    'items' => [
                        ['service' => 'Masonry', 'description' => 'Blockwork installation - completed section', 'unit' => 'm²', 'quantity' => 120, 'price' => 85],
                        ['service' => 'Official Labor Hour', 'description' => 'Site supervision and quality inspection', 'unit' => 'hour', 'quantity' => 24, 'price' => 42],
                    ],
                ],
                [
                    'number' => 'DEMO-INV-' . $today->year . '-002',
                    'date' => $today->copy()->subDays(8),
                    'status' => 'partial',
                    'project_code' => 'DEMO-HR-001',
                    'items' => [
                        ['service' => 'Wall And Floor Tiling', 'description' => 'Lobby floor tiling', 'unit' => 'm²', 'quantity' => 90, 'price' => 68],
                        ['service' => 'Laborer (peon) Hour', 'description' => 'Material handling and site support', 'unit' => 'hour', 'quantity' => 30, 'price' => 24],
                    ],
                ],
                [
                    'number' => 'DEMO-INV-' . $today->year . '-003',
                    'date' => $today->copy()->subDays(38),
                    'status' => 'unpaid',
                    'project_code' => 'DEMO-HR-002',
                    'items' => [
                        ['service' => 'Painting', 'description' => 'Clinic extension primer coat', 'unit' => 'm²', 'quantity' => 160, 'price' => 36],
                        ['service' => 'Official Labor Hour', 'description' => 'Surface preparation and inspection', 'unit' => 'hour', 'quantity' => 18, 'price' => 42],
                    ],
                ],
            ];

            foreach ($invoices as $invoiceData) {
                $invoiceProject = Project::where('project_code', $invoiceData['project_code'])->firstOrFail();
                $subtotal = collect($invoiceData['items'])->sum(
                    fn (array $item) => $item['quantity'] * $item['price']
                );
                $vatPercentage = 21;
                $vatAmount = round($subtotal * $vatPercentage / 100, 2);

                $invoice = SaleInvoice::updateOrCreate(
                    ['invoice_number' => $invoiceData['number']],
                    [
                        'invoice_date' => $invoiceData['date']->toDateString(),
                        'payment_status' => $invoiceData['status'],
                        'company_name' => 'BuildDesk ERP Demo',
                        'company_address' => 'Demo Business Address',
                        'company_cif' => 'DEMO-CIF-001',
                        'company_phone' => '+34 600 000 001',
                        'company_email' => 'billing@example.test',
                        'project_id' => $invoiceProject->id,
                        'client_name' => $invoiceProject->client_name,
                        'client_phone' => $invoiceProject->client_phone,
                        'client_address' => $invoiceProject->location,
                        'subtotal' => $subtotal,
                        'vat_percentage' => $vatPercentage,
                        'vat_amount' => $vatAmount,
                        'total' => $subtotal + $vatAmount,
                        'terms_conditions' => 'Demo invoice. Payment due within 30 days.',
                        'exclusions' => 'Demo record; not a valid tax invoice.',
                        'notes' => 'Demo admin sample data - not a real invoice.',
                        'created_by' => $admin->id,
                    ]
                );

                foreach ($invoiceData['items'] as $itemData) {
                    InvoiceItem::updateOrCreate(
                        [
                            'sale_invoice_id' => $invoice->id,
                            'description' => $itemData['description'],
                        ],
                        [
                            'service_type' => $itemData['service'],
                            'unit' => $itemData['unit'],
                            'quantity' => $itemData['quantity'],
                            'unit_price' => $itemData['price'],
                            'total' => $itemData['quantity'] * $itemData['price'],
                        ]
                    );
                }
            }

            $expenseEntries = [
                ['project' => 'DEMO-HR-001', 'category' => 'Materials', 'description' => 'Demo - cement and reinforcement steel', 'amount' => 18500, 'days_ago' => 3, 'type' => 'project', 'invoice' => 'DEMO-EXP-MAT-001'],
                ['project' => 'DEMO-HR-001', 'category' => 'Equipment', 'description' => 'Demo - concrete mixer rental', 'amount' => 7200, 'days_ago' => 6, 'type' => 'project', 'invoice' => 'DEMO-EXP-EQP-001'],
                ['project' => 'DEMO-HR-001', 'category' => 'Fuel', 'description' => 'Demo - site transport fuel', 'amount' => 3150, 'days_ago' => 11, 'type' => 'project', 'invoice' => 'DEMO-EXP-FUEL-001'],
                ['project' => 'DEMO-HR-002', 'category' => 'Permits & Licenses', 'description' => 'Demo - preliminary site permit fee', 'amount' => 4800, 'days_ago' => 15, 'type' => 'project', 'invoice' => 'DEMO-EXP-PER-001'],
                ['project' => null, 'category' => 'Office Supplies', 'description' => 'Demo - office printing and stationery', 'amount' => 1250, 'days_ago' => 4, 'type' => 'company', 'invoice' => 'DEMO-EXP-OFF-001'],
                ['project' => null, 'category' => 'Utilities', 'description' => 'Demo - monthly office utilities', 'amount' => 3900, 'days_ago' => 9, 'type' => 'company', 'invoice' => 'DEMO-EXP-UTL-001'],
            ];

            foreach ($expenseEntries as $entry) {
                $project = $entry['project']
                    ? Project::where('project_code', $entry['project'])->firstOrFail()
                    : null;
                $category = ExpenseCategory::where('name', $entry['category'])->firstOrFail();

                ProjectExpense::updateOrCreate(
                    ['invoice_number' => $entry['invoice']],
                    [
                        'project_id' => $project?->id,
                        'category_id' => $category->id,
                        'description' => $entry['description'],
                        'amount' => $entry['amount'],
                        'expense_date' => $today->copy()->subDays($entry['days_ago'])->toDateString(),
                        'notes' => 'Demo admin sample data - not a real transaction.',
                        'expense_type' => $entry['type'],
                        'created_by' => $admin->id,
                    ]
                );
            }
        });

        $this->command?->info('Admin demo data ready: 1 quotation, 3 itemized invoices, and 6 project/company expenses.');
    }
}
