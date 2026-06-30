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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\ProjectCategory::class)->constrained('project_categories')->onDelete('cascade');
            $table->string('title');
            $table->text('short_desc');
            $table->string('client')->nullable();
            $table->string('year')->nullable();
            $table->string('location')->nullable();
            $table->text('long_desc');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
