<?php
declare(strict_types=1);


use Phinx\Migration\AbstractMigration;


final class InitialTablesMigration extends AbstractMigration
{
    public function up(): void
    {
        $this->query('DROP TABLE IF EXISTS `adresses`;');
        $this->query('CREATE TABLE `adresses` (
  `ad_id` int(11) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ad_first_name` varchar(1024) COLLATE \'utf8mb4_general_ci\' NOT NULL,
  `ad_last_name` varchar(1024) COLLATE \'utf8mb4_general_ci\' NOT NULL,
  `ad_phone` varchar(50) COLLATE \'utf8mb4_general_ci\' NOT NULL,
  `ad_email` varchar(1024) COLLATE \'utf8mb4_general_ci\' NOT NULL,
  `ad_note` text COLLATE \'utf8mb4_general_ci\' NOT NULL,
  `ad_deleted` datetime NULL
) COMMENT=\'address book table\' COLLATE \'utf8mb4_general_ci\';');
        $this->query('ALTER TABLE `adresses`
ADD INDEX `ad_last_name_ad_first_name` (`ad_last_name`(120), `ad_first_name`(120)),
ADD INDEX `ad_phone` (`ad_phone`),
ADD INDEX `ad_email` (`ad_email`(512)),
ADD INDEX `ad_deleted` (`ad_deleted`);');
    }

    public function down(): void
    {
        $this->query('DROP TABLE IF EXISTS `adresses`;');
    }
}
