<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            if (!Schema::hasColumn('site_settings', 'home_hero_badge')) {
                $table->string('home_hero_badge')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_hero_title')) {
                $table->string('home_hero_title')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_hero_highlight')) {
                $table->string('home_hero_highlight')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_hero_description')) {
                $table->text('home_hero_description')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_primary_button_text')) {
                $table->string('home_primary_button_text')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_secondary_button_text')) {
                $table->string('home_secondary_button_text')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_third_button_text')) {
                $table->string('home_third_button_text')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_hero_image')) {
                $table->string('home_hero_image')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_how_image')) {
                $table->string('home_how_image')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_lab_image')) {
                $table->string('home_lab_image')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_how_title')) {
                $table->string('home_how_title')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_how_description')) {
                $table->text('home_how_description')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_lab_title')) {
                $table->string('home_lab_title')->nullable();
            }

            if (!Schema::hasColumn('site_settings', 'home_lab_description')) {
                $table->text('home_lab_description')->nullable();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('site_settings')) {
            return;
        }

        Schema::table('site_settings', function (Blueprint $table) {
            $columns = [
                'home_hero_badge',
                'home_hero_title',
                'home_hero_highlight',
                'home_hero_description',
                'home_primary_button_text',
                'home_secondary_button_text',
                'home_third_button_text',
                'home_hero_image',
                'home_how_image',
                'home_lab_image',
                'home_how_title',
                'home_how_description',
                'home_lab_title',
                'home_lab_description',
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('site_settings', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};