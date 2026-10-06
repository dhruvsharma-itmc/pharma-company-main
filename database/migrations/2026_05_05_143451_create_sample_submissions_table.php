<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sample_submissions', function (Blueprint $table) {
            $table->id();

            $table->string('company_name');
            $table->string('contact_name')->nullable();
            $table->string('email');
            $table->string('phone')->nullable();

            $table->string('product_name');
            $table->string('batch_number')->nullable();
            $table->string('strength')->nullable();

            $table->text('notes')->nullable();

            $table->string('sample_label_image')->nullable();
            $table->string('coa_file')->nullable();

            $table->enum('status', [
                'new',
                'under_review',
                'verified',
                'rejected'
            ])->default('new');

            $table->timestamps();

            $table->index('email');
            $table->index('batch_number');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sample_submissions');
    }
};