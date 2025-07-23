<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; 
    protected $fillable = [
        'entity_id', 
        'name', 
        'meta_title', 
        'meta_description', 
        'created_at', 
        'updated_at', 
        'deleted_at', 
    ]; 
}
