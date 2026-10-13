<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('quotation_approval_status')->nullable();
            $table->foreignId('quotation_approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('quotation_approved_at')->nullable();
        });

        Schema::table('approval_requests', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('expense_categories')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('approval_requests', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropConstrainedForeignId('quotation_approved_by');
            $table->dropColumn(['quotation_approval_status', 'quotation_approved_at']);
        });
    }
};
