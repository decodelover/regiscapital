<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class DatabaseValidationService
{
    /**
     * Validate and fix common database issues.
     *
     * @return array
     */
    public static function validateAndFix()
    {
        $issues = [];
        $fixes = [];

        // Check and fix AUTO_INCREMENT issues
        $autoIncrementIssues = self::checkAutoIncrementIssues();
        if (!empty($autoIncrementIssues)) {
            $issues = array_merge($issues, $autoIncrementIssues);
            $fixes = array_merge($fixes, self::fixAutoIncrementIssues($autoIncrementIssues));
        }

        // Check for missing columns
        $missingColumns = self::checkMissingColumns();
        if (!empty($missingColumns)) {
            $issues = array_merge($issues, $missingColumns);
        }

        // Check for NULL values in required fields
        $nullValueIssues = self::checkNullValueIssues();
        if (!empty($nullValueIssues)) {
            $issues = array_merge($issues, $nullValueIssues);
            $fixes = array_merge($fixes, self::fixNullValueIssues($nullValueIssues));
        }

        return [
            'issues' => $issues,
            'fixes' => $fixes,
            'status' => empty($issues) ? 'healthy' : 'issues_found'
        ];
    }

    /**
     * Check for AUTO_INCREMENT issues in critical tables.
     *
     * @return array
     */
    protected static function checkAutoIncrementIssues()
    {
        $issues = [];
        $criticalTables = ['users', 'kycs', 'crypto_accounts', 'deposits', 'withdrawals', 'notifications'];

        foreach ($criticalTables as $table) {
            if (Schema::hasTable($table)) {
                $result = DB::select("SHOW CREATE TABLE {$table}");
                $createStatement = $result[0]->{'Create Table'};
                
                if (!str_contains($createStatement, 'AUTO_INCREMENT')) {
                    $issues[] = "Table '{$table}' is missing AUTO_INCREMENT on id column";
                }
            }
        }

        return $issues;
    }

    /**
     * Fix AUTO_INCREMENT issues.
     *
     * @param array $issues
     * @return array
     */
    protected static function fixAutoIncrementIssues($issues)
    {
        $fixes = [];

        foreach ($issues as $issue) {
            if (preg_match("/Table '(\w+)' is missing AUTO_INCREMENT/", $issue, $matches)) {
                $table = $matches[1];
                try {
                    DB::statement("ALTER TABLE {$table} MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT");
                    $fixes[] = "Fixed AUTO_INCREMENT for table '{$table}'";
                } catch (\Exception $e) {
                    Log::error("Failed to fix AUTO_INCREMENT for table '{$table}': " . $e->getMessage());
                }
            }
        }

        return $fixes;
    }

    /**
     * Check for missing columns in tables.
     *
     * @return array
     */
    protected static function checkMissingColumns()
    {
        $issues = [];
        
        // Check KYC table for required columns
        if (Schema::hasTable('kycs')) {
            $requiredColumns = ['statenumber', 'accounttype', 'employer', 'income', 'kinname', 'kinaddress', 'relationship'];
            foreach ($requiredColumns as $column) {
                if (!Schema::hasColumn('kycs', $column)) {
                    $issues[] = "Missing column '{$column}' in kycs table";
                }
            }
        }

        return $issues;
    }

    /**
     * Check for NULL values in critical fields.
     *
     * @return array
     */
    protected static function checkNullValueIssues()
    {
        $issues = [];

        // Check for NULL status in kycs table
        if (Schema::hasTable('kycs')) {
            $nullStatusCount = DB::table('kycs')->whereNull('status')->count();
            if ($nullStatusCount > 0) {
                $issues[] = "Found {$nullStatusCount} KYC records with NULL status";
            }
        }

        return $issues;
    }

    /**
     * Fix NULL value issues.
     *
     * @param array $issues
     * @return array
     */
    protected static function fixNullValueIssues($issues)
    {
        $fixes = [];

        foreach ($issues as $issue) {
            if (str_contains($issue, 'KYC records with NULL status')) {
                try {
                    $updated = DB::table('kycs')->whereNull('status')->update(['status' => 'Under review']);
                    $fixes[] = "Updated {$updated} KYC records with default status";
                } catch (\Exception $e) {
                    Log::error("Failed to fix NULL status in kycs table: " . $e->getMessage());
                }
            }

            if (str_contains($issue, 'notifications with NULL type or is_read values')) {
                try {
                    $updatedType = DB::table('notifications')->whereNull('type')->update(['type' => 'info']);
                    $updatedRead = DB::table('notifications')->whereNull('is_read')->update(['is_read' => false]);
                    $fixes[] = "Updated {$updatedType} notifications with default type and {$updatedRead} with default is_read value";
                } catch (\Exception $e) {
                    Log::error("Failed to fix NULL values in notifications table: " . $e->getMessage());
                }
            }

            if (str_contains($issue, 'crypto accounts with NULL balances')) {
                try {
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
                    $fixes[] = "Updated {$updated} crypto accounts with default balance values";
                } catch (\Exception $e) {
                    Log::error("Failed to fix NULL balances in crypto_accounts table: " . $e->getMessage());
                }
            }
        }

        return $fixes;
    }
}