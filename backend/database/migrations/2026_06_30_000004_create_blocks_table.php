<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('pages')->cascadeOnDelete();
            $table->string('block_type');
            $table->unsignedInteger('position')->default(0);
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['page_id', 'position']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};
