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
        // Creating the users collection in MongoDB
        Schema::connection('mongodb')->create('users', function (Blueprint $table) {
            // MongoDB automatically uses _id, so we don't need to add it explicitly
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps(); // This will add created_at and updated_at fields as DateTime

            // You can also add indexes for faster queries
            $table->index('email'); // Create an index on the email field
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the users collection in MongoDB
        Schema::connection('mongodb')->dropIfExists('users');
    }
};