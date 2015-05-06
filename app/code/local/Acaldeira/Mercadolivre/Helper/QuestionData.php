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

class Acaldeira_Mercadolivre_Helper_QuestionData extends Acaldeira_Mercadolivre_Helper_Data
{


	public static function getQuestion($uri = null,$questionId = null)
	{
		$session = self::getSession();
		
		$params = array('access_token' => $session['access_token']);
		
		$meli = self::getMeli();

		if(!$uri)
			$uri = '/questions/'.$questionId;
        

        return $meli->get($uri, $params);

	}

	public static function saveAnswer($answer)
	{
		$session = self::getSession();

        if(isset($session['access_token']))
            $meli = self::getMeli();
		
		$params = array('access_token' => $session['access_token']);

		return $meli->post("/answers", $answer, $params);

	}

}