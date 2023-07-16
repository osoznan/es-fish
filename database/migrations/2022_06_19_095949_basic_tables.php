<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BasicTables extends Migration
{

    public function up()
    {
      //  DB::transaction(function() {

        Schema::create('image', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url');
            $table->text('description')->nullable();
            $table->integer('category_id')->nullable();
        });

        Schema::create('product_category', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('alias');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('parent_category_id')->nullable();
            $table->unsignedBigInteger('image_id')->nullable();

            $table->string('name_ua')->nullable();
            $table->string('alias_ua')->nullable();
            $table->text('description_ua')->nullable();

            $table->string('name_en')->nullable();
            $table->string('alias_en')->nullable();
            $table->text('description_en')->nullable();

            $table->string('seo')->nullable();
            $table->string('seo_ua')->nullable();
            $table->text('seo_en')->nullable();

            $table->integer('hidden')->default(0);
            $table->boolean('main_page_present');

            $table->foreign('parent_category_id')
                ->references('id')
                ->on('product_category')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->onDelete('set null')
                ->cascadeOnUpdate();
        });

        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();

            $table->string('name');
            $table->string('name_ua')->nullable();
            $table->string('name_en')->nullable();

            $table->integer('old_price')->default(0);
            $table->integer('price')->default(0);
            $table->string('weight', 16);

            $table->unsignedBigInteger('image_id')->nullable();

            $table->text('description');
            $table->text('description_ua')->nullable();
            $table->text('description_en')->nullable();

            $table->text('properties');
            $table->text('properties_ua')->nullable();
            $table->text('properties_en')->nullable();

            $table->text('seo')->nullable();
            $table->text('seo_ua')->nullable();
            $table->text('seo_en')->nullable();

            $table->integer('present')
                ->default(1);
            $table->integer('menu_present')
                ->default(1);
            $table->integer('hidden')
                ->default(1);

            $table->integer('calc_type')->default(1);

            $table->string('alias');
            $table->string('alias_ua')->nullable();
            $table->string('alias_en')->nullable();

            $table->tinyInteger('rating')->nullable();

            $table->foreign('category_id')
                ->references('id')
                ->on('product_category')
                ->onDelete('set null')
                ->cascadeOnUpdate();

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->onDelete('set null')
                ->cascadeOnUpdate();

            $table->timestamps();
        });

        Schema::create('product_image', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('image_id');

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        //---------------------------------------------------------------
        Schema::create('payment_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('name_ua');
            $table->string('name_en');

            $table->integer('hidden')
                ->default(0);
        });

        Schema::create('delivery_type', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('name_ua');
            $table->string('name_en');

            $table->integer('hidden')
                ->default(0);
        });

        Schema::create('order_status', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->integer('hidden')
                ->default(0);
        });

        Schema::create('order', function (Blueprint $table) {
            $table->id();
            $table->string('phone', 15);
            $table->string('name');

            $table->unsignedBigInteger('payment_type_id')->nullable();
            $table->unsignedBigInteger('delivery_type_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();

            $table->float('total');
            $table->integer('seen')->default(0);
            $table->text('extra_data')->nullable();

            $table->foreign('payment_type_id')
                ->references('id')
                ->on('payment_type')
                ->onDelete('restrict')
                ->cascadeOnUpdate();

            $table->foreign('delivery_type_id')
                ->references('id')
                ->on('delivery_type')
                ->onDelete('restrict')
                ->cascadeOnUpdate();

            $table->foreign('status_id')
                ->references('id')
                ->on('order_status')
                ->onDelete('restrict')
                ->cascadeOnUpdate();

            $table->timestamps();

        });

        Schema::create('order_item', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();

            $table->integer('amount');

            $table->text('data');

            $table->foreign('order_id')
                ->references('id')
                ->on('order')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->onDelete('restrict')
                ->cascadeOnUpdate();
        });

        Schema::create('order_status_history', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('status_id')->nullable();

            $table->timestamp('created_at');

            $table->text('description')->nullable();

            $table->foreign('order_id')
                ->references('id')
                ->on('order')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreign('status_id')
                ->references('id')
                ->on('order_status')
                ->onDelete('restrict')
                ->cascadeOnUpdate();
        });

        //---------------------------------------------
        Schema::create('blog_article', function (Blueprint $table) {
            $table->id();

            $table->enum('category_id', [1, 2, 3])->default(1);

            $table->unsignedBigInteger('image_id')->nullable();

            $table->string('title')->unique();
            $table->string('title_ua');
            $table->string('title_en');

            $table->string('alias');
            $table->string('alias_ua');
            $table->string('alias_en');

            $table->text('text');
            $table->text('text_ua');
            $table->text('text_en');

            $table->integer('hidden')->default(1);
            $table->timestamps();

            $table->foreign('image_id')
                ->references('id')
                ->on('image')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        //-----------------------------------------------------
        Schema::create('comment', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_id')->nullable();

            $table->string('name');
            $table->text('text');
            $table->text('answer')->nullable();

            $table->tinyInteger('rate')->default(0);
            $table->tinyInteger('hidden')->default(0);

            $table->timestamp('answer_created_at')->nullable();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('product')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::create('main_gallery', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('title_ua');
            $table->string('title_en');

            $table->text('text');
            $table->text('text_ua');
            $table->text('text_en');

            $table->text('link');
        });
     //   });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('main_gallery');
        Schema::drop('comment');
        Schema::drop('blog_article');
        Schema::drop('order_status_history');
        Schema::drop('order_item');
        Schema::drop('order');
        Schema::drop('order_status');
        Schema::drop('delivery_type');
        Schema::drop('payment_type');
        Schema::drop('product');
        Schema::drop('product_category');
        Schema::drop('product_image');
        Schema::drop('image');
    }
}
