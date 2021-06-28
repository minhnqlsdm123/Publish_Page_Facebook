<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    const STATUS_PUBLISH = 1; //Đã đăng lên facebook
    const STATUS_UNPUBLISH = 2; // chưa đăng lên facebook
    const STATUS_PUBLISH_SCHEDULED = 3; // Hẹn lịch đăng lên facebook
    protected $table = 'posts';

    protected $fillable = ['id', 'post_id', 'message', 'facebook_page_id','published_time', 'status', 'published'];

//    protected $status = [
//        0 => [
//            'name' => 'private',
//            'class' => 'warning'
//        ],
//        1 => [
//            'name' => 'active',
//            'class' => 'success'
//        ],
//    ];
//
//    public function getStatus()
//    {
//        return array_get($this->status, $this->c_status);
//    }

    public function file() {
        return $this->hasMany('App\Models\Files');
    }
}
