<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class blog_title extends Model
{
 protected $table = 'blog_title'; 
    protected $fillable = [
        'entity_id', 
        'category_id', 
        'title', 
        'short_description', 
        'image_url', 
        'param_link', 
        'read_time', 
        'created_at', 
        'updated_at', 
        'deleted_at', 
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
