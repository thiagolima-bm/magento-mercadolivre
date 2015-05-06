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

class Acaldeira_Mercadolivre_Helper_OrderData extends Acaldeira_Mercadolivre_Helper_Data
{

	public static function getText()
	{
		return "Text";
	}


	public static function getOrder($uri = null,$orderId = null)
	{
		$session = self::getSession();
		
		$params = array('access_token' => $session['access_token']);
		
		$meli = self::getMeli();

		if(!$uri)
			$uri = '/orders/'.$orderId;
        

        return $meli->get($uri, $params);

	}

	public static function saveOrder($order)
	{

		
		Mage::log('saveOrder');
		
		$order = json_decode($order);

		Mage::log($order);

		$_order = Mage::getModel('mercadolivre/order');

		// $_order->setId()


	}

}