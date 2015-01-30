<?php

class Acaldeira_Mercadolivre_Model_Mysql4_Question_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        $this->_init('mercadolivre/question');
    }


    public function addFieldToFilter($field, $condition=null)
	{
	    $field = $this->_getMappedField($field);
	    $this->_select->where($this->_getConditionSql($field, $condition), null, Varien_Db_Select::TYPE_CONDITION);
	    return $this;
	}

}