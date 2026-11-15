<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packing_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->decimal('net_kg', 18, 4)->default(0);
            $table->decimal('gross_kg', 18, 4)->default(0);
            $table->decimal('yards', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('packing_list_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('packing_list_id')->constrained('packing_lists')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->constrained('rolls')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('net_kg', 18, 4)->default(0);
            $table->decimal('yards', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('delivery_challans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('packing_list_id')->nullable()->constrained('packing_lists')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('driver')->nullable();
            $table->string('mushak')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('delivery_challan_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('delivery_challan_id')->constrained('delivery_challans')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->constrained('rolls')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('kg', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('delivery_challan_id')->nullable()->constrained('delivery_challans')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->decimal('subtotal', 18, 2)->default(0);
            $table->decimal('vat', 18, 2)->default(0);
            $table->decimal('total', 18, 2)->default(0);
            $table->string('currency_code')->nullable();
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('sales_invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_invoice_id')->constrained('sales_invoices')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('description')->nullable();
            $table->decimal('qty', 18, 4)->default(0);
            $table->decimal('rate', 18, 2)->default(0);
            $table->decimal('amount', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('credit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('sales_invoice_id')->nullable()->constrained('sales_invoices')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->text('reason')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('gate_passes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('direction');
            $table->string('ref_type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('status')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('gate_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('kind');
            $table->string('name');
            $table->string('purpose')->nullable();
            $table->dateTime('in_at')->nullable();
            $table->dateTime('out_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('transporter_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->string('number');
            $table->decimal('capacity_kg', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('vehicle_id')->nullable()->constrained('vehicles')->nullOnDelete();
            $table->foreignId('delivery_challan_id')->nullable()->constrained('delivery_challans')->nullOnDelete();
            $table->decimal('fuel_cost', 18, 2)->default(0);
            $table->date('started_on')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trips');
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('gate_logs');
        Schema::dropIfExists('gate_passes');
        Schema::dropIfExists('credit_notes');
        Schema::dropIfExists('sales_invoice_lines');
        Schema::dropIfExists('sales_invoices');
        Schema::dropIfExists('delivery_challan_lines');
        Schema::dropIfExists('delivery_challans');
        Schema::dropIfExists('packing_list_lines');
        Schema::dropIfExists('packing_lists');
    }
};
