<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RattingProduct extends Model
{
    protected $table = 'ratting_product';

    public function account()
    {
        return $this->belongsTo('App\Models\Account', 'r_account_id');
    }
}