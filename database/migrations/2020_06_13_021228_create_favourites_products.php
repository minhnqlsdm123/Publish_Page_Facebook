<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavouritesProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favourites_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('fp_user_id')->index();
            $table->integer('fp_product_id')->index();
            $table->unique(['fp_user_id', 'fp_product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favourites_products');
    }
}