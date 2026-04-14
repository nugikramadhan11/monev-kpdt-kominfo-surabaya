<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verification_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('posting_id')->constrained('postings')->onDelete('cascade');
            $table->foreignId('verified_by')->constrained('users');
            $table->enum('action', ['APPROVED', 'REJECTED']);
            $table->text('reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verification_histories');
    }
};
