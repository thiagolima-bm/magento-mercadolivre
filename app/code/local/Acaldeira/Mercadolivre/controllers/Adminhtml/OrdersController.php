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

class Acaldeira_Mercadolivre_Adminhtml_OrdersController extends Acaldeira_Mercadolivre_Controller_Abstract
{

	
    public function indexAction() 
    {
        $this->_initAction();
        // $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_order'));
        $this->renderLayout();
    
    }

    public function viewAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Product grid for AJAX request
     */
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mercadolivre/adminhtml_order_grid')->toHtml()
        );
    }
}