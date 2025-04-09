<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'entity_id',
        'parent_id',
        'store_id',
        'status',
        'code',
        'name',
        'description',
        'stock_quantity',
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
