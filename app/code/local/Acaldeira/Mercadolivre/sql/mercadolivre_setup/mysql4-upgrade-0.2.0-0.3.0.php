<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
		

CREATE TABLE IF NOT EXISTS `ml_order` (
  `entity_id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `ml_id` int(11)  UNIQUE NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
  )
 
");
 
$installer->endSetup();

