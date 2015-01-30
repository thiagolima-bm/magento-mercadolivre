<?php

class Acaldeira_Mercadolivre_Model_Mysql4_Notification extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/notification','entity_id');
    }
}