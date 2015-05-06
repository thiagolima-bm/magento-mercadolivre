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

class Acaldeira_Mercadolivre_Adminhtml_MercadolivreController extends Acaldeira_Mercadolivre_Controller_Abstract
{

    public function preDispatch()
    { 
     if ($this->getRequest()->getActionName() == 'index') Mage::getSingleton('adminhtml/url')->turnOffSecretKey();
     parent::preDispatch();
    }
   

    public function indexAction() 
    {
        
        $this->_initAction();
        $this->renderLayout();
    
    }

    public function productsAction()
    {
        
        $this->_initAction();
        $this->renderLayout();
    }

    public function statusAction()
    {
        $this->loadLayout();
        
        Mage::getSingleton('adminhtml/url')->turnOffSecretKey();

        $code = $this->getRequest()->getParam('code');

        $uri = Mage::helper('adminhtml')->getUrl('mercadolivre/adminhtml_mercadolivre/*');

        if(isset($code))
            Acaldeira_Mercadolivre_Helper_Data::auth($code,$uri);

        $this->renderLayout();
    }


    public function massPublishAction() 
    {
        $this->_checkLogin();

        $_product_ids = (array) $this->getRequest()->getParam('product');

        $publish = $this->getRequest()->getParam('publish');

        $type = $this->getRequest()->getParam('_type');
        
        foreach($_product_ids as $pid){

            $_product = Mage::getModel('catalog/product')->load($pid);

            $mlProduct = Mage::getModel('mercadolivre/product')->load($pid,'product_id');
        
            $mlProduct->setType($type);

            $mlProduct->setPublished($publish);

            $mlProduct->setProductId($pid);

            $result = Acaldeira_Mercadolivre_Helper_Data::saveProduct($_product,$mlProduct);

            if(isset($result['body']->id)){

                $mlProduct->setMlId($result['body']->id);
            
                $mlProduct->setPrice($result['body']->price);
                
                $mlProduct->save();

            }else{

                Mage::getSingleton('adminhtml/session')->addError($result['body']->message);


                if($result['body']->cause){

                    foreach ($result['body']->cause as $error) 
                        if(is_object($error))
                            Mage::getSingleton('adminhtml/session')->addError($error->message);
                        else
                            Mage::getSingleton('adminhtml/session')->addError($error);

                
                }else{
                    
                    foreach ($result['body']->cause as $error) 
                        Mage::getSingleton('adminhtml/session')->addError($error);
                
                }
       
            }
                
                
                
            $this->_redirect('*/*/products');

        }

    }

    public function massUploadPicturesAction() 
    {
        $this->_checkLogin();

        $_product_ids = (array) $this->getRequest()->getParam('product');

        
        foreach($_product_ids as $pid){

            $_product = Mage::getModel('catalog/product')->load($pid);

            $mlProduct = Mage::getModel('mercadolivre/product')->load($pid,'product_id');
        
            $result = Acaldeira_Mercadolivre_Helper_Data::uploadPictures($_product,$mlProduct);


            if($result['body']->cause){

                foreach ($result['body']->cause as $error) 
                    if(is_object($error))
                        Mage::getSingleton('adminhtml/session')->addError($error->message);
                    else
                        Mage::getSingleton('adminhtml/session')->addError($error);

            
            }else{
                
                foreach ($result['body']->cause as $error) 
                    Mage::getSingleton('adminhtml/session')->addError($error);
            
            }
       
                        
            $this->_redirect('*/*/products');

        }

    }

    /**
     * Product grid for AJAX request
     */
    public function gridAction() {
         $this->_initAction();
        $this->renderLayout();
    }
}