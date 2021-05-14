<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('pro_name')->unique();
            $table->string('pro_slug');
            $table->string('pro_code')->nullable();
            $table->integer('pro_cat_id')->index();
            $table->string('pro_avatar')->nullable();
            $table->mediumInteger('pro_price')->nullable();
            $table->integer('pro_sale')->nullable();
            $table->tinyInteger('pro_hot')->default(0)->index();
            $table->tinyInteger('pro_status')->default(1)->index();
            $table->tinyInteger('pro_pay')->default(0)->index();
            $table->string('pro_description')->nullable();
            $table->text('pro_content')->nullable();
            $table->integer('pro_number')->default(0);
            $table->integer('pro_view')->default(0);
            $table->integer('pro_review_star')->default(0);
            $table->integer('pro_review_total')->default(0);
            $table->integer('pro_user_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}