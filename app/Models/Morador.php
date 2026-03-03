<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCondominio;

class Morador extends Model
{
    use BelongsToCondominio;

    protected $table = 'moradors';
    protected $fillable = ['apartamento_id', 'nome', 'whatsapp', 'condominio_id'];

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}