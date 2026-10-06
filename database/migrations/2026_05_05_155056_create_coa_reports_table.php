<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coa_reports', function (Blueprint $table) {
            $table->id();

            $table->string('batch_number')->unique();
            $table->string('product_name');
            $table->string('strength')->nullable();

            $table->decimal('purity_percent', 5, 2)->nullable();

            $table->string('client_company_name');
            $table->date('verification_date')->nullable();

            $table->enum('status', [
                'verified',
                'pending',
                'revoked'
            ])->default('verified');

            $table->string('report_pdf')->nullable();
            $table->string('sample_label_image')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('batch_number');
            $table->index('status');
            $table->index('verification_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('coa_reports');
    }
};