CREATE TABLE IF NOT EXISTS `admins` (
  `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstName` VARCHAR(255) NOT NULL,
  `lastName` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `password` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(255) DEFAULT NULL,
  `dashboard_style` VARCHAR(255) NOT NULL DEFAULT 'dark',
  `remember_token` VARCHAR(255) DEFAULT NULL,
  `password_token` VARCHAR(100) DEFAULT NULL,
  `acnt_type_active` VARCHAR(255) DEFAULT 'active',
  `status` VARCHAR(255) DEFAULT 'active',
  `type` VARCHAR(255) DEFAULT NULL,

  `enable_2fa` VARCHAR(255) NOT NULL DEFAULT 'disabled',
  `token_2fa` VARCHAR(255) DEFAULT NULL,
  `pass_2fa` VARCHAR(255) DEFAULT NULL,
  `token_2fa_expiry` DATETIME DEFAULT NULL,

  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `admins_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;