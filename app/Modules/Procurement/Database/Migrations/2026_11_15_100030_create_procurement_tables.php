<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('source')->nullable();
            $table->date('needed_on')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('requisition_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('requisition_id')->constrained('requisitions')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('qty', 18, 4)->default(0);
            $table->string('uom')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('requisition_id')->nullable()->constrained('requisitions')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->date('due_on')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('rfq_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('rfq_id')->constrained('rfqs')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('qty', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('rfq_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('rfq_id')->constrained('rfqs')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('rate', 18, 2)->default(0);
            $table->integer('lead_days')->nullable();
            $table->decimal('score', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('requisition_id')->nullable()->constrained('requisitions')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->string('currency_code')->nullable();
            $table->date('order_date')->nullable();
            $table->date('expected_on')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('purchase_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('purchase_order_id')->constrained('purchase_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->constrained('yarn_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('qty', 18, 4)->default(0);
            $table->decimal('rate', 18, 2)->default(0);
            $table->decimal('received_qty', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('goods_receipts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->string('challan_no')->nullable();
            $table->date('received_on')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('goods_receipt_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('goods_receipt_id')->constrained('goods_receipts')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('purchase_order_line_id')->nullable()->constrained('purchase_order_lines')->nullOnDelete();
            $table->foreignId('yarn_item_id')->constrained('yarn_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('lot_no');
            $table->integer('bags')->nullable();
            $table->integer('cones')->nullable();
            $table->decimal('challan_weight', 18, 4)->default(0);
            $table->decimal('actual_weight', 18, 4)->default(0);
            $table->decimal('shortage', 18, 4)->default(0);
            $table->string('qc_status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('yarn_lots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->constrained('yarn_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('warehouse_id')->nullable()->constrained('warehouses')->nullOnDelete();
            $table->string('lot_no');
            $table->date('received_on')->nullable();
            $table->string('qc_status')->nullable();
            $table->string('count_actual')->nullable();
            $table->decimal('csp', 18, 4)->default(0);
            $table->decimal('u_percent', 18, 4)->default(0);
            $table->decimal('moisture', 18, 4)->default(0);
            $table->text('shade_note')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('net_kg', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('import_lcs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->string('number');
            $table->string('kind')->nullable();
            $table->string('currency_code')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('margin', 18, 2)->default(0);
            $table->date('maturity_on')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('import_lc_id')->nullable()->constrained('import_lcs')->nullOnDelete();
            $table->string('bl_no')->nullable();
            $table->date('eta')->nullable();
            $table->decimal('duty', 18, 2)->default(0);
            $table->decimal('freight', 18, 2)->default(0);
            $table->decimal('landed_cost', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('supplier_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->foreignId('goods_receipt_id')->nullable()->constrained('goods_receipts')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('status')->nullable();
            $table->string('match_status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('supplier_bill_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_bill_id')->constrained('supplier_bills')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('description')->nullable();
            $table->decimal('qty', 18, 4)->default(0);
            $table->decimal('amount', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('debit_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_bill_id')->nullable()->constrained('supplier_bills')->nullOnDelete();
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
    }

    public function down(): void
    {
        Schema::dropIfExists('debit_notes');
        Schema::dropIfExists('supplier_bill_lines');
        Schema::dropIfExists('supplier_bills');
        Schema::dropIfExists('shipments');
        Schema::dropIfExists('import_lcs');
        Schema::dropIfExists('yarn_lots');
        Schema::dropIfExists('goods_receipt_lines');
        Schema::dropIfExists('goods_receipts');
        Schema::dropIfExists('purchase_order_lines');
        Schema::dropIfExists('purchase_orders');
        Schema::dropIfExists('rfq_quotes');
        Schema::dropIfExists('rfq_lines');
        Schema::dropIfExists('rfqs');
        Schema::dropIfExists('requisition_lines');
        Schema::dropIfExists('requisitions');
    }
};
