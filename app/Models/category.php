<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'color',
        'description',
    ];

    public function postCategories()
    {
        return $this->hasMany(PostCategory::class);
    }
}
