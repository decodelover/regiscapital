-- Database Health Check Script
-- Run these queries to verify database integrity

-- 1. Check AUTO_INCREMENT status for critical tables
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    IS_NULLABLE,
    COLUMN_DEFAULT,
    EXTRA
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME IN ('kycs', 'crypto_accounts', 'users') 
    AND COLUMN_NAME = 'id';

-- 2. Check for NULL values in critical fields
SELECT 'kycs_null_status' as check_name, COUNT(*) as count FROM kycs WHERE status IS NULL
UNION ALL
SELECT 'kycs_empty_status' as check_name, COUNT(*) as count FROM kycs WHERE status = ''
UNION ALL
SELECT 'crypto_accounts_null_btc' as check_name, COUNT(*) as count FROM crypto_accounts WHERE btc IS NULL
UNION ALL
SELECT 'crypto_accounts_null_eth' as check_name, COUNT(*) as count FROM crypto_accounts WHERE eth IS NULL;

-- 3. Check table structure for required columns
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    DATA_TYPE,
    IS_NULLABLE,
    COLUMN_DEFAULT
FROM INFORMATION_SCHEMA.COLUMNS 
WHERE TABLE_SCHEMA = DATABASE() 
    AND TABLE_NAME = 'kycs'
    AND COLUMN_NAME IN ('statenumber', 'accounttype', 'employer', 'income', 'kinname', 'kinaddress', 'relationship', 'title', 'age')
ORDER BY TABLE_NAME, ORDINAL_POSITION;

-- 4. Check for orphaned records
SELECT 'kycs_without_users' as check_name, COUNT(*) as count 
FROM kycs k 
LEFT JOIN users u ON k.user_id = u.id 
WHERE u.id IS NULL;

-- 5. Check recent KYC submissions for potential issues
SELECT 
    id,
    user_id,
    status,
    created_at,
    CASE 
        WHEN status IS NULL THEN 'NULL_STATUS'
        WHEN status = '' THEN 'EMPTY_STATUS'
        WHEN user_id IS NULL THEN 'NULL_USER_ID'
        ELSE 'OK'
    END as issue_type
FROM kycs 
WHERE created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)
ORDER BY created_at DESC
LIMIT 20;