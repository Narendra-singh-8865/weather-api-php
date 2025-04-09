<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class StoreScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {

        

            $user = auth()->user();

            
            if($user){

                return $builder->where('store_id', $user->store_id);
            }
            
            
            

            

        

        
    }
}
