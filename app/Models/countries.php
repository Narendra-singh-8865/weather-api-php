<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class countries extends Model
{
    protected $fillable = [
        'name',
        'code',
        'continent',
        'area',
    ];
}

