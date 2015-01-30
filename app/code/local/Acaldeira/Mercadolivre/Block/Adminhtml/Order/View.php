<?php

class Acaldeira_Mercadolivre_Block_Adminhtml_Order_View extends Mage_Adminhtml_Block_Widget_Grid 
{
	public function getOrder()
	{
		$id = $this->getRequest()->getParam('id');

		if($id){
			return Acaldeira_Mercadolivre_Helper_OrderData::getOrder(null,$id);
			
		}
	}
}