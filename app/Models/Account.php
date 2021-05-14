<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Account extends Authenticatable
{
    use Notifiable;

    protected $table = 'account';
    protected $guard = 'account';

    protected $fillable = ['name', 'phone', 'avatar', 'password', 'address', 'google_id'];
}