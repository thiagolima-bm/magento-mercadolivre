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

class Acaldeira_Mercadolivre_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
	public function __construct() 
	{
        parent::__construct();
        $this->setId('orderGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection() 
    {
    	$collection = Mage::getModel('mercadolivre/order')->getCollection();
		
		$this->setCollection($collection);
        
        parent::_prepareCollection();
        
        return $this;

    }

    protected function _prepareColumns() 
    {
        $this->addColumn('ml_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'ml_id',
                'actions'   => array(
                array(
                    'caption'   => __('Edit'),
                    'url'       => array('base'=> '*/*/view'),
                    'field'     => 'ml_id'
                )
            ),
        ));

        $this->addColumn('created_at',
            array(
                'header'=> Mage::helper('catalog')->__('Date Created'),
                'index' => 'created_at',
        ));

        $this->addColumn('payment_status',
            array(
                'header'=> Mage::helper('catalog')->__('Payment Status'),
                'index' => 'payment_status',
        ));

        $this->addColumn('shipping_status',
            array(
                'header'=> Mage::helper('catalog')->__('Shipping Status'),
                'index' => 'shipping_status',
        ));


        return parent::_prepareColumns();
    }

     protected function _addColumnFilterToCollection($column) {

        if ($this->getCollection()) {

            if ($column->getId() == 'buyer_name') {
                $this->getCollection()->setOrder('buyer_name', $direction = self::SORT_ORDER_DESC);
            }
        }
    }
    
    public function getGridUrl() 
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/view', array('id' => $row->getMlId()));
    }
}
    

