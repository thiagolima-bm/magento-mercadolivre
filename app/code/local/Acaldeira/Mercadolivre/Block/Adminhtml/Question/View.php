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

class Acaldeira_Mercadolivre_Block_Adminhtml_Question_View extends Mage_Adminhtml_Block_Widget_Grid 
{
	public function getQuestion()
	{
		$id = $this->getRequest()->getParam('id');

		if($id){
			return Acaldeira_Mercadolivre_Helper_QuestionData::getQuestion(null,$id);
			
		}
	}
}