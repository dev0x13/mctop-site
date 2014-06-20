ALTER TABLE `bank_transactions`
ADD COLUMN `id_in_system`  int UNSIGNED NOT NULL AFTER `time`,
ADD COLUMN `system`  tinyint(4) UNSIGNED NOT NULL AFTER `id_in_system`;

