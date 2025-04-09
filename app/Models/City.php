<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table = 'citys';

    protected $fillable = ['name', 'state_code'];

    public function state()
    {
        return $this->belongsTo(State::class, 'state_code', 'state_code');
    }
}
