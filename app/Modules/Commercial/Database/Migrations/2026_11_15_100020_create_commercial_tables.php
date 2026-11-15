<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('subject');
            $table->decimal('qty_kg', 18, 4)->default(0);
            $table->date('target_date')->nullable();
            $table->string('status')->nullable();
            $table->string('source')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('samples', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('inquiry_id')->nullable()->constrained('inquiries')->nullOnDelete();
            $table->string('kind');
            $table->string('status')->nullable();
            $table->text('comments')->nullable();
            $table->date('approved_on')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cost_sheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('yarn_rate', 18, 2)->default(0);
            $table->decimal('knitting_charge', 18, 2)->default(0);
            $table->decimal('dyeing_charge', 18, 2)->default(0);
            $table->decimal('process_loss_pct', 18, 4)->default(0);
            $table->decimal('wastage_pct', 18, 4)->default(0);
            $table->decimal('overhead_pct', 18, 4)->default(0);
            $table->decimal('finance_pct', 18, 4)->default(0);
            $table->decimal('profit_pct', 18, 4)->default(0);
            $table->decimal('cost_per_kg', 18, 2)->default(0);
            $table->decimal('cost_per_yard', 18, 2)->default(0);
            $table->decimal('quoted_rate', 18, 2)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('cost_sheet_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_sheet_id')->constrained('cost_sheets')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('component');
            $table->decimal('amount', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_sheet_id')->nullable()->constrained('cost_sheets')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->date('valid_until')->nullable();
            $table->string('currency_code')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('quotation_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->decimal('qty', 18, 4)->default(0);
            $table->decimal('rate', 18, 2)->default(0);
            $table->string('uom')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('price_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->string('name');
            $table->string('currency_code')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('price_list_id')->constrained('price_lists')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->decimal('rate', 18, 2)->default(0);
            $table->string('uom')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('sales_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('inquiry_id')->nullable()->constrained('inquiries')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('buyer_po')->nullable();
            $table->date('order_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('shipment_terms')->nullable();
            $table->decimal('tolerance_pct', 18, 4)->default(0);
            $table->string('yarn_source')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('sales_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->decimal('gsm', 18, 4)->default(0);
            $table->decimal('dia', 18, 4)->default(0);
            $table->decimal('qty_kg', 18, 4)->default(0);
            $table->decimal('qty_yd', 18, 4)->default(0);
            $table->decimal('rate', 18, 2)->default(0);
            $table->date('delivery_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('boms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('process_loss_pct', 18, 4)->default(0);
            $table->decimal('wastage_pct', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('bom_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('bom_id')->constrained('boms')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('ratio_pct', 18, 4)->default(0);
            $table->decimal('requirement_kg', 18, 4)->default(0);
            $table->boolean('is_lycra')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->date('planned_on')->nullable();
            $table->date('actual_on')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('order_amendments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('sales_order_id')->constrained('sales_orders')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('reason');
            $table->json('changes')->nullable();
            $table->date('revised_delivery')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_amendments');
        Schema::dropIfExists('order_milestones');
        Schema::dropIfExists('bom_lines');
        Schema::dropIfExists('boms');
        Schema::dropIfExists('sales_order_lines');
        Schema::dropIfExists('sales_orders');
        Schema::dropIfExists('price_list_items');
        Schema::dropIfExists('price_lists');
        Schema::dropIfExists('quotation_lines');
        Schema::dropIfExists('quotations');
        Schema::dropIfExists('cost_sheet_lines');
        Schema::dropIfExists('cost_sheets');
        Schema::dropIfExists('samples');
        Schema::dropIfExists('inquiries');
    }
};
