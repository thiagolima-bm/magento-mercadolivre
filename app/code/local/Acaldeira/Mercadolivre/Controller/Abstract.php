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

class Acaldeira_Mercadolivre_Controller_Abstract extends Mage_Adminhtml_Controller_Action
{
	protected function _checkLogin()
    {
        if(!Acaldeira_Mercadolivre_Helper_Data::isLogged()){
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('mercadolivre')->__('Login first'));
            $this->_redirect('*/adminhtml_mercadolivre/status');
        }
            
    } 
    protected function _initAction()
    {
        $this->_checkLogin();
        $this->loadLayout()
            ->_setActiveMenu('acaldeira/mercadolivre')
            ->_addBreadcrumb(Mage::helper('mercadolivre')->__('MercadoLivre Manager'), Mage::helper('mercadolivre')->__('MercadoLivre Manager'));
        return $this;
    }

}