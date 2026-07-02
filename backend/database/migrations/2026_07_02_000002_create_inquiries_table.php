<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inquiries', function (Blueprint $table) {
            $table->id();
            $table->string('source');             // 'contact' | 'quote'
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable(); // contact inquiries
            $table->string('service')->nullable(); // quote requests
            $table->text('message')->nullable();
            $table->string('status')->default('new'); // 'new' | 'in_progress' | 'resolved'
            $table->timestamps();

            $table->index(['source', 'status']);
            $table->index('created_at');
        });

        // Backfill from get_in_touches (contact + quote submissions via the API)
        DB::statement("
            INSERT INTO inquiries (source, name, email, phone, subject, service, message, status, created_at, updated_at)
            SELECT 'contact', name, email, phone, subject, NULL, message,
                   CASE WHEN status = 1 THEN 'resolved' ELSE 'new' END,
                   created_at, updated_at
            FROM get_in_touches
        ");

        // Backfill from lets_talks (legacy Blade site quote submissions)
        DB::statement("
            INSERT INTO inquiries (source, name, email, phone, subject, service, message, status, created_at, updated_at)
            SELECT 'quote', name, email, phone, NULL, service, NULL,
                   CASE WHEN status = 1 THEN 'resolved' ELSE 'new' END,
                   created_at, updated_at
            FROM lets_talks
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};
