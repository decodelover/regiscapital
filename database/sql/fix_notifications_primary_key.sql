-- Fix notifications table PRIMARY KEY and AUTO_INCREMENT issue
-- This script handles the case where the table exists but lacks PRIMARY KEY

-- Check if PRIMARY KEY exists and add it if missing
SET @pk_exists = (
    SELECT COUNT(*)
    FROM information_schema.table_constraints 
    WHERE table_schema = DATABASE() 
    AND table_name = 'notifications' 
    AND constraint_type = 'PRIMARY KEY'
);

-- Add PRIMARY KEY if it doesn't exist
SET @sql = IF(@pk_exists = 0, 
    'ALTER TABLE notifications ADD PRIMARY KEY (id)',
    'SELECT "PRIMARY KEY already exists" as message'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Ensure AUTO_INCREMENT is set
ALTER TABLE notifications MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Verify the fix
SELECT 'Checking notifications table structure:' as message;
SHOW CREATE TABLE notifications;

-- Test insert to verify it works
SELECT 'Testing notification creation...' as message;
INSERT INTO notifications (user_id, type, message, is_read, created_at, updated_at) 
VALUES (1, 'test', 'Test notification for verification', 0, NOW(), NOW());

-- Get the inserted ID to confirm AUTO_INCREMENT works
SELECT 'Last inserted ID:' as message, LAST_INSERT_ID() as last_id;

-- Clean up test record
DELETE FROM notifications WHERE type = 'test' AND message = 'Test notification for verification';

SELECT 'Notifications table is now ready for use!' as status;