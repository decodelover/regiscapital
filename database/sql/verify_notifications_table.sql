-- Verify notifications table structure and data integrity
-- Run this script after applying the fix to ensure everything is working correctly

-- Check table structure
SELECT 'Notifications table structure:' as message;
DESCRIBE notifications;

-- Check AUTO_INCREMENT status
SELECT 'AUTO_INCREMENT status:' as message;
SELECT 
    table_name,
    auto_increment,
    table_comment
FROM information_schema.tables 
WHERE table_schema = DATABASE() 
AND table_name = 'notifications';

-- Check for NULL values that could cause issues
SELECT 'NULL value check:' as message;
SELECT 
    COUNT(*) as total_records,
    SUM(CASE WHEN id IS NULL THEN 1 ELSE 0 END) as null_ids,
    SUM(CASE WHEN type IS NULL THEN 1 ELSE 0 END) as null_types,
    SUM(CASE WHEN is_read IS NULL THEN 1 ELSE 0 END) as null_is_read,
    SUM(CASE WHEN user_id IS NULL THEN 1 ELSE 0 END) as null_user_ids
FROM notifications;

-- Test insert operation (this should work without errors)
SELECT 'Testing insert operation:' as message;
INSERT INTO notifications (user_id, type, title, message, is_read, created_at, updated_at) 
VALUES (1, 'test', 'Test Notification', 'This is a test notification', 0, NOW(), NOW());

-- Get the inserted record ID
SELECT 'Last inserted ID:' as message, LAST_INSERT_ID() as last_id;

-- Clean up test record
DELETE FROM notifications WHERE type = 'test' AND title = 'Test Notification';

SELECT 'Verification complete - notifications table is ready for use' as message;