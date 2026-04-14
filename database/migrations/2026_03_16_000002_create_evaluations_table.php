<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('evaluated_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->enum('status', ['PENDING', 'EVALUATED'])->default('PENDING');
            $table->integer('posting_count')->default(0);
            $table->date('evaluation_month');
            $table->timestamps();

            $table->unique(['user_id', 'evaluation_month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
