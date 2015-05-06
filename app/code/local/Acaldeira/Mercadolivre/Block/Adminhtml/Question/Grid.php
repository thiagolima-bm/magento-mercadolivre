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

class Acaldeira_Mercadolivre_Block_Adminhtml_Question_Grid extends Mage_Adminhtml_Block_Widget_Grid 
{
	public function __construct() 
	{
        parent::__construct();
        $this->setId('questionGrid');
        $this->setDefaultSort('id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
    
    protected function _prepareCollection() 
    {
    	$collection = Mage::getModel('mercadolivre/question')->getCollection();
		
        $collection->addFieldToFilter('status',array('null'=>true));

		$this->setCollection($collection);
        
        parent::_prepareCollection();
        
        return $this;

    }

    protected function _prepareColumns() 
    {
        $this->addColumn('ml_id',
            array(
                'header'=> Mage::helper('mercadolivre')->__('Question ID'),               
                'index' => 'ml_id'
                ));

        $this->addColumn('created_at',
            array(
                'header'=> Mage::helper('mercadolivre')->__('Date Created'),
                'index' => 'created_at',
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
    

