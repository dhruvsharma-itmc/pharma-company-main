<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('service_items', 'base_price')) {
            Schema::table('service_items', function (Blueprint $table) {
                $table->decimal('base_price', 10, 2)->default(0)->after('price_label');
                $table->string('currency', 10)->default('USD')->after('base_price');
                $table->string('turnaround_time')->nullable()->after('currency');
                $table->text('sample_requirement')->nullable()->after('turnaround_time');
            });
        }
    }

    public function down(): void
    {
        Schema::table('service_items', function (Blueprint $table) {
            if (Schema::hasColumn('service_items', 'sample_requirement')) {
                $table->dropColumn('sample_requirement');
            }

            if (Schema::hasColumn('service_items', 'turnaround_time')) {
                $table->dropColumn('turnaround_time');
            }

            if (Schema::hasColumn('service_items', 'currency')) {
                $table->dropColumn('currency');
            }

            if (Schema::hasColumn('service_items', 'base_price')) {
                $table->dropColumn('base_price');
            }
        });
    }
};