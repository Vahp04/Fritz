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
        // Buscar el archivo en varias ubicaciones posibles
        $possiblePaths = [
            database_path('backup_postgresql.sql'),
            base_path('database/backup_postgresql.sql'),
            base_path('backup_postgresql.sql'),
        ];

        $sqlPath = null;
        foreach ($possiblePaths as $path) {
            if (File::exists($path)) {
                $sqlPath = $path;
                break;
            }
        }

        if (!$sqlPath) {
            $this->error("SQL file not found. Tried:");
            foreach ($possiblePaths as $path) {
                $this->error(" - " . $path);
            }
            return 1;
        }

        $this->info("Found SQL file at: " . $sqlPath);
        $this->info("Importing... This may take a few minutes.");

        try {
            $sql = File::get($sqlPath);
            DB::unprepared($sql);
            $this->info("✅ SQL imported successfully!");
        } catch (\Exception $e) {
            $this->error("❌ Error importing SQL: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}