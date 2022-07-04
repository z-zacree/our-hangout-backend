<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = false;

    protected $fillable = [
        'post_id',
        'name',
    ];

    protected $hidden = [
        'post_id',
        'deleted_at'
    ];

    protected $casts = [
        'deleted_at' => 'timestamp'
    ];

    public function posts() {
        return $this->belongsTo(Post::class);
    }
}
