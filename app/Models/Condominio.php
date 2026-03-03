<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Condominio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'total_blocos',
        'andares_por_bloco',
        'unidades_por_andar',
    ];

    public function apartamentos()
    {
        return $this->hasMany(Apartamento::class);
    }
    
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
