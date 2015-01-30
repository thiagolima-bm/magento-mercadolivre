<?php

class Acaldeira_Mercadolivre_Model_System_Config_Source_Type extends Mage_Core_Model_Config_Data {

    public static function toOptionArray() {
        return array(

            array('value' => 'free', 
                  'label' => 'Gratuito'),
	        array('value' => 'bronze', 
                  'label' => 'Bronze'),
	        array('value' => 'silver', 
	              'label' => 'Prata'),
			array('value' => 'gold', 
		    	  'label' => 'Ouro'),
			array('value' => 'gold_special', 
            	  'label' => 'Ouro Para Grandes Vendedores'),
			array('value' => 'gold_premium', 
            	  'label' => 'Ouro Premium'),
        );
    }
    
    public function toSelectArray() {
        $select = array();
        foreach(self::toOptionArray() as $option) {
            $select[$option['value']] = $option['label'];
        }
        return $select;
    }


    public static function optSelectArray() {
        $select = array();
        foreach(self::toOptionArray() as $option) {
            $select[$option['value']] = $option['label'];
        }
        return $select;
    }
}