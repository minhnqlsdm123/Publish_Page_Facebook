<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavouriteProduct extends Model
{
    protected $table = 'favourites_products';

    public $timestamps = false;

    protected $fillable = ['fp_user_id', 'fp_product_id'];
}