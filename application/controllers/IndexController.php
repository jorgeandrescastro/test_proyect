<?php

class IndexController extends Zend_Controller_Action
{
	private $_userAuth;
	
    public function init()
    {
        /* Initialize action controller here */
    	if(!Zend_Auth::getInstance()->hasIdentity()) {
    		$this->_redirect('authentication/login');
    	}
    	$this->_userAuth = Zend_Auth::getInstance()->getIdentity();
    	
    }

    public function indexAction()
    {
        // action body
    }
    
    public function editAction(){

    	$userMapper = new Application_Model_UserMapper();
    	$user = $userMapper->find($this->_userAuth->id);
    	
    	$request = $this->getRequest();
    	$form = new Application_Form_EditForm(null, $user);
    	
    	if($request->isPost()) {
    		if($form->isValid($this->_request->getPost())) {
    			$username = $form->getValue('username');
    			$name = $form->getValue('name');
    			$address = $form->getValue('address');
    			$birthday = $form->getValue('birthday');
    			
    			$user->setUsername($username);
    			$user->setName($name);
    			$user->setAddress($address);
    			$user->setBirthday($birthday);
    			if($userMapper->save($user)) {
    				$this->view->savedMessage = 'The profile has been edited succesfully';
    			} else {
    				$this->view->errorMessage = 'An error has ocurred saving the edited profile';
    			}
    		}
    	}
    	
    	$this->view->form = $form;
    }

	public function messageAction(){
		
		$messageMapper = new Application_Model_MessageMapper();
		$messages = $messageMapper->fetchAllMessagesFromUserId($this->_userAuth->id);
		
		$paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Array($messages));
		$paginator->setItemCountPerPage(2)
				  ->setCurrentPageNumber($this->_getParam('page', 1));
		
		$this->view->paginator = $paginator;
	}
	
	public function sendAction() {
		
		$userMapper = new Application_Model_UserMapper();
		$users = $userMapper->fetchAll();
		
		$userSelect = array();
		
		foreach($users as $user) {
			if($user->getId() != $this->_userAuth->id) {
				$userSelect[$user->getId()] = $user->getName();
			}
		}
		
		$messageMapper = new Application_Model_MessageMapper();
		$message = new Application_Model_Message();
		
		$request = $this->getRequest();
		$form = new Application_Form_SendForm(null, $userSelect);
		 
		if($request->isPost()) {
			if($form->isValid($this->_request->getPost())) {
				
				$toId = $form->getValue('touser');
				$messageText = $form->getValue('message');
				
				$message->setFromId($this->_userAuth->id);
				$message->setToId($toId);
				$message->setMessage($messageText);
				$message->setTimestamp(date("Y-m-d H:i:s"));
				
				if($messageMapper->save($message)) {
					$this->view->savedMessage = 'The message has been sent succesfully';
				} else {
					$this->view->errorMessage = 'An error has ocurred sending the message';
				}
			}
		}
		 
		$this->view->form = $form;
	}
	
	public function csvAction() {
		$form = new Application_Form_CsvForm();
		$this->view->form = $form;
	}
	
	public function editcsvAction() {
		$form = new Application_Form_CsvForm();
		if ($this->_request->isPost()) {
			$formData = $this->_request->getPost();
			if ($form->isValid($formData)) {
		
				$uploadedData = $form->getValues();
				$fullFilePath = $form->file->getFileName();
				
				$text = file_get_contents($fullFilePath);
				$form = new Application_Form_EditcsvForm(null, $text);
			}	
		}
		
		$this->view->form = $form;
	}
	
	public function downloadcsvAction() {
		$this->_helper->layout->setLayout('empty');
		if ($this->_request->isPost()) {
			$formData = $this->_request->getPost();
			$messageText = $formData['csvtext'];
			$this->view->csv = $messageText;
		}
		
	}
}

