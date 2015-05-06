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

class Acaldeira_Mercadolivre_Block_Adminhtml_Status extends Mage_Adminhtml_Block_Template {


	public $meli;

	public function isLogged()
	{
		return Acaldeira_Mercadolivre_Helper_Data::isLogged();

	}

	public function getLoginUrl()
	{
		$uri = Mage::helper('adminhtml')->getUrl('mercadolivre/adminhtml_mercadolivre/*');
		return Acaldeira_Mercadolivre_Helper_Data::getLoginUrl($uri);
	}

	public function getMeli()
	{
		return Acaldeira_Mercadolivre_Helper_Data::getMeli();
	}

    public function getSession()
    {
        return Acaldeira_Mercadolivre_Helper_Data::getSession();
    }


}
