<?php

class Acaldeira_Mercadolivre_Model_Session extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mercadolivre/session');
    }


    public function getSession()
    {
    
	    $resource = Mage::getSingleton('core/resource');

	    $readConnection = $resource->getConnection('core_read');

	    $query = 'SELECT * FROM ml_session';

	    return $readConnection->fetchRow($query);

    }

    
}