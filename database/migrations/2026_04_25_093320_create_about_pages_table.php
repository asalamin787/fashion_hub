<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('about_pages', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->default('About FashionHub');
            $table->string('hero_subtitle')->nullable();
            $table->string('story_title')->default('Our Story');
            $table->longText('story_body')->nullable();
            $table->string('story_image')->nullable();
            $table->string('values_title')->default('Our Values');
            $table->string('values_subtitle')->nullable();
            $table->json('values_items')->nullable();
            $table->string('team_title')->default('Meet Our Team');
            $table->string('team_subtitle')->nullable();
            $table->json('team_members')->nullable();
            $table->json('stats_items')->nullable();
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0)->index();
            $table->timestamps();

            $table->index(['is_active', 'sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_pages');
    }
};
