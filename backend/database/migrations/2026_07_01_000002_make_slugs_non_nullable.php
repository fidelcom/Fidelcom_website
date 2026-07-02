<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });

        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });
        Schema::table('services', function (Blueprint $table) {
            $table->string('slug')->nullable()->change();
        });
    }
};
