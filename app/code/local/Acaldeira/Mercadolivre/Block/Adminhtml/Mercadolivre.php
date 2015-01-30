<?php

class Acaldeira_Mercadolivre_Block_Adminhtml_Mercadolivre  extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
    {
        $this->_controller = 'adminhtml_mercadolivre';
        $this->_blockGroup = 'mercadolivre';
        $this->_headerText = Mage::helper('mercadolivre')->__('Mercado Livre Manager');
       
        parent::__construct();
    }
}