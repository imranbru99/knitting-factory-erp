<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('floor_id')->nullable()->constrained('floors')->nullOnDelete();
            $table->foreignId('machine_brand_id')->nullable()->constrained('machine_brands')->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('machine_type');
            $table->decimal('dia', 18, 4)->default(0);
            $table->decimal('gauge', 18, 4)->default(0);
            $table->integer('feeders')->nullable();
            $table->decimal('rpm', 18, 4)->default(0);
            $table->decimal('capacity_kg_shift', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->date('installed_on')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('knitting_programs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->foreignId('sales_order_line_id')->nullable()->constrained('sales_order_lines')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('target_kg', 18, 4)->default(0);
            $table->decimal('target_gsm', 18, 4)->default(0);
            $table->decimal('stitch_length', 18, 4)->default(0);
            $table->decimal('dia', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->dateTime('planned_start')->nullable();
            $table->dateTime('planned_end')->nullable();
            $table->text('special_instruction')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('knitting_program_yarns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('knitting_program_id')->constrained('knitting_programs')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_lot_id')->nullable()->constrained('yarn_lots')->nullOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('ratio_pct', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('production_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->foreignId('knitting_program_id')->nullable()->constrained('knitting_programs')->nullOnDelete();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('ended_at')->nullable();
            $table->decimal('produced_kg', 18, 4)->default(0);
            $table->decimal('rpm_actual', 18, 4)->default(0);
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('knitting_program_id')->nullable()->constrained('knitting_programs')->nullOnDelete();
            $table->foreignId('machine_id')->nullable()->constrained('machines')->nullOnDelete();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('gross_kg', 18, 4)->default(0);
            $table->decimal('net_kg', 18, 4)->default(0);
            $table->decimal('gsm', 18, 4)->default(0);
            $table->decimal('dia', 18, 4)->default(0);
            $table->decimal('yards', 18, 4)->default(0);
            $table->string('grade')->nullable();
            $table->string('stage')->nullable();
            $table->json('yarn_lots')->nullable();
            $table->dateTime('produced_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('machine_stoppages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('operator_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->string('reason');
            $table->dateTime('started_at');
            $table->dateTime('ended_at')->nullable();
            $table->integer('minutes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('needle_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('machine_id')->constrained('machines')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('kind');
            $table->integer('qty')->nullable();
            $table->date('changed_on')->nullable();
            $table->string('reason')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('grey_inspections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->constrained('rolls')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('inspector_id')->nullable()->constrained('employees')->nullOnDelete();
            $table->decimal('gsm', 18, 4)->default(0);
            $table->decimal('dia', 18, 4)->default(0);
            $table->decimal('points', 18, 4)->default(0);
            $table->string('grade')->nullable();
            $table->decimal('length_m', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('grey_inspection_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('grey_inspection_id')->constrained('grey_inspections')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('defect_id')->nullable()->constrained('defects')->nullOnDelete();
            $table->decimal('position_m', 18, 4)->default(0);
            $table->integer('points')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('subcontract_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('direction');
            $table->decimal('yarn_sent_kg', 18, 4)->default(0);
            $table->decimal('rolls_received_kg', 18, 4)->default(0);
            $table->decimal('charge_per_kg', 18, 2)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcontract_jobs');
        Schema::dropIfExists('grey_inspection_defects');
        Schema::dropIfExists('grey_inspections');
        Schema::dropIfExists('needle_logs');
        Schema::dropIfExists('machine_stoppages');
        Schema::dropIfExists('rolls');
        Schema::dropIfExists('production_entries');
        Schema::dropIfExists('knitting_program_yarns');
        Schema::dropIfExists('knitting_programs');
        Schema::dropIfExists('machines');
    }
};
