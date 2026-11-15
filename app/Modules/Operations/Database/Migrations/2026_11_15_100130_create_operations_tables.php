<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('rule_key');
            $table->string('severity');
            $table->string('title');
            $table->text('detail')->nullable();
            $table->text('suggested_solution')->nullable();
            $table->string('owner_role')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('sla_due_at')->nullable();
            $table->string('subject_type')->nullable();
            $table->integer('subject_id')->nullable();
            $table->integer('escalated_level')->nullable();
            $table->text('snooze_reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issue_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('key');
            $table->boolean('enabled')->default(false);
            $table->json('thresholds')->nullable();
            $table->string('owner_role')->nullable();
            $table->string('severity')->nullable();
            $table->integer('sla_hours')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('issue_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('issue_id')->constrained('issues')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('kind')->nullable();
            $table->text('note')->nullable();
            $table->integer('user_id')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('title');
            $table->string('from_department')->nullable();
            $table->string('to_department')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('due_at')->nullable();
            $table->integer('sla_hours')->nullable();
            $table->text('detail')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('notification_dispatches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('channel');
            $table->string('recipient')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('webhook_endpoints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('url');
            $table->string('event');
            $table->string('secret')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('webhook_endpoints');
        Schema::dropIfExists('notification_dispatches');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('issue_events');
        Schema::dropIfExists('issue_rules');
        Schema::dropIfExists('issues');
    }
};
