<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

// general Scope for any model
class UserScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        if (auth()->check()){
            if (auth()->user()->role != "Super-Admin" ){
                    $builder->whereIn($model->getTable().'.user_id' , auth()->id());
            }
        }
    }
}