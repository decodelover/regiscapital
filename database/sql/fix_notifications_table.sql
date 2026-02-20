-- Fix notifications table AUTO_INCREMENT and structure issues
-- This script addresses the QueryException related to missing default values

-- First, check if the table exists
SET @table_exists = (SELECT COUNT(*) FROM information_schema.tables 
                    WHERE table_schema = DATABASE() AND table_name = 'notifications');

-- Only proceed if table exists
SET @sql = IF(@table_exists > 0, 
    'ALTER TABLE notifications MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT',
    'SELECT "Table notifications does not exist" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ensure all required columns exist with proper defaults
SET @sql = IF(@table_exists > 0, 
    'ALTER TABLE notifications 
     MODIFY COLUMN type varchar(255) NOT NULL DEFAULT "info",
     MODIFY COLUMN is_read tinyint(1) NOT NULL DEFAULT 0',
    'SELECT "Skipping column modifications - table does not exist" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Add missing columns if they don't exist
SET @sql = IF(@table_exists > 0 AND NOT EXISTS(
    SELECT * FROM information_schema.columns 
    WHERE table_schema = DATABASE() AND table_name = 'notifications' AND column_name = 'title'
), 'ALTER TABLE notifications ADD COLUMN title varchar(255) DEFAULT NULL', 'SELECT "Column title already exists or table missing" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = IF(@table_exists > 0 AND NOT EXISTS(
    SELECT * FROM information_schema.columns 
    WHERE table_schema = DATABASE() AND table_name = 'notifications' AND column_name = 'icon'
), 'ALTER TABLE notifications ADD COLUMN icon varchar(255) DEFAULT NULL', 'SELECT "Column icon already exists or table missing" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = IF(@table_exists > 0 AND NOT EXISTS(
    SELECT * FROM information_schema.columns 
    WHERE table_schema = DATABASE() AND table_name = 'notifications' AND column_name = 'link'
), 'ALTER TABLE notifications ADD COLUMN link varchar(255) DEFAULT NULL', 'SELECT "Column link already exists or table missing" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = IF(@table_exists > 0 AND NOT EXISTS(
    SELECT * FROM information_schema.columns 
    WHERE table_schema = DATABASE() AND table_name = 'notifications' AND column_name = 'data'
), 'ALTER TABLE notifications ADD COLUMN data text DEFAULT NULL', 'SELECT "Column data already exists or table missing" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Update existing records with NULL values
SET @sql = IF(@table_exists > 0, 
    'UPDATE notifications SET type = "info" WHERE type IS NULL',
    'SELECT "Skipping NULL updates - table does not exist" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @sql = IF(@table_exists > 0, 
    'UPDATE notifications SET is_read = 0 WHERE is_read IS NULL',
    'SELECT "Skipping NULL updates - table does not exist" as message');
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Verify the fix
SELECT 'Notifications table structure verification:' as message;
SELECT 
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    EXTRA
FROM information_schema.columns 
WHERE table_schema = DATABASE() 
AND table_name = 'notifications'
ORDER BY ORDINAL_POSITION;