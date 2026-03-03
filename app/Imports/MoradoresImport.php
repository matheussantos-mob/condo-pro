<?php

namespace App\Imports;

use App\Models\Apartamento;
use App\Models\Morador;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class MoradoresImport implements ToCollection, WithHeadingRow
{
    protected $condominioId;

    public function __construct($condominioId)
    {
        $this->condominioId = $condominioId;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $apartamento = Apartamento::firstOrCreate([
                'condominio_id' => $this->condominioId,
                'bloco'         => $row['bloco'],
                'numero'        => $row['apartamento'],
            ]);

            Morador::create([
                'apartamento_id' => $apartamento->id,
                'condominio_id'  => $this->condominioId,
                'nome'           => $row['nome'],
                'whatsapp'       => $row['whatsapp'],
            ]);
        }
    }
}