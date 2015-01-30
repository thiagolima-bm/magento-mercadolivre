<?php

class Acaldeira_Mercadolivre_Model_System_Config_Source_Sites extends Mage_Core_Model_Config_Data {

    public static function toOptionArray() {
        return array(

            array('value' => 'MLA', 
                  'label' => 'Argentina'),
	        array('value' => 'MLB', 
                  'label' => 'Brasil'),
	        array('value' => 'MCO', 
	              'label' => 'Colombia'),
			array('value' => 'MCR', 
		    	  'label' => 'Costa Rica'),
            array('value' => 'MEC', 
                  'label' => 'Ecuador'),
			array('value' => 'MLM', 
            	  'label' => 'Mexico'),
			array('value' => 'MLU', 
            	  'label' => 'Uruguay'),
            array('value' => 'MLV', 
                  'label' => 'Venezuela'),
            array('value' => 'MPA', 
                  'label' => 'Panamá'),
            array('value' => 'MPE', 
                  'label' => 'Perú'),
            array('value' => 'MPT', 
                  'label' => 'Portugal'),
            array('value' => 'MRD', 
                  'label' => 'Dominicana'),
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