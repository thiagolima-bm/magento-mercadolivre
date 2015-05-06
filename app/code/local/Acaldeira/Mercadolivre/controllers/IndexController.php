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

class Acaldeira_Mercadolivre_IndexController extends Mage_Core_Controller_Front_Action
{
	public function indexAction()
	{

		$inputJSON = file_get_contents('php://input');

		if($inputJSON){

			$notification = Mage::getModel('mercadolivre/notification');

			$notification->setNotification($inputJSON);

			$input = json_decode( $inputJSON, TRUE ); //convert JSON into array

			$id = explode("/", $input['resource']);

			$notification->setMlId($id[2]);

			$notification->save();

			switch ($input['topic']) {
				case 'orders':
					$order = Mage::getModel('mercadolivre/order')->load($id[2],'ml_id');

					if (!$order->getId()) {

						$order->setMlId($id[2]);
						$order->setContent($inputJSON);
						$order->save();
					
					}
					break;
				
				case 'items':
					// Mage::dispatchEvent('mercadolivre_items_notification', $notification);
					break;

				case 'questions':
					$question = Mage::getModel('mercadolivre/question')->load($id[2],'ml_id');
					
					if(!$question->getId()){
						$question->setMlId($id[2]);
						$question->setResource($input['resource']);
						$question->save();
					}
					
					break;
				
				default:
					# code...
					break;
			}

		}
		
	}
}