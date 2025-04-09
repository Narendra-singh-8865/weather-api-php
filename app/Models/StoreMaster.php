<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StoreMaster extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = [
         'deleted_at',
    ];


    protected $fillable = [
        'id',
        'entity_id',
        'name',
        'owner',
        'mobile',
        'status',
        'gst',
        'gst_no',
        'pan',
        'website',
        'created_at',
        'updated_at'
    ];

    protected $table = 'store_masters';

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        

        static::creating(function ($model) {
            $model->entity_id = entity_id();
        });
    }

    public function users()
    {
        return $this->hasMany(User::class, 'store_id');
    }


}
