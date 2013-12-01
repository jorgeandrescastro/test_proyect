<?php
class Application_Model_UserMapper
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable)) {
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract) {
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this->_dbTable) {
			$this->setDbTable('Application_Model_DbTable_User');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_User $user)
	{
		$data = array(
				'name'   => $user->getName(),
				'username' => $user->getUsername(),
				'address' => $user->getAddress(),
				'birthday' => $user->getBirthday(),
		);

		if (null === ($id = $user->getId())) {
			unset($data['id']);
			return $this->getDbTable()->insert($data);
		} else {
			return $this->getDbTable()->update($data, array('id = ?' => $id));
		}
	}

	public function find($id)
	{
		$result = $this->getDbTable()->find($id);
		if (0 == count($result)) {
			return;
		}
		$row = $result->current();
		
		$user = new Application_Model_User();
		
		$user->setId($row->id)
		->setName($row->name)
		->setUsername($row->username)
		->setAddress($row->address)
		->setBirthday($row->birthday);
		
		return $user;
	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_User();
			$entry->setId($row->id)
			->setName($row->name)
			->setUsername($row->username)
			->setAddress($row->address)
			->setBirthday($row->birthday);
			$entries[] = $entry;
		}
		return $entries;
	}
}