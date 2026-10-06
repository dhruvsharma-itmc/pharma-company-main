<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coa_reports', function (Blueprint $table) {
            if (!Schema::hasColumn('coa_reports', 'sample_received_date')) {
                $table->date('sample_received_date')->nullable()->after('verification_date');
            }
        });
    }

    public function down(): void
    {
        Schema::table('coa_reports', function (Blueprint $table) {
            if (Schema::hasColumn('coa_reports', 'sample_received_date')) {
                $table->dropColumn('sample_received_date');
            }
        });
    }
};
