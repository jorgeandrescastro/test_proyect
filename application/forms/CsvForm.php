<?php
/*
 * Class to render the CSBV upload Form 
 * @author Jorge Andrés Castro
 */
class Application_Form_CsvForm extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$this->setName('csv');
		$this->setAttrib('enctype', 'multipart/form-data');
		
		$csvField = new Zend_Form_Element_File('file');
		$csvField->setLabel("Choose the csb file to upload: ")
			   ->setRequired(true)
			   ->setDestination(APPLICATION_PATH . '\data')
			   ->addValidator('Extension', false, 'csv');
		
		$submitButton = new Zend_Form_Element_Submit('login');
		$submitButton->setLabel('Upload');

		$this->addElements(array($csvField, $submitButton));
		$this->setMethod('POST');
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/index/editcsv');
	}
	
}