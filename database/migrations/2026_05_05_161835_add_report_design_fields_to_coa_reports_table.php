<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('coa_reports')) {
            Schema::table('coa_reports', function (Blueprint $table) {
                if (!Schema::hasColumn('coa_reports', 'report_brand_name')) {
                    $table->string('report_brand_name')->nullable()->after('client_company_name');
                }

                if (!Schema::hasColumn('coa_reports', 'blend_title')) {
                    $table->string('blend_title')->nullable()->after('purity_percent');
                }

                if (!Schema::hasColumn('coa_reports', 'blend_breakdown')) {
                    $table->string('blend_breakdown')->nullable()->after('blend_title');
                }

                if (!Schema::hasColumn('coa_reports', 'usage_text')) {
                    $table->string('usage_text')->nullable()->after('blend_breakdown');
                }

                if (!Schema::hasColumn('coa_reports', 'expiry_label')) {
                    $table->string('expiry_label')->nullable()->after('verification_date');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('coa_reports')) {
            Schema::table('coa_reports', function (Blueprint $table) {
                $columns = [
                    'report_brand_name',
                    'blend_title',
                    'blend_breakdown',
                    'usage_text',
                    'expiry_label',
                ];

                foreach ($columns as $column) {
                    if (Schema::hasColumn('coa_reports', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        }
    }
};