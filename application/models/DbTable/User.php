<?php
class Application_Model_DbTable_User extends Zend_Db_Table_Abstract {
	
	//Table name
	protected $_name = 'users';
	protected $_dependentTables = array('Messages');
}