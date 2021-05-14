<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    protected $casts = [
        'pro_image_detail' => 'array',
    ];

    protected $fillable = [
        'pro_name', 'pro_cat_id', 'pro_price', 'pro_sale', 'pro_status', 'pro_hot', 'pro_avatar', 'pro_image_detail', 'pro_description', 'pro_content'
    ];

    protected $status = [
        0 => [
            'name' => 'private',
            'class' => 'warning'
        ],
        1 => [
            'name' => 'active',
            'class' => 'success'
        ],
    ];
    protected $hot = [
        0 => [
            'name' => 'default',
            'class' => 'default'
        ],
        1 => [
            'name' => 'hot',
            'class' => 'danger'
        ]
    ];


    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'pro_cat_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'categories_products', 'product_id', 'category_id');
    }
    // Laravel get all parents of category
    public function childrens()
    {
        return $this->hasMany('App\Models\Category', 'c_parent_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'c_parent_id', 'id');
    }
    //lấy ra các đánh giá của 1 sản phẩm
    public function getAllParents()
    {
        $parents = collect([]);
        $parent = $this->parent;

        while (!is_null($parent)) {
            $parents->push($parent);
            $parent = $parent->parent;
        }

        return $parents;
    }

    public function getStatus()
    {
        return array_get($this->status, $this->pro_status);
    }
    public function getHot()
    {
        return array_get($this->hot, $this->pro_hot);
    }
}