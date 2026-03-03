<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToCondominio
{
    protected static function bootBelongsToCondominio()
    {
        static::addGlobalScope('condominio', function (Builder $builder) {
            if (Auth::check()) {
                $user = Auth::user();

                if ($user->role === 'admin') {
                    if (session()->has('admin_condominio_id')) {
                        $builder->where($builder->getQuery()->from . '.condominio_id', session('admin_condominio_id'));
                    }
                } else {
                    $builder->where($builder->getQuery()->from . '.condominio_id', $user->condominio_id);
                }
            }
        });

        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->condominio_id) {
                $model->condominio_id = Auth::user()->condominio_id;
            }
        });
    }
}
