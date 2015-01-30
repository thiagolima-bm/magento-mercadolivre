<?php

require_once 'app/Mage.php';

Mage::app();

$inputJSON = file_get_contents('php://input');

if($inputJSON){

	$notification = Mage::getModel('mercadolivre/notification');

	$notification->setNotification($inputJSON);

	$input = json_decode( $inputJSON, TRUE ); //convert JSON into array

	$id = explode("/", $input['resource']);

	$notification->setMlId($id[2]);

	$notification->save();

	
	// Mage::log($input);

	switch ($input['topic']) {
		case 'orders':
			$order = Mage::getModel('mercadolivre/order')->load($id[2],'ml_id');

			if (!$order->getId()) {

				$order->setMlId($id[2]);
				$order->setContent($inputJSON);
				$order->save();
			
			}else{

				

			}
			
			break;
		
		case 'items':
			// Mage::dispatchEvent('mercadolivre_items_notification', $notification);
			break;

		case 'questions':
			Mage::dispatchEvent('mercadolivre_questions_notification', $input);
			break;
		
		default:
			# code...
			break;
	}

}

echo "ok";