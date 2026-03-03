<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Condominio;
use App\Models\Morador;
use App\Models\Encomenda;
use App\Traits\BelongsToCondominio;



class Apartamento extends Model
{
    use BelongsToCondominio;
    protected $fillable = ['numero', 'bloco', 'condominio_id'];

    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    public function moradores()
    {
        return $this->hasMany(Morador::class);
    }
    public function encomendas()
    {
        return $this->hasMany(Encomenda::class);
    }
}
