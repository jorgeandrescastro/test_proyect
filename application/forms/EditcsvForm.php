<?php
/*
 * Class to render the edit csv Message Form 
 * @author Jorge Andrés Castro
 */
class Application_Form_EditcsvForm extends Zend_Form {
	
	public function __construct($options = null, $text){
		parent::__construct($options);
		
		$this->setName('editcsv');
		
		$textField = new Zend_Form_Element_Textarea('csvtext');
		$textField->setLabel('CSV File content: ')
			      ->setRequired(true)
				  ->setValue($text);
		
		$submitButton = new Zend_Form_Element_Submit('login');
		$submitButton->setLabel('Send');

		$this->addElements(array($textField, $submitButton));
		$this->setMethod('POST');
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/index/downloadcsv');
	}
	
}