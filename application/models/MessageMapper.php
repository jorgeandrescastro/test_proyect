<?php
class Application_Model_MessageMapper
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
			$this->setDbTable('Application_Model_DbTable_Message');
		}
		return $this->_dbTable;
	}

	public function save(Application_Model_Message $message)
	{
		$data = array(
				'from_id'   => $message->getFromId(),
				'to_id' => $message->getToId(),
				'message' => $message->getMessage(),
				'date_sent' => $message->getTimestamp(),
		);

		if (null === ($id = $message->getId())) {
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
		
		$message = new Application_Model_Message();
		
		$userMapper = new Application_Model_UserMapper();
		$fromUser = $userMapper->find($row->from_id);
		$toUser = $userMapper->find($row->to_id);
		
		$message->setId($row->id)
				->setFromId($row->from_id)
				->setFrom($fromUser)
				->setToId($row->to_id)
				->setTo($toUser)
				->setMessage($row->message)
				->setTimestamp($row->date_sent);
		
		return $message;
	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Message();
			
			$userMapper = new Application_Model_UserMapper();
			$fromUser = $userMapper->find($row->from_id);
			$toUser = $userMapper->find($row->to_id);
			
			$entry->setId($row->id)
				->setFromId($row->from_id)
				->setFrom($fromUser)
				->setToId($row->to_id)
				->setTo($toUser)
				->setMessage($row->message)
				->setTimestamp($row->date_sent);
			$entries[] = $entry;
		}
		return $entries;
	}
	
	public function fetchAllMessagesFromUserId($id)
	{
		$resultSet = $this->getDbTable()->fetchAll('to_id = ' . $id);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Application_Model_Message();
				
			$userMapper = new Application_Model_UserMapper();
			$fromUser = $userMapper->find($row->from_id);
			$toUser = $userMapper->find($row->to_id);
				
			$entry->setId($row->id)
				->setFromId($row->from_id)
				->setFrom($fromUser)
				->setToId($row->to_id)
				->setTo($toUser)
				->setMessage($row->message)
				->setTimestamp($row->date_sent);
			$entries[] = $entry;
		}
		return $entries;
	}
}