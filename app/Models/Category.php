<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'category';

    protected $fillable = ['c_name', 'c_status', 'c_slug', 'c_keyword', 'c_description', 'c_parent_id'];

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

    public function getStatus()
    {
        return array_get($this->status, $this->c_status);
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
}