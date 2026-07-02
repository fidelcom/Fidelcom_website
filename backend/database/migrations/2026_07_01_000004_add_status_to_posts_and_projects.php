<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('published')->after('image');
            $table->timestamp('published_at')->nullable()->after('status');
        });

        // Backfill published_at for existing posts
        DB::table('posts')->whereNull('published_at')->update(['published_at' => DB::raw('created_at')]);

        Schema::table('projects', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('published')->after('image');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->enum('status', ['draft', 'published'])->default('published')->after('image');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['status', 'published_at']);
        });
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('status');
        });
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
