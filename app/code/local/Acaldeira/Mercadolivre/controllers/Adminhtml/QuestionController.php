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

class Acaldeira_Mercadolivre_Adminhtml_QuestionController extends Acaldeira_Mercadolivre_Controller_Abstract
{

	
    public function indexAction() 
    {
        $this->_initAction();
        // $this->_addContent($this->getLayout()->createBlock('mercadolivre/adminhtml_order'));
        $this->renderLayout();
    
    }

    public function viewAction()
    {
        $this->_initAction();

        $this->renderLayout();
    }

    public function answerAction()
    {
        if ( $this->getRequest()->getPost() ) {

            $postData = $this->getRequest()->getPost();

            $result = Acaldeira_Mercadolivre_Helper_QuestionData::saveAnswer(
                        array(
                            'question_id'=>$postData['question_id'],
                            'text'=>$postData['answer']
                            ));


            if(isset($result['body']->id)){

                Mage::getSingleton('adminhtml/session')->addSuccess("Saved");

                $question = Mage::getModel('mercadolivre/question')->load($postData['question_id'],'ml_id');

                $question->setStatus("ANSWERED");

                $question->save();

            }else{

                Mage::getSingleton('adminhtml/session')->addError($result['body']->message);
       
            }
                
            $this->_redirect('*/*/index');
        }
        
    }

    /**
     * Product grid for AJAX request
     */
    public function gridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('mercadolivre/adminhtml_question_grid')->toHtml()
        );
    }
}