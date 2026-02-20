<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if notifications table exists
        if (Schema::hasTable('notifications')) {
            // Fix AUTO_INCREMENT for id column
            DB::statement('ALTER TABLE notifications MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT');
            
            // Ensure the table has all required columns with proper structure
            Schema::table('notifications', function (Blueprint $table) {
                // Add missing columns if they don't exist
                if (!Schema::hasColumn('notifications', 'title')) {
                    $table->string('title')->nullable()->after('user_id');
                }
                if (!Schema::hasColumn('notifications', 'type')) {
                    $table->string('type')->default('info')->after('message');
                }
                if (!Schema::hasColumn('notifications', 'icon')) {
                    $table->string('icon')->nullable()->after('type');
                }
                if (!Schema::hasColumn('notifications', 'link')) {
                    $table->string('link')->nullable()->after('icon');
                }
                if (!Schema::hasColumn('notifications', 'is_read')) {
                    $table->boolean('is_read')->default(false)->after('link');
                }
                if (!Schema::hasColumn('notifications', 'data')) {
                    $table->json('data')->nullable()->after('is_read');
                }
            });
            
            // Update existing records to ensure data consistency
            DB::table('notifications')->whereNull('type')->update(['type' => 'info']);
            DB::table('notifications')->whereNull('is_read')->update(['is_read' => false]);
            
            // Fix any existing records with invalid data
            DB::table('notifications')->where('type', '')->update(['type' => 'info']);
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