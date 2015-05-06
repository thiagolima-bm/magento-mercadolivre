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

class Acaldeira_Mercadolivre_Block_Adminhtml_Category extends Mage_Adminhtml_Block_Widget_Container {

    /**
     * Set template
     */
      public function __construct() 
      {

         $this->addButton('add', array(
            'label'     => Mage::helper('mercadolivre')->__('Associate Category'),
            'onclick'   => 'setLocation(\'' . $this->getUrl('mercadolivre/adminhtml_category/categories') . '\')',
            'class'     => 'goback'
        ));


        parent::__construct();
      }

    /**
     * Prepare button and grid
     *
     * @return Mage_Adminhtml_Block_
     */
    protected function _prepareLayout() 
    {
       
        $this->setChild('grid', $this->getLayout()->createBlock('mercadolivre/adminhtml_category_grid', 'category.grid'));
        return parent::_prepareLayout();
    }
    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml() 
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode() 
    {
        if (!Mage::app()->isSingleStoreMode()) {
               return false;
        }
        return true;
    }
   
    public function getCategories()
    {
        
        
        $cat = Mage::getModel('catalog/category')->load(2);

        /*Returns comma separated ids*/
        $subcats = $cat->getChildren();

        $categories = Mage::getModel('catalog/category')
        ->getCollection()
        ->addAttributeToSelect('*')
        ->addAttributeToFilter('entity_id',array(
        'in' => explode(',',$subcats),
        ))
        ->addIsActiveFilter();

        return $categories;
    }

    public function getMLSiteCategories()
    {
         return (object) Acaldeira_Mercadolivre_Helper_CategoryData::getSiteCategories();
    }

}
