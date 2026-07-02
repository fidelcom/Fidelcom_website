<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // comments: add approved flag
        Schema::table('comments', function (Blueprint $table) {
            $table->boolean('approved')->default(false)->after('message');
        });

        // galleries: add alt_text
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('alt_text')->nullable()->after('name');
        });

        // testimonials: add index on approved for homepage query performance
        Schema::table('testimonials', function (Blueprint $table) {
            $table->index('approved');
        });

        // get_in_touches: add index on status for dashboard unread count
        Schema::table('get_in_touches', function (Blueprint $table) {
            $table->index('status');
        });

        // lets_talks: add index on status
        Schema::table('lets_talks', function (Blueprint $table) {
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('comments', fn (Blueprint $t) => $t->dropColumn('approved'));
        Schema::table('galleries', fn (Blueprint $t) => $t->dropColumn('alt_text'));

        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropIndex(['approved']);
        });
        Schema::table('get_in_touches', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
        Schema::table('lets_talks', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });
    }
};
