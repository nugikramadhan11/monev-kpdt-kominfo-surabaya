<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('pilar_id')->constrained('pilars');
            $table->foreignId('wilayah_id')->constrained('wilayahs');
            $table->string('url');
            $table->string('platform'); // Instagram, TikTok, YouTube
            $table->text('caption')->nullable();
            $table->date('posted_date');
            $table->enum('status', ['DRAFT', 'PENDING', 'VERIFIED', 'REJECTED'])->default('DRAFT');
            $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
