<?php

require_once(Mage::getBaseDir('lib') . '/MercadoLivre/meli.php');

class Acaldeira_Mercadolivre_Model_Observer
{
	public function captureOrder(Varien_Event_Observer $event)
    {
    	Mage::log('captureOrder');
        
        $order = Acaldeira_Mercadolivre_Helper_OrderData::getOrder($event->getResource());

        Mage::log($order);

        Acaldeira_Mercadolivre_Helper_OrderData::saveOrder($order);

    }

    public function captureQuestion(Varien_Event_Observer $event)
    {
    	Mage::log(get_class($this));
    	Mage::log($event);

    }

    public static function updateSession()
    {
        
    }
       
}