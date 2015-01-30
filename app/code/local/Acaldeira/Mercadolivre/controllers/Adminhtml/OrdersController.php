<?php


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