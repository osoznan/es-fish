<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('product', function(Blueprint $table) {
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->string('seo_keywords_en')->nullable();
            $table->string('seo_description_en')->nullable();
            $table->string('seo_title_ua')->nullable();
            $table->string('seo_keywords_ua')->nullable();
            $table->string('seo_description_ua')->nullable();

            $table->removeColumn('seo');
            $table->removeColumn('seo_en');
            $table->removeColumn('seo_ua');
        });

        Schema::table('product_category', function(Blueprint $table) {
            $table->string('seo_title')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('seo_description')->nullable();
            $table->string('seo_title_en')->nullable();
            $table->string('seo_keywords_en')->nullable();
            $table->string('seo_description_en')->nullable();
            $table->string('seo_title_ua')->nullable();
            $table->string('seo_keywords_ua')->nullable();
            $table->string('seo_description_ua')->nullable();

            $table->removeColumn('seo');
            $table->removeColumn('seo_en');
            $table->removeColumn('seo_ua');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
