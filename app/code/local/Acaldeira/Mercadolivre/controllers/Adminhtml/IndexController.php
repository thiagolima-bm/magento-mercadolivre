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

class Acaldeira_Mercadolivre_Adminhtml_IndexController extends Acaldeira_Mercadolivre_Adminhtml_Abstract
{
	protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('acaldeira/mercadolivre')
            ->_addBreadcrumb(Mage::helper('mercadolivre')->__('MercadoLivre Manager'), Mage::helper('mercadolivre')->__('MercadoLivre Manager'));
        return $this;
    }

	public function indexAction() {
        $this->_initAction();       
        $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_mercadolivre'));
        $this->renderLayout();
    }

    public function mercadolivreAction()
    {
       echo 'oi';
       exit;
    }
}