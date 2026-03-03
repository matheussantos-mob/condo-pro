<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToCondominio;


class Encomenda extends Model
{
    use BelongsToCondominio;

    protected $fillable = [
        'apartamento_id',
        'condominio_id',
        'descricao',
        'setor_estoque',
        'codigo_retirada',
        'status',
        'recebido_por',
        'retirado_por',
        'entregue_em' => 'datetime',
        'notificado_em',
        'entregue_em',
        'user_id',
        'notificado_por_id',
        'entregue_por_id',
        'cadastrado_por_id',
    ];

    protected $casts = [
        'entregue_em' => 'datetime',
        'notificado_em' => 'datetime',
    ];

    public function apartamento()
    {
        return $this->belongsTo(Apartamento::class);
    }

    public function condominio()
    {
        return $this->belongsTo(Condominio::class);
    }

    public function cadastradoPor()
    {
        return $this->belongsTo(User::class, 'cadastrado_por_id');
    }

    public function notificadoPor()
    {
        return $this->belongsTo(User::class, 'notificado_por_id');
    }

    public function entreguePor()
    {
        return $this->belongsTo(User::class, 'entregue_por_id');
    }
}
