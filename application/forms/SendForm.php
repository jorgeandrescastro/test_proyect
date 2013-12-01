<?php
/*
 * Class to render Send Message Form 
 * @author Jorge Andrés Castro
 */
class Application_Form_SendForm extends Zend_Form {
	
	public function __construct($options = null, $users){
		parent::__construct($options);
		
		$this->setName('send');
		
		$addresseeField = new Zend_Form_Element_Select('touser');
		$addresseeField->setLabel("To: ")
			   ->setMultiOptions($users)
			   ->setRequired(true);
		
		$messageField = new Zend_Form_Element_Textarea('message');
		$messageField->setLabel('Enter your Message: ')
					 ->setRequired(true);
		
		$submitButton = new Zend_Form_Element_Submit('login');
		$submitButton->setLabel('Send');

		$this->addElements(array($addresseeField, $messageField, $submitButton));
		$this->setMethod('POST');
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/index/send');
	}
	
}