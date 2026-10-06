<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'payment_methods')) {
                $table->json('payment_methods')->nullable()->after('footer_disclaimer');
            }
        });

        Schema::table('sample_submissions', function (Blueprint $table) {
            if (!Schema::hasColumn('sample_submissions', 'payment_method_label')) {
                $table->string('payment_method_label')->nullable()->after('coa_file');
            }

            if (!Schema::hasColumn('sample_submissions', 'payment_method_type')) {
                $table->string('payment_method_type')->nullable()->after('payment_method_label');
            }

            if (!Schema::hasColumn('sample_submissions', 'payment_amount')) {
                $table->decimal('payment_amount', 10, 2)->nullable()->after('payment_method_type');
            }

            if (!Schema::hasColumn('sample_submissions', 'payment_currency')) {
                $table->string('payment_currency', 12)->nullable()->after('payment_amount');
            }

            if (!Schema::hasColumn('sample_submissions', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('payment_currency');
            }

            if (!Schema::hasColumn('sample_submissions', 'payment_proof_file')) {
                $table->string('payment_proof_file')->nullable()->after('payment_reference');
            }

            if (!Schema::hasColumn('sample_submissions', 'cart_snapshot')) {
                $table->json('cart_snapshot')->nullable()->after('payment_proof_file');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sample_submissions', function (Blueprint $table) {
            $columns = [
                'payment_method_label',
                'payment_method_type',
                'payment_amount',
                'payment_currency',
                'payment_reference',
                'payment_proof_file',
                'cart_snapshot',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('sample_submissions', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('site_settings', function (Blueprint $table) {
            if (Schema::hasColumn('site_settings', 'payment_methods')) {
                $table->dropColumn('payment_methods');
            }
        });
    }
};
