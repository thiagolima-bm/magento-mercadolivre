<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("

ALTER TABLE  `ml_notification` ADD  `ml_id` VARCHAR( 12 ) NOT NULL;

ALTER TABLE  `ml_order` ADD  `payment_status` VARCHAR( 20 ) NOT NULL DEFAULT 'not_paid';

ALTER TABLE  `ml_order` ADD  `shipping_status` VARCHAR( 20 ) NOT NULL DEFAULT 'not_delivered';

ALTER TABLE  `ml_notification` ADD  `cron` TINYINT( 1 ) NOT NULL DEFAULT  '0';
 
");
 
$installer->endSetup();

