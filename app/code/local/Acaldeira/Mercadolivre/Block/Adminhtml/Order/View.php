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