<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entity_id',
        'store_id',
        'name',
        'price',
        'discount',
        'price_after_discount',
        'category_id',
        'tax_id',
        'status',
        'stock_status',
        'brand_id',
        'stock_notification',
        'quantity',
        'purchased',
        'remaining',
        'short_description',
        'created_at',
        'updated_at',
    ];

    public $timestamps = true;
    
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new \App\Scopes\StoreScope());

        static::creating(function ($model) {
            $model->entity_id = entity_id();
        });
    }

    
}
