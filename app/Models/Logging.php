<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Logging extends Model
{
    use HasFactory;

    

    /**
     * The table associated with the model.
     *
     * @var string
     */
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'entity_id','store_id', 'user_id','url', 'request_data', 'response_data',
        'headers','ip_address','visits','response_code','ttl_time','created_at'
    ];

    

    public $timestamps = false;
    


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->entity_id = Str::uuid()->toString();
            
            
        });
    }
    

    

}
