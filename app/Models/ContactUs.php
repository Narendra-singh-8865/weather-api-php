<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactUs extends Model
{
    use SoftDeletes;  


    protected $dates = ['deleted_at']; 

    
    protected $fillable = [
        'title',
        'email',
        'message',
    ];
}

