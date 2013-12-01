<?php

class AuthenticationController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }

    public function loginAction()
    {
    	//Checks if the user is already logged in, and if so, redirects it to the index controller
    	if(Zend_Auth::getInstance()->hasIdentity()) {
    		$this->_redirect('index/index');
    	}
    	
    	$request = $this->getRequest();
    	$form = new Application_Form_LoginForm();
    	
    	if($request->isPost()) {
    		if($form->isValid($this->_request->getPost())) {
    			
    			//Gets the Authentication Adapter
    			$authAdapter = $this->getAuthAdapter();
    			 
    			$username = $form->getValue('username');
    			$password = $form->getValue('password');
    			 
    			//Set user credentials
    			$authAdapter->setIdentity($username)
    			->setCredential($password);
    			 
    			$auth = Zend_Auth::getInstance();
    			$result = $auth->authenticate($authAdapter);
    			 
    			if($result->isValid()) {
    				$userIdentity =  $authAdapter->getResultRowObject();
    				 
    				$authStorage = $auth->getStorage();
    				$authStorage->write($userIdentity);
    				 
    				$this->_redirect('index/index');
    			} else {
    				$this->view->errorMessage = 'Invalid User Credentianls';
    			}    			
    		}	
    	}
    	
    	
    	$this->view->form = $form;
       
    }

    public function logoutAction()
    {
       Zend_Auth::getInstance()->clearIdentity();
       $this->_redirect('authentication/login');
    }

    /*
     * Function to get the Authentication Adapter
     * @return Zend_Auth_Adapter_DbTable
     */
	private function getAuthAdapter() 
	{
		//Get Instance of the DB adapter
		$dbAdapter = Zend_Db_Table::getDefaultAdapter();
		
		//Get Authentication adapter
		$authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);
		
		//Set up the Authentication Adapter
		$authAdapter->setTableName('users')
					->setIdentityColumn('username')
					->setCredentialColumn('password')
					->setCredentialTreatment('MD5(?)');
		
		return $authAdapter;
	}
}





