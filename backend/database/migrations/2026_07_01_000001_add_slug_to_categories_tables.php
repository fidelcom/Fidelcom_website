<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        DB::table('blog_categories')->orderBy('id')->each(function ($cat) {
            $slug     = Str::slug($cat->name);
            $original = $slug;
            $i        = 1;
            while (DB::table('blog_categories')->where('slug', $slug)->where('id', '!=', $cat->id)->exists()) {
                $slug = $original . '-' . $i++;
            }
            DB::table('blog_categories')->where('id', $cat->id)->update(['slug' => $slug]);
        });

        Schema::table('blog_categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
        });

        DB::table('project_categories')->orderBy('id')->each(function ($cat) {
            $slug     = Str::slug($cat->name);
            $original = $slug;
            $i        = 1;
            while (DB::table('project_categories')->where('slug', $slug)->where('id', '!=', $cat->id)->exists()) {
                $slug = $original . '-' . $i++;
            }
            DB::table('project_categories')->where('id', $cat->id)->update(['slug' => $slug]);
        });

        Schema::table('project_categories', function (Blueprint $table) {
            $table->string('slug')->nullable(false)->change();
        });
    }

    public function down(): void
    {
        Schema::table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
        Schema::table('project_categories', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
