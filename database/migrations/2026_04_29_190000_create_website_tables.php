<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('website_city', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 120)->unique();
            $table->string('slug', 140)->unique()->nullable();
            $table->unsignedInteger('sort_order')->default(0);
        });

        Schema::create('website_property', function (Blueprint $table): void {
            $table->id();
            $table->string('slug', 140)->unique();
            $table->string('name', 200);
            $table->foreignId('city_id')->nullable()->constrained('website_city')->nullOnDelete();
            $table->string('location', 240);
            $table->string('price_display', 120);
            $table->decimal('rating', 3, 2)->default(4.5);
            $table->string('status', 40)->default('Ready to move');
            $table->string('project_type', 20)->default('residential')->index();
            $table->string('brochure_url', 500)->nullable();
            $table->text('description');
            $table->string('developer_name', 200);
            $table->text('about_developer');
            $table->string('rera_id', 120);
            $table->string('project_size', 200);
            $table->string('map_embed_url', 800);
            $table->json('images');
            $table->json('amenities');
            $table->json('videos');
            $table->json('faq');
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('website_siteenquiry', function (Blueprint $table): void {
            $table->id();
            $table->string('enquiry_type', 20)->index();
            $table->string('name', 120);
            $table->string('phone', 10);
            $table->text('message')->nullable();
            $table->foreignId('property_id')->nullable()->constrained('website_property')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent()->index();
        });

        Schema::create('website_blogpost', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 200);
            $table->string('slug', 220)->unique()->nullable();
            $table->text('excerpt')->nullable();
            $table->longText('body');
            $table->string('featured_image')->nullable();
            $table->string('featured_image_url', 500)->nullable();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('website_newseventsitem', function (Blueprint $table): void {
            $table->id();
            $table->string('section', 16)->default('news')->index();
            $table->string('title', 200);
            $table->text('summary')->nullable();
            $table->string('image')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->string('link_url', 500)->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('website_awardrecognition', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 200);
            $table->string('issuer', 200)->nullable();
            $table->string('year_label', 40)->nullable();
            $table->text('summary')->nullable();
            $table->string('image')->nullable();
            $table->string('image_url', 500)->nullable();
            $table->string('link_url', 500)->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('website_careerssettings', function (Blueprint $table): void {
            $table->unsignedBigInteger('id')->primary();
            $table->string('hr_email');
            $table->timestamps();
        });

        Schema::create('website_jobopening', function (Blueprint $table): void {
            $table->id();
            $table->string('title', 200);
            $table->string('department', 120)->nullable();
            $table->string('location', 200)->nullable();
            $table->string('employment_type', 20)->default('full_time');
            $table->text('description');
            $table->text('responsibilities')->nullable();
            $table->text('qualifications')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('website_jobopening');
        Schema::dropIfExists('website_careerssettings');
        Schema::dropIfExists('website_awardrecognition');
        Schema::dropIfExists('website_newseventsitem');
        Schema::dropIfExists('website_blogpost');
        Schema::dropIfExists('website_siteenquiry');
        Schema::dropIfExists('website_property');
        Schema::dropIfExists('website_city');
    }
};
