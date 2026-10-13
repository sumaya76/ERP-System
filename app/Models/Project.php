<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [
        'name',
        'project_code',
        'client_name',
        'client_phone',
        'client_email',
        'client_address',
        'location',
        'description',
        'contract_value',
        'estimated_cost',
        'budget_total',
        'valid_until',
        'quotation_number',
        'vat_rate',
        'vat_included',
        'start_date',
        'end_date',
        'status',
        'project_stage',
        'progress_percent',
        'budget_cap',
        'quotation_approval_status',
        'quotation_approved_by',
        'quotation_approved_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'valid_until' => 'date',
        'progress_percent' => 'decimal:2',
        'budget_cap' => 'decimal:2',
        'quotation_approved_at' => 'datetime',
    ];

    public function workers()
    {
        return $this->belongsToMany(Worker::class)
            ->withPivot('assigned_date', 'release_date', 'status')
            ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(ProjectExpense::class);
    }

    public function getTotalExpensesAttribute()
    {
        return $this->expenses()->sum('amount');
    }

    public function getNetProfitAttribute()
    {
        return ($this->contract_value ?? 0) - ($this->total_expenses + $this->labor_cost);
    }

    public function getLaborCostAttribute()
    {
        // Get labor cost from payroll breakdowns
        return \DB::table('payroll_project_breakdowns')
            ->where('project_id', $this->id)
            ->sum('amount');
    }

    public function budgetItems()
    {
        return $this->hasMany(BudgetItem::class)->orderBy('sort_order');
    }

    // Get total with VAT - use the saved budget_total column
    public function getBudgetTotalAttribute()
    {
        return $this->attributes['budget_total'] ?? $this->contract_value ?? $this->estimated_cost ?? 0;
    }

    public function saleInvoices()
    {
        return $this->hasMany(SaleInvoice::class);
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(ProjectMilestone::class);
    }

    public function progressUpdates(): HasMany
    {
        return $this->hasMany(ProjectProgressUpdate::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(ProjectDocument::class, 'documentable_id')
            ->where('documentable_type', 'project');
    }

    // Optional: Get total invoiced amount
    public function getTotalInvoicedAttribute()
    {
        return $this->saleInvoices()->sum('total');
    }
}
