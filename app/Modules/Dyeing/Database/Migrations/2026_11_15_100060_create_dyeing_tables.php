<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lab_dips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->text('comments')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('recipes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->string('name');
            $table->decimal('liquor_ratio', 18, 4)->default(0);
            $table->decimal('cost_per_kg', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('recipe_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('recipe_id')->constrained('recipes')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('chemical_name');
            $table->decimal('gpl', 18, 4)->default(0);
            $table->decimal('cost', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dye_machines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('code');
            $table->string('brand')->nullable();
            $table->decimal('capacity_kg', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('dye_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->nullable()->constrained('units')->nullOnDelete();
            $table->foreignId('dye_machine_id')->nullable()->constrained('dye_machines')->nullOnDelete();
            $table->foreignId('recipe_id')->nullable()->constrained('recipes')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->foreignId('party_id')->nullable()->constrained('parties')->nullOnDelete();
            $table->string('number')->nullable();
            $table->decimal('input_kg', 18, 4)->default(0);
            $table->decimal('output_kg', 18, 4)->default(0);
            $table->decimal('process_loss_pct', 18, 4)->default(0);
            $table->decimal('shade_de', 18, 4)->default(0);
            $table->string('status')->nullable();
            $table->boolean('is_subcontract')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['company_id', 'number']);
        });

        Schema::create('dye_batch_rolls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dye_batch_id')->constrained('dye_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('roll_id')->constrained('rolls')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('kg', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('chemical_issues', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dye_batch_id')->constrained('dye_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('chemical_name');
            $table->decimal('qty', 18, 4)->default(0);
            $table->decimal('recipe_qty', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('finishing_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dye_batch_id')->constrained('dye_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('process');
            $table->string('machine_name')->nullable();
            $table->decimal('gsm_after', 18, 4)->default(0);
            $table->decimal('dia_after', 18, 4)->default(0);
            $table->decimal('shrinkage_l', 18, 4)->default(0);
            $table->decimal('shrinkage_w', 18, 4)->default(0);
            $table->dateTime('done_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shade_matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('dye_batch_id')->constrained('dye_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('l_star', 18, 4)->default(0);
            $table->decimal('a_star', 18, 4)->default(0);
            $table->decimal('b_star', 18, 4)->default(0);
            $table->decimal('delta_e', 18, 4)->default(0);
            $table->boolean('approved')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shade_matches');
        Schema::dropIfExists('finishing_logs');
        Schema::dropIfExists('chemical_issues');
        Schema::dropIfExists('dye_batch_rolls');
        Schema::dropIfExists('dye_batches');
        Schema::dropIfExists('dye_machines');
        Schema::dropIfExists('recipe_lines');
        Schema::dropIfExists('recipes');
        Schema::dropIfExists('lab_dips');
    }
};
