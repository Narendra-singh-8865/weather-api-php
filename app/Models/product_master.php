<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class product_master extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'entity_id',
        'name',
        'image',
        'price',
        'discount',
        'price_after_discount',
        'original_quantity',
        'current_orders',
        'current_quantity',
        'category_id',
        'brand_id',
        'number_of_review',
        'rating',
        'status',
    ];
 
   
 protected static function boot()
{
    parent::boot();

    static::addGlobalScope(new \App\Scopes\StoreScope());

    static::creating(function ($model) {
        $model->entity_id = entity_id();
       
    });
}

}

class Category extends Model
{
    use SoftDeletes; 

    protected $dates = ['deleted_at']; 

    protected $fillable = [
        'name',  
        'description',
    ];
}