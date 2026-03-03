<?php

namespace App\Imports;

use App\Models\Apartamento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CondominioImport implements ToModel, WithHeadingRow
{
    protected $condominioId;

    public function __construct($condominioId)
    {
        $this->condominioId = $condominioId;
    }

    public function model(array $row)
    {
        return new Apartamento([
            'bloco'         => $row['bloco'],
            'numero'        => $row['numero'],
            'condominio_id' => $this->condominioId,
        ]);
    }
}