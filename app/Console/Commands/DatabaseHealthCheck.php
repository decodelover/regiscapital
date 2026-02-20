<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DatabaseHealthCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:health-check {--fix : Automatically fix detected issues}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check database health and optionally fix common issues';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting database health check...');
        
        $issues = [];
        $fixes = [];
        
        // Check AUTO_INCREMENT issues
        $autoIncrementIssues = $this->checkAutoIncrementIssues();
        $issues = array_merge($issues, $autoIncrementIssues);
        
        // Check NULL value issues
        $nullValueIssues = $this->checkNullValueIssues();
        $issues = array_merge($issues, $nullValueIssues);
        
        // Check table structure issues
        $structureIssues = $this->checkTableStructure();
        $issues = array_merge($issues, $structureIssues);
        
        if (empty($issues)) {
            $this->info('✅ Database health check passed - no issues found!');
            return 0;
        }
        
        $this->warn('⚠️  Found ' . count($issues) . ' database issues:');
        foreach ($issues as $issue) {
            $this->line('  - ' . $issue);
        }
        
        if ($this->option('fix')) {
            $this->info('🔧 Attempting to fix issues...');
            $fixes = $this->fixIssues($issues);
            
            if (!empty($fixes)) {
                $this->info('✅ Applied fixes:');
                foreach ($fixes as $fix) {
                    $this->line('  - ' . $fix);
                }
            }
        } else {
            $this->info('💡 Run with --fix option to automatically fix these issues');
        }
        
        return 0;
    }
    
    /**
     * Check for AUTO_INCREMENT issues.
     *
     * @return array
     */
    protected function checkAutoIncrementIssues()
    {
        $issues = [];
        $tables = ['kycs', 'notifications', 'crypto_accounts'];
        
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) {
                continue;
            }
            
            try {
                $result = DB::select("SHOW CREATE TABLE {$table}");
                $createStatement = $result[0]->{'Create Table'};
                
                if (!str_contains($createStatement, 'AUTO_INCREMENT')) {
                    $issues[] = "Table '{$table}' missing AUTO_INCREMENT on id column";
                }
            } catch (\Exception $e) {
                $issues[] = "Could not check AUTO_INCREMENT for table '{$table}': " . $e->getMessage();
            }
        }
        
        return $issues;
    }
    
    /**
     * Check for NULL value issues.
     *
     * @return array
     */
    protected function checkNullValueIssues()
    {
        $issues = [];
        
        // Check kycs table
        if (Schema::hasTable('kycs')) {
            $nullKycs = DB::table('kycs')->whereNull('status')->count();
            if ($nullKycs > 0) {
                $issues[] = "Found {$nullKycs} KYC records with NULL status";
            }
        }
        
        // Check notifications table
        if (Schema::hasTable('notifications')) {
            $nullNotifications = DB::table('notifications')
                ->where(function($query) {
                    $query->whereNull('type')->orWhereNull('is_read');
                })
                ->count();
            if ($nullNotifications > 0) {
                $issues[] = "Found {$nullNotifications} notifications with NULL type or is_read values";
            }
        }
        
        // Check crypto_accounts table
        if (Schema::hasTable('crypto_accounts')) {
            $nullCrypto = DB::table('crypto_accounts')
                ->where(function($query) {
                    $query->whereNull('btc')
                          ->orWhereNull('eth')
                          ->orWhereNull('ltc')
                          ->orWhereNull('usdt');
                })
                ->count();
            if ($nullCrypto > 0) {
                $issues[] = "Found {$nullCrypto} crypto accounts with NULL balances";
            }
        }
        
        return $issues;
    }
    
    /**
     * Check table structure issues.
     *
     * @return array
     */
    protected function checkTableStructure()
    {
        $issues = [];
        
        // Check if notifications table has required columns
        if (Schema::hasTable('notifications')) {
            $requiredColumns = ['id', 'user_id', 'type', 'message', 'is_read', 'created_at', 'updated_at'];
            foreach ($requiredColumns as $column) {
                if (!Schema::hasColumn('notifications', $column)) {
                    $issues[] = "Notifications table missing required column: {$column}";
                }
            }
            
            // Check for PRIMARY KEY constraint
            $pkExists = DB::select("
                SELECT COUNT(*) as count
                FROM information_schema.table_constraints 
                WHERE table_schema = DATABASE() 
                AND table_name = 'notifications' 
                AND constraint_type = 'PRIMARY KEY'
            ");
            
            if ($pkExists[0]->count == 0) {
                $issues[] = "Notifications table missing PRIMARY KEY constraint on id column";
            }
        }
        
        // Check other critical tables for PRIMARY KEY
        $criticalTables = ['kycs', 'crypto_accounts', 'users'];
        foreach ($criticalTables as $table) {
            if (Schema::hasTable($table)) {
                $pkExists = DB::select("
                    SELECT COUNT(*) as count
                    FROM information_schema.table_constraints 
                    WHERE table_schema = DATABASE() 
                    AND table_name = ? 
                    AND constraint_type = 'PRIMARY KEY'
                ", [$table]);
                
                if ($pkExists[0]->count == 0) {
                    $issues[] = "Table '{$table}' missing PRIMARY KEY constraint";
                }
            }
        }
        
        return $issues;
    }
    
    /**
     * Fix detected issues.
     *
     * @param array $issues
     * @return array
     */
    protected function fixIssues($issues)
    {
        $fixes = [];
        
        foreach ($issues as $issue) {
            try {
                if (str_contains($issue, 'AUTO_INCREMENT')) {
                    if (str_contains($issue, 'kycs')) {
                        DB::statement('ALTER TABLE kycs MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                        $fixes[] = "Fixed AUTO_INCREMENT for kycs table";
                    } elseif (str_contains($issue, 'notifications')) {
                        DB::statement('ALTER TABLE notifications MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                        $fixes[] = "Fixed AUTO_INCREMENT for notifications table";
                    } elseif (str_contains($issue, 'crypto_accounts')) {
                        DB::statement('ALTER TABLE crypto_accounts MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
                        $fixes[] = "Fixed AUTO_INCREMENT for crypto_accounts table";
                    }
                } elseif (str_contains($issue, 'PRIMARY KEY constraint')) {
                    if (str_contains($issue, 'notifications')) {
                        DB::statement('ALTER TABLE notifications ADD PRIMARY KEY (id)');
                        $fixes[] = "Added PRIMARY KEY to notifications table";
                    } elseif (str_contains($issue, 'kycs')) {
                        DB::statement('ALTER TABLE kycs ADD PRIMARY KEY (id)');
                        $fixes[] = "Added PRIMARY KEY to kycs table";
                    } elseif (str_contains($issue, 'crypto_accounts')) {
                        DB::statement('ALTER TABLE crypto_accounts ADD PRIMARY KEY (id)');
                        $fixes[] = "Added PRIMARY KEY to crypto_accounts table";
                    } elseif (str_contains($issue, 'users')) {
                        DB::statement('ALTER TABLE users ADD PRIMARY KEY (id)');
                        $fixes[] = "Added PRIMARY KEY to users table";
                    }
                } elseif (str_contains($issue, 'NULL status')) {
                    $updated = DB::table('kycs')->whereNull('status')->update(['status' => 'Under review']);
                    $fixes[] = "Updated {$updated} KYC records with default status";
                } elseif (str_contains($issue, 'NULL type or is_read')) {
                    $updatedType = DB::table('notifications')->whereNull('type')->update(['type' => 'info']);
                    $updatedRead = DB::table('notifications')->whereNull('is_read')->update(['is_read' => false]);
                    $fixes[] = "Updated notifications: {$updatedType} with default type, {$updatedRead} with default is_read";
                } elseif (str_contains($issue, 'NULL balances')) {
                    $updated = DB::table('crypto_accounts')
                        ->where(function($query) {
                            $query->whereNull('btc')
                                  ->orWhereNull('eth')
                                  ->orWhereNull('ltc')
                                  ->orWhereNull('usdt');
                        })
                        ->update([
                            'btc' => DB::raw('COALESCE(btc, 0)'),
                            'eth' => DB::raw('COALESCE(eth, 0)'),
                            'ltc' => DB::raw('COALESCE(ltc, 0)'),
                            'usdt' => DB::raw('COALESCE(usdt, 0)'),
                        ]);
                    $fixes[] = "Updated {$updated} crypto accounts with default balances";
                }
            } catch (\Exception $e) {
                Log::error("Failed to fix issue: {$issue}", ['error' => $e->getMessage()]);
                $this->error("Failed to fix: {$issue} - " . $e->getMessage());
            }
        }
        
        return $fixes;
    }
}