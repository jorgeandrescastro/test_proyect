<?php
/*
 * Class to render Login Form containing Username and Password
 * @author Jorge Andrés Castro
 */
class Application_Form_LoginForm extends Zend_Form {
	
	public function __construct($options = null){
		parent::__construct($options);
		
		$this->setName('login');
		
		$usernameField = new Zend_Form_Element_Text('username');
		$usernameField->setLabel('Enter your Username: ')
					  ->setRequired(true);
		
		$passwordField = new Zend_Form_Element_Password('password');
		$passwordField->setLabel('Enter your Password: ')
					   ->setRequired(true);
		
		$submitButton = new Zend_Form_Element_Submit('login');
		$submitButton->setLabel('Enter');

		$this->addElements(array($usernameField, $passwordField, $submitButton));
		$this->setMethod('POST');
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/authentication/login');
	}
	
}