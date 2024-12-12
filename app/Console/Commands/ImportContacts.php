<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ContactsImport;

class ImportContacts extends Command
{
    protected $signature = 'contacts:import {file}';
    protected $description = 'Importar contatos de um arquivo Excel ou CSV';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!file_exists($filePath)) {
            $this->error('Arquivo não encontrado!');
            return 1;
        }

        try {
            Excel::import(new ContactsImport, $filePath);
            $this->info('Contatos importados com sucesso!');
        } catch (\Exception $e) {
            $this->error('Erro ao importar contatos: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
