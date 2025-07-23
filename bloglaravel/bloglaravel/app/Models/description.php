<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class description extends Model
{
   protected $fillable = [
        'title_id', 
        'category_id', 
        'description', 
        'created_at', 
        'updated_at', 
    ];  
}
