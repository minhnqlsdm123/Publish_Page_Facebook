<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRattingProduct extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratting_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('r_account_id')->default(0)->index();
            $table->integer('r_product_id')->index();
            $table->tinyInteger('r_num_star')->default(1);
            $table->string('r_content');
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
        Schema::dropIfExists('ratting_product');
    }
}