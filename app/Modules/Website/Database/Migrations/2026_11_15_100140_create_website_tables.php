<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cms_pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->nullable();
            $table->text('body')->nullable();
            $table->text('body_bn')->nullable();
            $table->string('seo_title')->nullable();
            $table->text('seo_description')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_page_id')->nullable()->constrained('cms_pages')->nullOnDelete();
            $table->string('key');
            $table->json('content')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cms_menu_id')->constrained('cms_menus')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('label');
            $table->string('label_bn')->nullable();
            $table->string('url');
            $table->integer('sort')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->nullable();
            $table->text('body')->nullable();
            $table->text('body_bn')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image_path')->nullable();
            $table->string('link')->nullable();
            $table->integer('sort')->nullable();
            $table->boolean('is_active')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('question_bn')->nullable();
            $table->text('answer')->nullable();
            $table->text('answer_bn')->nullable();
            $table->integer('sort')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('cms_media', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('alt')->nullable();
            $table->string('alt_bn')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('catalog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fabric_item_id')->nullable()->constrained('fabric_items')->nullOnDelete();
            $table->string('title');
            $table->string('title_bn')->nullable();
            $table->string('slug')->nullable();
            $table->string('composition')->nullable();
            $table->string('gsm')->nullable();
            $table->string('uses')->nullable();
            $table->text('description')->nullable();
            $table->text('description_bn')->nullable();
            $table->string('image_path')->nullable();
            $table->boolean('published')->default(false);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('form_submissions', function (Blueprint $table) {
            $table->id();
            $table->string('form');
            $table->json('payload')->nullable();
            $table->string('status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('slug_histories', function (Blueprint $table) {
    $table->id();
    $table->morphs('sluggable');
    $table->string('slug')->index();
    $table->string('field')->default('slug');
    $table->timestamps();
    $table->unique(['sluggable_type', 'slug', 'field'], 'slug_histories_unique');
});
    }

    public function down(): void
    {
        Schema::dropIfExists('slug_histories');
        Schema::dropIfExists('form_submissions');
        Schema::dropIfExists('catalog_products');
        Schema::dropIfExists('cms_media');
        Schema::dropIfExists('cms_faqs');
        Schema::dropIfExists('cms_banners');
        Schema::dropIfExists('cms_posts');
        Schema::dropIfExists('cms_menu_items');
        Schema::dropIfExists('cms_menus');
        Schema::dropIfExists('cms_sections');
        Schema::dropIfExists('cms_pages');
    }
};
