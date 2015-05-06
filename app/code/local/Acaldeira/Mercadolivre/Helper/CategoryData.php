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

class Acaldeira_Mercadolivre_Helper_CategoryData extends Acaldeira_Mercadolivre_Helper_Data
{

	public static function getSiteCategories() 
	{
		$siteId = Mage::getStoreConfig('mercadolivre/products/site',Mage::app()->getStore());

		$meli = self::getMeli();

		return $meli->get('/sites/'.$siteId.'/categories');
	}

	public static function getMlCategoryInfo($catId)
	{
		$meli = self::getMeli();

		return $meli->get('/categories/'.$catId);

	}

}