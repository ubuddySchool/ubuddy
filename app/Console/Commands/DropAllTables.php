<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DropAllTables extends Command
{
    protected $signature = 'db:drop-all';
    protected $description = 'Drop all tables in the database';

    public function handle()
    {
        $this->info('Dropping all tables...');

        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');

        // Get the list of all tables in the database
        $tables = DB::select('SHOW TABLES');

        foreach ($tables as $table) {
            $tableName = current($table);

            // Skip the migrations table or any other tables you want to keep
            if ($tableName === 'migrations') {
                continue;
            }

            // Drop each table
            DB::statement("DROP TABLE IF EXISTS $tableName");

            $this->info("Dropped table: $tableName");
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $this->info('All tables have been dropped.');
    }
}
