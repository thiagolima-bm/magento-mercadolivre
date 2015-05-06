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

class Acaldeira_Mercadolivre_Block_Adminhtml_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    

    public $options;

    public function __construct() {
        parent::__construct();
        $this->setId('productGrid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        // $this->setUseAjax(true);
        $this->setVarNameFilter('product_filter');

        $this->options = array(
                         'active' => Mage::helper('mercadolivre')->__('Active'),
                         'paused' => Mage::helper('mercadolivre')->__('Paused'),
                         'closed' => Mage::helper('mercadolivre')->__('Closed')
                         );
    }

    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }

    protected function _prepareCollection() {
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
                      ->addAttributeToSelect('sku')
                      ->addAttributeToSelect('name')
                      // ->addAttributeToSelect('lengow_product')
                      ->addAttributeToSelect('attribute_set_id')
                      ->addAttributeToSelect('type_id')
                      ->joinField('qty',
                          'cataloginventory/stock_item',
                          'qty',
                          'product_id=entity_id',
                          '{{table}}.stock_id=1',
                          'left');

        if ($store->getId()) {
            $collection->setStoreId($store->getId());
            $collection->addStoreFilter($store);
            $collection->joinAttribute('custom_name', 'catalog_product/name', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner', $store->getId());
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        } else {
            $collection->addAttributeToSelect('price');
            $collection->addAttributeToSelect('status');
            $collection->addAttributeToSelect('visibility');
        }

        $collection->joinTable(
            array('mercadolivre' => 'mercadolivre/product'), 'product_id=entity_id',
            array('ml_id','published','type'),null,'left'
        );

        $this->setCollection($collection);
        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    protected function _addColumnFilterToCollection($column) {
        if ($this->getCollection()) {

            if ($column->getId() == 'websites') {
                $this->getCollection()->joinField('websites',
                    'catalog/product_website',
                    'website_id',
                    'product_id=entity_id',
                    null,
                    'left');
            }

            if ($column->getId() == 'ml_published') {
                $this->getCollection()->joinField('published',
                    'mercadolivre/product',
                    'published',
                    'product_id=entity_id',
                    null,
                    'left');               
            }

            if ($column->getId() == 'ml_type') {
                $this->getCollection()->joinField('type',
                    'mercadolivre/product',
                    'type',
                    'product_id=entity_id',
                    null,
                    'left');               
            }


        }
        return parent::_addColumnFilterToCollection($column);
    }

    protected function _prepareColumns() {
        $this->addColumn('entity_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
        ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('catalog')->__('Name'),
                'index' => 'name',
        ));
        $store = $this->_getStore();
        if ($store->getId()) {
            $this->addColumn('custom_name',
                array(
                    'header'=> Mage::helper('catalog')->__('Name In %s', $store->getName()),
                    'index' => 'custom_name',
            ));
        }
        $this->addColumn('type',
            array(
                'header'=> Mage::helper('catalog')->__('Type'),
                'width' => '60px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));
        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();
        $this->addColumn('set_name',
            array(
                'header'=> Mage::helper('catalog')->__('Attrib. Set Name'),
                'width' => '100px',
                'index' => 'attribute_set_id',
                'type'  => 'options',
                'options' => $sets,
        ));
        $this->addColumn('sku',
            array(
                'header'=> Mage::helper('catalog')->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
        ));
        $store = $this->_getStore();
        $this->addColumn('price',
            array(
                'header'=> Mage::helper('catalog')->__('Price'),
                'width' => '100px',
                'type'  => 'number',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
        ));
        $this->addColumn('qty',
            array(
                'header'=> Mage::helper('catalog')->__('Qty'),
                'width' => '100px',
                'type'  => 'number',
                'index' => 'qty',
        ));
        $this->addColumn('visibility',
            array(
                'header'=> Mage::helper('catalog')->__('Visibility'),
                'width' => '70px',
                'index' => 'visibility',
                'type'  => 'options',
                'options' => Mage::getModel('catalog/product_visibility')->getOptionArray(),
        ));
        $this->addColumn('status',
            array(
                'header'=> Mage::helper('catalog')->__('Status'),
                'width' => '70px',
                'index' => 'status',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        
        $this->addColumn('ml_published',
            array(
                'header'=> Mage::helper('mercadolivre')->__('Published on ML'),
                'width' => '70px',
                'index' => 'published',
                'type'  => 'options',
                'options' => $this->options,
        ));

        $this->addColumn('ml_type',
            array(
                'header'=> Mage::helper('mercadolivre')->__('ML Type'),
                'width' => '70px',
                'index' => 'type',
                'type'  => 'options',
                'options' => Acaldeira_Mercadolivre_Model_System_Config_Source_Type::optSelectArray(),
        ));

        
        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('websites',
                array(
                    'header'=> Mage::helper('catalog')->__('Websites'),
                    'width' => '100px',
                    'sortable'  => false,
                    'index'     => 'websites',
                    'type'      => 'options',
                    'options'   => Mage::getModel('core/website')->getCollection()->toOptionHash(),
            ));
        }

        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction() {
        
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');

        

        $this->getMassactionBlock()->addItem('uploadPictures', array(
             'label'    => Mage::helper('customer')->__('Upload Pictures'),
             'url'      => $this->getUrl('*/*/massUploadPictures'),
             // 'confirm'  => Mage::helper('customer')->__('Are you sure?')
        ));


        $this->getMassactionBlock()->addItem('publish', array(
             'label'=> Mage::helper('mercadolivre')->__('Change Mercadolivre publication'),
             'url'  => $this->getUrl('*/*/massPublish', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'publish',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('mercadolivre')->__('Publication'),
                         'values' => $this->options
                     ),

                    '_type' => array(
                         'name' => '_type',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('mercadolivre')->__('Type'),
                         'values' => Acaldeira_Mercadolivre_Model_System_Config_Source_Type::optSelectArray()
                     ),
             )
        ));

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customer')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customer')->__('Are you sure?')
        ));


        return $this;
    }

    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row) {
        return '';
    }
}
