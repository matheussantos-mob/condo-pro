<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToCondominio
{
    protected static function booted()
    {
        static::addGlobalScope('condominio', function (Builder $builder) {
            if (auth()->check()) {
                $user = auth()->user();

                $condoId = ($user->role === 'admin')
                    ? session('admin_condominio_id')
                    : $user->condominio_id;

                if ($condoId) {
                    $builder->where($builder->getQuery()->from . '.condominio_id', $condoId);
                } else {
                    if ($user->role !== 'admin') {
                        $builder->whereRaw('1 = 0');
                    }
                }
            }
        });

        static::creating(function ($model) {
            if (Auth::check()) {
                $user = Auth::user();
                $condoId = ($user->role === 'admin')
                    ? session('admin_condominio_id')
                    : $user->condominio_id;

                if ($condoId) {
                    $model->condominio_id = $condoId;
                }
            }
        });
    }
}
