<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class state extends Model
{
    use HasFactory;
    protected $fillable = [
        'state_code',
        'state_code',
        'population',
        'area',
        'code',
    ];
}
