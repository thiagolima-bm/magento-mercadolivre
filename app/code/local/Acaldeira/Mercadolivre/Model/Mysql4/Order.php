<?php

class Acaldeira_Mercadolivre_Model_Mysql4_Order extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/order','entity_id');
    }
}