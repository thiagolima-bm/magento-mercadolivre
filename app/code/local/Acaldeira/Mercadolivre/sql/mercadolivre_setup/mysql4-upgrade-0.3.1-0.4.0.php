<?php
/**
 * Acaldeira Mercadolivre 
 * 
 * @category     Acaldeira
 * @package      Acaldeira_Mercadolivre 
 * @copyright    Copyright (c) 2015 MM (http://blog.meumagento.com.br/)
 * @author       MM (Thiago Caldeira de Lima)  
 * @version      Release: 0.1.0 
 */
 
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

