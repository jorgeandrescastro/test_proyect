<?php
/*
 * Class to render the Edi profile Form
 * @author Jorge Andrés Castro
 */
class Application_Form_EditForm extends Zend_Form {
	
	public function __construct($options = null, Application_Model_User $user){
		parent::__construct($options);
		
		$this->setName('edit');
		
		$nameField = new Zend_Form_Element_Text('name');
		$nameField->setLabel('Name: ')
					   ->setRequired(true)
					   ->setValue($user->getName());
		
		$usernameField = new Zend_Form_Element_Text('username');
		$usernameField->setLabel('Username: ')
					  ->setRequired(true)
					  ->setValue($user->getUsername());
		
		$addressField = new Zend_Form_Element_Text('address');
		$addressField->setLabel('Address: ')
					 ->setRequired(true)
					 ->setValue($user->getAddress());
		
		$birthdayField = new Zend_Form_Element_Text('birthday');
		$birthdayField->setLabel('Birthday Date: ')
					  ->setRequired(true)
					  ->setValue($user->getBirthday());
		
		$submitButton = new Zend_Form_Element_Submit('login');
		$submitButton->setLabel('Edit Profile');

		$this->addElements(array($nameField, $usernameField, $addressField, $birthdayField, $submitButton));
		$this->setMethod('POST');
		
		$this->setAction(Zend_Controller_Front::getInstance()->getBaseUrl() . '/index/edit');
	}
	
}