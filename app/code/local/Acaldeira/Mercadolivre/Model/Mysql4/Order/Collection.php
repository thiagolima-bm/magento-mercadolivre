<?php

class Acaldeira_Mercadolivre_Model_Mysql4_Order_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/order');
    }

    public function getVarienCollection()
    {
    	$collection = new Varien_Data_Collection();
    	foreach ($this as $order) {
    		
    		$v = json_decode($order->getContent());
			// var_dump($v);
			$order->setData('total_amount',$v->total_amount);
			$order->setData('buyer_name',$v->buyer->first_name);
			$order->setData('date_created',$v->date_created);
			$collection->addItem($order);
			
    	}

    	return $collection;
    }


}