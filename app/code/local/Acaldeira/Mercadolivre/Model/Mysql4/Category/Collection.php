<?php

class Acaldeira_Mercadolivre_Model_Mysql4_Category_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/category');
    }


    public function addFieldToFilter($field, $condition=null)
	{
	    $field = $this->_getMappedField($field);
	    $this->_select->where($this->_getConditionSql($field, $condition), null, Varien_Db_Select::TYPE_CONDITION);
	    return $this;
	}

	public function addAttributeToSelect($attributes = array())
    {
    	$select = $this->getSelect()
	       
	            ->columns($attributes);

	        return $this;
    }
}