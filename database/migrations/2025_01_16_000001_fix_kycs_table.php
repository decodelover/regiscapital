<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // First, check if the table exists and fix the AUTO_INCREMENT issue
        if (Schema::hasTable('kycs')) {
            // Ensure AUTO_INCREMENT is properly set for the id column
            DB::statement('ALTER TABLE kycs MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
            
            // Add missing columns if they don't exist
            Schema::table('kycs', function (Blueprint $table) {
                if (!Schema::hasColumn('kycs', 'statenumber')) {
                    $table->string('statenumber', 50)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'accounttype')) {
                    $table->string('accounttype', 50)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'employer')) {
                    $table->string('employer', 50)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'income')) {
                    $table->string('income', 100)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'kinname')) {
                    $table->string('kinname', 150)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'kinaddress')) {
                    $table->string('kinaddress', 255)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'relationship')) {
                    $table->string('relationship', 100)->nullable();
                }
                if (!Schema::hasColumn('kycs', 'age')) {
                    $table->integer('age')->nullable();
                }
                if (!Schema::hasColumn('kycs', 'title')) {
                    $table->string('title', 225)->nullable();
                }
            });
            
            // Update existing records with NULL status to have default status
            DB::table('kycs')->whereNull('status')->update(['status' => 'Under review']);
            
            // Fix any existing records with invalid data
            DB::table('kycs')->where('status', '')->update(['status' => 'Under review']);
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
        // If needed, the changes can be reverted manually
    }
}