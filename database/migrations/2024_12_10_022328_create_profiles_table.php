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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('profile_id'); // Auto-incrementing ID, unique identifier
            $table->string('name'); // Name column
            $table->string('image')->nullable(); // Image link, nullable if no image is provided
            $table->text('description')->nullable(); // Description column
            $table->json('social_media_accounts')->nullable(); // JSON column for social media accounts
            $table->timestamps(); // Includes created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
