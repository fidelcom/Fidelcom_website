<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index('published_at');
            $table->index('status');
            $table->index('blog_category_id');
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->index('status');
            $table->index('project_category_id');
        });

        Schema::table('services', function (Blueprint $table) {
            $table->index('status');
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->index('post_id');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
            $table->dropIndex(['status']);
            $table->dropIndex(['blog_category_id']);
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['project_category_id']);
        });

        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('comments', function (Blueprint $table) {
            $table->dropIndex(['post_id']);
        });
    }
};
