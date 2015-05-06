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
		

CREATE TABLE IF NOT EXISTS `ml_product` (
  `entity_id` int(11) AUTO_INCREMENT PRIMARY KEY,
  `product_id` int(11) NOT NULL,
  `price` decimal(12,4) NOT NULL,
  `ml_id` varchar(20) NOT NULL,
  `type` varchar(20) NOT NULL,
  `published` varchar(20) NOT NULL

  )
 
    ");
 
$installer->endSetup();

