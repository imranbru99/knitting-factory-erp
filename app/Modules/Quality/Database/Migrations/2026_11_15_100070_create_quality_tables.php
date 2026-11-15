<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finished_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->constrained('rolls')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('points_per_100', 18, 4)->default(0);
            $table->string('grade')->nullable();
            $table->decimal('length_yd', 18, 4)->default(0);
            $table->decimal('width_in', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('finished_inspection_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('finished_inspection_id')->constrained('finished_inspections')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('defect_id')->nullable()->constrained('defects')->nullOnDelete();
            $table->decimal('position_m', 18, 4)->default(0);
            $table->integer('points')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->nullable()->constrained('rolls')->nullOnDelete();
            $table->foreignId('dye_batch_id')->nullable()->constrained('dye_batches')->nullOnDelete();
            $table->string('test_name');
            $table->string('standard')->nullable();
            $table->string('result_value')->nullable();
            $table->string('unit')->nullable();
            $table->boolean('passed')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('qc_holds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('holdable_type');
            $table->integer('holdable_id');
            $table->text('reason');
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('capas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('owner_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('source')->nullable();
            $table->date('due_on')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('action')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('buyer_claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('status')->nullable();
            $table->text('root_cause')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('compliance_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('kind');
            $table->date('expires_on')->nullable();
            $table->string('file_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('compliance_documents');
        Schema::dropIfExists('buyer_claims');
        Schema::dropIfExists('capas');
        Schema::dropIfExists('qc_holds');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('finished_inspection_defects');
        Schema::dropIfExists('finished_inspections');
    }
};
