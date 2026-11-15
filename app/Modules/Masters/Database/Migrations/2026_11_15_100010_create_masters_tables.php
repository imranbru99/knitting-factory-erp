<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('code');
            $table->string('name');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('party_type');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->decimal('credit_limit', 18, 2)->default(0);
            $table->integer('credit_days')->nullable();
            $table->decimal('rating', 18, 4)->default(0);
            $table->boolean('is_blacklisted')->default(false);
            $table->string('currency_code')->nullable();
            $table->string('vat_bin')->nullable();
            $table->date('documents_expire_on')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('party_contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('party_id')->constrained('parties')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('designation')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('yarn_counts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('system');
            $table->string('value');
            $table->string('label');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('yarn_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('yarn_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('yarn_count_id')->nullable()->constrained('yarn_counts')->nullOnDelete();
            $table->foreignId('yarn_type_id')->nullable()->constrained('yarn_types')->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('brand')->nullable();
            $table->string('composition')->nullable();
            $table->string('ply')->nullable();
            $table->string('twist')->nullable();
            $table->string('uom')->nullable();
            $table->decimal('reorder_level', 18, 4)->default(0);
            $table->decimal('min_qty', 18, 4)->default(0);
            $table->decimal('max_qty', 18, 4)->default(0);
            $table->integer('lead_time_days')->nullable();
            $table->decimal('last_rate', 18, 2)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fabric_constructions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('family');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('pantone')->nullable();
            $table->string('buyer_code')->nullable();
            $table->string('hex')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('fabric_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fabric_construction_id')->nullable()->constrained('fabric_constructions')->nullOnDelete();
            $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->decimal('gsm_target', 18, 4)->default(0);
            $table->decimal('gsm_min', 18, 4)->default(0);
            $table->decimal('gsm_max', 18, 4)->default(0);
            $table->decimal('dia', 18, 4)->default(0);
            $table->string('composition')->nullable();
            $table->decimal('gauge', 18, 4)->default(0);
            $table->decimal('stitch_length', 18, 4)->default(0);
            $table->string('uom')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('shade_bands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->decimal('delta_e_max', 18, 4)->default(0);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('process')->nullable();
            $table->integer('points')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('processes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->string('stage');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('machine_brands', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('name');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('shift_id')->nullable()->constrained('shifts')->nullOnDelete();
            $table->string('code');
            $table->string('name');
            $table->string('name_bn')->nullable();
            $table->string('designation')->nullable();
            $table->string('grade')->nullable();
            $table->string('employment_type')->nullable();
            $table->string('phone')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('basic_salary', 18, 2)->default(0);
            $table->boolean('is_operator')->default(false);
            $table->string('biometric_uid')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('machine_brands');
        Schema::dropIfExists('processes');
        Schema::dropIfExists('defects');
        Schema::dropIfExists('shade_bands');
        Schema::dropIfExists('fabric_items');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('fabric_constructions');
        Schema::dropIfExists('yarn_items');
        Schema::dropIfExists('yarn_types');
        Schema::dropIfExists('yarn_counts');
        Schema::dropIfExists('party_contacts');
        Schema::dropIfExists('parties');
        Schema::dropIfExists('departments');
    }
};
