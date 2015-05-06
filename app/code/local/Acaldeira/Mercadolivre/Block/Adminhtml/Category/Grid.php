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

class Acaldeira_Mercadolivre_Block_Adminhtml_Category_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
	public function __construct() 
	{
        parent::__construct();
        $this->setId('categoryGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection() 
    {
    	$collection = Mage::getModel('mercadolivre/category')->getCollection();
        $collection->getSelect()->join( 
            array('category'=>'catalog_category_entity_varchar'), 
            'category_id = category.entity_id', 
            array('category.value'));

        $collection->addFieldToFilter('category.attribute_id','41'); // hummm ;[]
        $collection->addFieldToFilter('category.store_id',Mage::app()->getStore()->getId());

                       
		
		$this->setCollection($collection);
        
        parent::_prepareCollection();
        
        // $this->getCollection()->addWebsiteNamesToResult();
        
        return $this;

    }

    protected function _prepareColumns() 
    {
        $this->addColumn('entity_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('catalog')->__('Category'),
                'index' => 'value',
        ));

        $this->addColumn('mlcat_id',
            array(
                'header'=> Mage::helper('catalog')->__('ML Category'),
                'index' => 'mlcat_id',
        ));

       
        

        return parent::_prepareColumns();
    }

    // protected function _addColumnFilterToCollection($column) {

    //     if ($this->getCollection()) {

    //         if ($column->getId() == 'buyer_name') {
    //             $this->getCollection()->setOrder('buyer_name', $direction = self::SORT_ORDER_DESC);
    //         }
    //     }
    // }
    
    public function getGridUrl() 
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    // public function getRowUrl($row)
    // {
    //     return $this->getUrl('*/*/view', array('id' => $row->getId()));
    // }


    protected function _prepareMassaction() 
    {
        
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('category');

        $this->getMassactionBlock()->addItem('publish', array(
            'label'=> Mage::helper('mercadolivre')->__('Delete'),
            'url'  => $this->getUrl('*/*/massDelete', array('_current'=>true)),
            ));
    }
}
    

