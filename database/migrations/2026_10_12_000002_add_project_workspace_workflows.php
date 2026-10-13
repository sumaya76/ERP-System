<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('project_stage')->default('Planning');
            $table->decimal('progress_percent', 5, 2)->default(0);
            $table->decimal('budget_cap', 15, 2)->nullable();
        });

        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->decimal('unit_cost', 12, 2)->nullable()->after('quantity');
        });

        Schema::create('project_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed'])->default('pending');
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();
            $table->timestamps();
            $table->index(['project_id', 'status', 'due_date']);
        });

        Schema::create('project_progress_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->date('update_date');
            $table->string('stage');
            $table->decimal('progress_percent', 5, 2);
            $table->text('summary');
            $table->text('blockers')->nullable();
            $table->timestamps();
            $table->index(['project_id', 'update_date']);
        });

        Schema::create('project_documents', function (Blueprint $table) {
            $table->id();
            $table->string('documentable_type', 20);
            $table->unsignedBigInteger('documentable_id');
            $table->foreignId('uploaded_by')->constrained('users')->restrictOnDelete();
            $table->string('category', 50);
            $table->string('original_name');
            $table->string('storage_path');
            $table->string('mime_type', 150)->nullable();
            $table->unsignedBigInteger('size_bytes');
            $table->date('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->index(['documentable_type', 'documentable_id']);
            $table->index('expires_at');
        });

        Schema::create('approval_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_type', 30);
            $table->string('subject_type', 50)->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreignId('project_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->text('details')->nullable();
            $table->decimal('amount', 15, 2)->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->foreignId('requested_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
            $table->index(['status', 'request_type', 'created_at']);
            $table->index(['subject_type', 'subject_id']);
        });

        Schema::create('approval_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('approval_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->restrictOnDelete();
            $table->string('action', 20);
            $table->string('from_status', 20);
            $table->string('to_status', 20);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('erp_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('alert_key')->unique();
            $table->string('category', 30);
            $table->string('title');
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            $table->index(['user_id', 'resolved_at', 'read_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('erp_notifications');
        Schema::dropIfExists('approval_actions');
        Schema::dropIfExists('approval_requests');
        Schema::dropIfExists('project_documents');
        Schema::dropIfExists('project_progress_updates');
        Schema::dropIfExists('project_milestones');

        Schema::table('inventory_transactions', function (Blueprint $table) {
            $table->dropColumn('unit_cost');
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['project_stage', 'progress_percent', 'budget_cap']);
        });
    }
};
