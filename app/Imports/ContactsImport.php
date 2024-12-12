<?php

namespace App\Imports;

use App\Telefone;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContactsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Ignorar linhas sem Nome ou Telefone
        if (empty($row['nome']) || empty($row['telefone'])) {
            return null;
        }

        return new Telefone([
            'nome'         => trim($row['nome']),
            'departamento' => trim($row['departamento'] ?? 'N/A'),
            'funcao'       => trim($row['funcao'] ?? 'N/A'),
            'telefone' => !empty(trim($row['telefone'])) ? trim($row['telefone']) : null,

            'email'        => trim($row['email'] ?? null),
        ]);
    }
}
