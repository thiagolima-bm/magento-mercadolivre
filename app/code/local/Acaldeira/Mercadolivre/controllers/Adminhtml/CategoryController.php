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

class Acaldeira_Mercadolivre_Adminhtml_CategoryController extends Acaldeira_Mercadolivre_Controller_Abstract
{


    public function indexAction() 
    {
        $this->_initAction();
        // $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_order'));
        $this->renderLayout();
    
    }
	

	public function categoriesAction() 
    {
        $this->_initAction();
        // $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_order'));
        $this->renderLayout();
    
    }

    public function getChildCategoriesAction()
    {
        if (!$this->getRequest()->isAjax()) {
            return;
        }
        
        $result = array();
        
        $postData = $this->getRequest()->getPost();
        $catId = $postData['catId'];
        
        $categories = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('parent_id',array('eq'=>$catId))
        ->addIsActiveFilter();
        
        foreach($categories as $category)
            $result['categories'][] = array('category_id'=>$category->getId(),'name'=>$category->getName());

        
        //return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'text/xml')->setBody(json_encode($result));
    }

    public function getMlChildCategoriesAction()
    {
        if (!$this->getRequest()->isAjax()) {
            return;
        }
        
        $result = array();
        
        $postData = $this->getRequest()->getPost();
        $catId = $postData['catId'];
        
        $category = Acaldeira_Mercadolivre_Helper_CategoryData::getMlCategoryInfo($catId);

        $category = $category['body'];

        if($category->children_categories){
            foreach($category->children_categories as $category)
            $result['categories'][] = array('category_id'=>$category->id,'name'=>$category->name);

        }
        
        //return $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
        $this->getResponse()->clearHeaders()->setHeader('Content-Type', 'text/xml')->setBody(json_encode($result));

    }

    public function saveAction() 
    {
        if ( $this->getRequest()->getPost() ) {

             
            try {

                $postData = $this->getRequest()->getPost();

                $mageCat = $postData['category'][sizeof($postData['category'])-1];
                $mlCat = $postData['category_ml'][sizeof($postData['category_ml'])-1];
                $category = Mage::getModel('mercadolivre/category')->load($mageCat,'category_id');

                if($category->getId()){
                    $category->setCategoryId($mageCat);
                    $category->setMlcatId($mlCat);
                }else{
                    $category = Mage::getModel('mercadolivre/category');
                    $category->setCategoryId($mageCat);
                    $category->setMlcatId($mlCat);
                }
                $category->save();

                

            }catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/index', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        $this->_redirect('*/*/');
    
    }

    /**
    * Category grid for AJAX request
    */
    public function gridAction() 
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mercadolivre/adminhtml_category_grid')->toHtml()
        );
    }


    public function massDeleteAction()
    {
        $_category_ids = (array) $this->getRequest()->getParam('category');

        try{

            foreach($_category_ids as $cid){

                Mage::getModel('mercadolivre/category')->load($cid)->delete();

            }
        
        }catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/index');
                return;
        }
        Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('mercadolivre')->__('Deleted sucessfully'));
        $this->_redirect('*/*/index');
    } 

}