<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_ledgers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->string('stock_type');
            $table->integer('item_id');
            $table->integer('lot_id')->nullable();
            $table->decimal('qty_in', 18, 4)->default(0);
            $table->decimal('qty_out', 18, 4)->default(0);
            $table->decimal('balance_qty', 18, 4)->default(0);
            $table->decimal('rate', 18, 2)->default(0);
            $table->decimal('amount', 18, 2)->default(0);
            $table->string('ref_type')->nullable();
            $table->integer('ref_id')->nullable();
            $table->string('movement_key')->nullable();
            $table->dateTime('moved_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->index(['company_id', 'stock_type', 'item_id', 'lot_id'], 'stock_ledgers_balance_idx');
            $table->unique('movement_key');
        });

        Schema::create('yarn_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('knitting_program_id')->nullable()->constrained('knitting_programs')->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->date('issued_on')->nullable();
            $table->string('status')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('yarn_issue_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_issue_id')->constrained('yarn_issues')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_lot_id')->constrained('yarn_lots')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->nullable()->constrained('yarn_items')->nullOnDelete();
            $table->decimal('qty', 18, 4)->default(0);
            $table->boolean('approved_mix')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('yarn_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('yarn_issue_id')->nullable()->constrained('yarn_issues')->nullOnDelete();
            $table->foreignId('yarn_lot_id')->constrained('yarn_lots')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->decimal('qty', 18, 4)->default(0);
            $table->string('reason')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('yarn_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('from_sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->foreignId('to_sales_order_id')->nullable()->constrained('sales_orders')->nullOnDelete();
            $table->foreignId('yarn_lot_id')->constrained('yarn_lots')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->decimal('qty', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('stock_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('number')->nullable();
            $table->date('counted_on')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('stock_count_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('stock_count_id')->constrained('stock_counts')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('stock_type')->nullable();
            $table->integer('item_id')->nullable();
            $table->integer('lot_id')->nullable();
            $table->decimal('book_qty', 18, 4)->default(0);
            $table->decimal('physical_qty', 18, 4)->default(0);
            $table->decimal('variance', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('reorder_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_item_id')->constrained('yarn_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('min_qty', 18, 4)->default(0);
            $table->decimal('max_qty', 18, 4)->default(0);
            $table->integer('lead_days')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reorder_rules');
        Schema::dropIfExists('stock_count_lines');
        Schema::dropIfExists('stock_counts');
        Schema::dropIfExists('yarn_transfers');
        Schema::dropIfExists('yarn_returns');
        Schema::dropIfExists('yarn_issue_lines');
        Schema::dropIfExists('yarn_issues');
        Schema::dropIfExists('stock_ledgers');
    }
};
