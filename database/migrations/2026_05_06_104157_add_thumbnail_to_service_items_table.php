<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('service_items') && !Schema::hasColumn('service_items', 'thumbnail')) {
            Schema::table('service_items', function (Blueprint $table) {
                $table->string('thumbnail')->nullable()->after('slug');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('service_items') && Schema::hasColumn('service_items', 'thumbnail')) {
            Schema::table('service_items', function (Blueprint $table) {
                $table->dropColumn('thumbnail');
            });
        }
    }
};