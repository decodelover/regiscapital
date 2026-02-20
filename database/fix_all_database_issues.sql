-- Comprehensive Database Fix Script
-- Execute these statements in order to resolve all identified issues

-- 1. Fix AUTO_INCREMENT for kycs table
ALTER TABLE kycs MODIFY id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 2. Fix AUTO_INCREMENT for crypto_accounts table (if needed)
ALTER TABLE crypto_accounts MODIFY id int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

-- 3. Add missing columns to kycs table (check if they exist first)
-- Run DESCRIBE kycs; first to see which columns exist

-- Add statenumber column if missing
ALTER TABLE kycs ADD COLUMN statenumber VARCHAR(50) NULL;

-- Add accounttype column if missing  
ALTER TABLE kycs ADD COLUMN accounttype VARCHAR(50) NULL;

-- Add employer column if missing
ALTER TABLE kycs ADD COLUMN employer VARCHAR(50) NULL;

-- Add income column if missing
ALTER TABLE kycs ADD COLUMN income VARCHAR(100) NULL;

-- Add kinname column if missing
ALTER TABLE kycs ADD COLUMN kinname VARCHAR(150) NULL;

-- Add kinaddress column if missing
ALTER TABLE kycs ADD COLUMN kinaddress VARCHAR(255) NULL;

-- Add relationship column if missing
ALTER TABLE kycs ADD COLUMN relationship VARCHAR(100) NULL;

-- Add age column if missing
ALTER TABLE kycs ADD COLUMN age INT(20) NULL;

-- Add title column if missing
ALTER TABLE kycs ADD COLUMN title VARCHAR(225) NULL;

-- 4. Fix NULL values in critical fields
UPDATE kycs SET status = 'Under review' WHERE status IS NULL OR status = '';

-- 5. Fix crypto_accounts default values (if needed)
UPDATE crypto_accounts SET btc = 0 WHERE btc IS NULL;
UPDATE crypto_accounts SET eth = 0 WHERE eth IS NULL;
UPDATE crypto_accounts SET ltc = 0 WHERE ltc IS NULL;
UPDATE crypto_accounts SET xrp = 0 WHERE xrp IS NULL;
UPDATE crypto_accounts SET link = 0 WHERE link IS NULL;
UPDATE crypto_accounts SET aave = 0 WHERE aave IS NULL;
UPDATE crypto_accounts SET usdt = 0 WHERE usdt IS NULL;
UPDATE crypto_accounts SET xlm = 0 WHERE xlm IS NULL;
UPDATE crypto_accounts SET bch = 0 WHERE bch IS NULL;

-- 6. Verify the fixes
-- Run these queries to verify the fixes worked:

-- Check AUTO_INCREMENT status
SHOW CREATE TABLE kycs;
SHOW CREATE TABLE crypto_accounts;

-- Check for NULL values
SELECT COUNT(*) as null_status_count FROM kycs WHERE status IS NULL;
SELECT COUNT(*) as null_crypto_balances FROM crypto_accounts WHERE btc IS NULL;

-- Check table structure
DESCRIBE kycs;
DESCRIBE crypto_accounts;