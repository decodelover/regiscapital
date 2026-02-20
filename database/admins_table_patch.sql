-- Ensure primary key is auto-increment (run if id isn't auto-increment)
ALTER TABLE `admins`
  MODIFY `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT;

-- Add missing columns (each ADD COLUMN uses IF NOT EXISTS)
ALTER TABLE `admins`
  ADD COLUMN IF NOT EXISTS `firstName` VARCHAR(255) NOT NULL AFTER `id`,
  ADD COLUMN IF NOT EXISTS `lastName` VARCHAR(255) NOT NULL AFTER `firstName`,
  ADD COLUMN IF NOT EXISTS `email` VARCHAR(255) NOT NULL AFTER `lastName`,
  ADD COLUMN IF NOT EXISTS `email_verified_at` TIMESTAMP NULL DEFAULT NULL AFTER `email`,
  ADD COLUMN IF NOT EXISTS `password` VARCHAR(255) NOT NULL AFTER `email_verified_at`,
  ADD COLUMN IF NOT EXISTS `phone` VARCHAR(255) DEFAULT NULL AFTER `password`,
  ADD COLUMN IF NOT EXISTS `dashboard_style` VARCHAR(255) NOT NULL DEFAULT 'dark' AFTER `phone`,
  ADD COLUMN IF NOT EXISTS `remember_token` VARCHAR(255) DEFAULT NULL AFTER `dashboard_style`,
  ADD COLUMN IF NOT EXISTS `password_token` VARCHAR(100) DEFAULT NULL AFTER `remember_token`,
  ADD COLUMN IF NOT EXISTS `acnt_type_active` VARCHAR(255) DEFAULT 'active' AFTER `password_token`,
  ADD COLUMN IF NOT EXISTS `status` VARCHAR(255) DEFAULT 'active' AFTER `acnt_type_active`,
  ADD COLUMN IF NOT EXISTS `type` VARCHAR(255) DEFAULT NULL AFTER `status`,
  ADD COLUMN IF NOT EXISTS `enable_2fa` VARCHAR(255) NOT NULL DEFAULT 'disabled' AFTER `type`,
  ADD COLUMN IF NOT EXISTS `token_2fa` VARCHAR(255) DEFAULT NULL AFTER `enable_2fa`,
  ADD COLUMN IF NOT EXISTS `pass_2fa` VARCHAR(255) DEFAULT NULL AFTER `token_2fa`,
  ADD COLUMN IF NOT EXISTS `token_2fa_expiry` DATETIME DEFAULT NULL AFTER `pass_2fa`,
  ADD COLUMN IF NOT EXISTS `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `token_2fa_expiry`,
  ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_at`;

-- Add unique index on email (use CREATE INDEX IF NOT EXISTS if your MariaDB supports it)
ALTER TABLE `admins`
  ADD UNIQUE KEY `admins_email_unique` (`email`);