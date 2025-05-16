<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TestOracleConnection extends Command
{
    protected $signature = 'db:test';
    protected $description = 'Test the Oracle database connection';

    public function handle()
    {
        try {
            $pdo = DB::connection()->getPdo();
            $this->info('Successfully connected to the database.');
            
            // Try to get Oracle version
            $version = $pdo->query('SELECT * FROM v$version WHERE banner LIKE \'Oracle%\'')->fetchColumn();
            $this->info('Oracle Version: ' . $version);
            
            // List all tables
            $tables = DB::select("SELECT table_name FROM user_tables");
            $this->info('Available tables:');
            foreach ($tables as $table) {
                $this->line('- ' . $table->table_name);
            }
            
        } catch (\Exception $e) {
            $this->error('Connection failed: ' . $e->getMessage());
        }
    }
} 