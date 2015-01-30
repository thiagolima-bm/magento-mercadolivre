<?php

require_once(Mage::getBaseDir('lib') . '/MercadoLivre/meli.php');

class Acaldeira_Mercadolivre_Model_Mercadolivre extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('mercadolivre/mercadolivre');
    }
}