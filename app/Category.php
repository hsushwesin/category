<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table="categories";
    protected $primaryKey = 'category_id';
    protected $fillable = ['name', 'parent_id', 'sort_order'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'category_id')->orderBy('sort_order', 'ASC');
    }
}
