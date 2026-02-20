<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixCryptoAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, check if the table exists and fix the AUTO_INCREMENT issue
        if (Schema::hasTable('crypto_accounts')) {
            // Add AUTO_INCREMENT to the id column if it doesn't have it
            DB::statement('ALTER TABLE crypto_accounts MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT');
            
            // Add missing columns with default values if they don't exist
            Schema::table('crypto_accounts', function (Blueprint $table) {
                if (!Schema::hasColumn('crypto_accounts', 'bnb')) {
                    $table->float('bnb')->default(0)->nullable();
                }
                if (!Schema::hasColumn('crypto_accounts', 'ada')) {
                    $table->float('ada')->default(0)->nullable();
                }
            });
            
            // Set default values for existing records with NULL balances
            DB::table('crypto_accounts')->whereNull('btc')->update(['btc' => 0]);
            DB::table('crypto_accounts')->whereNull('eth')->update(['eth' => 0]);
            DB::table('crypto_accounts')->whereNull('ltc')->update(['ltc' => 0]);
            DB::table('crypto_accounts')->whereNull('xrp')->update(['xrp' => 0]);
            DB::table('crypto_accounts')->whereNull('link')->update(['link' => 0]);
            DB::table('crypto_accounts')->whereNull('bnb')->update(['bnb' => 0]);
            DB::table('crypto_accounts')->whereNull('aave')->update(['aave' => 0]);
            DB::table('crypto_accounts')->whereNull('usdt')->update(['usdt' => 0]);
            DB::table('crypto_accounts')->whereNull('xlm')->update(['xlm' => 0]);
            DB::table('crypto_accounts')->whereNull('bch')->update(['bch' => 0]);
            DB::table('crypto_accounts')->whereNull('ada')->update(['ada' => 0]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // This migration fixes critical issues, so we don't reverse it
        // If needed, the AUTO_INCREMENT can be removed manually
    }
}