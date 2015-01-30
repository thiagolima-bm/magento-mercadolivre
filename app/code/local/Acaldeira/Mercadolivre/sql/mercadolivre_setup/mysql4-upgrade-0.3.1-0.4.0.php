<?php
 
$installer = $this;
 
$installer->startSetup();
 
$installer->run("
		

CREATE TABLE IF NOT EXISTS `ml_category` (
  `entity_id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `category_id` int(11) not null,
  `mlcat_id` varchar(20) not null
  )
 
");
 
$installer->endSetup();

