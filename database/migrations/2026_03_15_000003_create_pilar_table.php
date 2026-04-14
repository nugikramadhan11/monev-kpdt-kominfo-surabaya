<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pilars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('hashtag')->unique();
            $table->string('color')->default('#3b82f6');
            $table->string('icon')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pilars');
    }
};
