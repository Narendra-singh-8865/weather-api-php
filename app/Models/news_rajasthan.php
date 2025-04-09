<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class news_rajasthan extends Model
{
    protected $table = 'news_rajasthan'; 
    protected $fillable = ['title', 'link', 'description', 'published_at', 'image_url'];
}