<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ImportSql extends Command
{
    protected $signature = 'db:import-sql';
    protected $description = 'Import SQL file';

    public function handle()
    {
        $sql = File::get(base_path('backup_postgresql.sql'));
        DB::unprepared($sql);
        $this->info('SQL imported successfully!');
    }
}