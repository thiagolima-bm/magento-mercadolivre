<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
		

CREATE TABLE IF NOT EXISTS `ml_notification` (
  `entity_id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `notification` varchar(600) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  )
 
    ");
 
$installer->endSetup();

