<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Hero
            $table->string('hero_name')->default('Your Name');
            $table->string('hero_title')->default('Full Stack Developer');
            $table->text('hero_bio')->nullable();
            $table->boolean('hero_available')->default(true);
            $table->string('hero_avatar')->nullable();
            $table->string('hero_github')->nullable();
            $table->string('hero_linkedin')->nullable();

            // Stats
            $table->unsignedInteger('stat_startups')->default(0);
            $table->unsignedInteger('stat_years')->default(0);
            $table->unsignedInteger('stat_projects')->default(0);

            // Sections stored as JSON
            $table->json('tech_stack')->nullable();
            $table->json('experience')->nullable();
            $table->json('projects')->nullable();

            // Contact
            $table->string('contact_email')->nullable();
            $table->string('contact_location')->nullable();
            $table->string('contact_calendly')->nullable();

            // Meta
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
