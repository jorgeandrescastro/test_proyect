<?php
/*
 * Model Class for the Message
 */
class Application_Model_Message
{
	protected $_id;
	protected $_fromId;
	protected $_from;
	protected $_toId;
	protected $_to;
	protected $_message;
	protected $_timestamp;

	public function __construct(array $options = null)
	{
		if (is_array($options)) {
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid message property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid message property');
		}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
		foreach ($options as $key => $value) {
			$method = 'set' . ucfirst($key);
			if (in_array($method, $methods)) {
				$this->$method($value);
			}
		}
		return $this;
	}
	
	public function setId($id)
	{
		$this->_id = (int) $id;
		return $this;
	}
	
	public function getId()
	{
		return $this->_id;
	}

	public function setFromId($fromId)
	{
		$this->_fromId = (int) $fromId;
		return $this;
	}

	public function getFromId()
	{
		return $this->_fromId;
	}
	
	public function setToId($toId)
	{
		$this->_toId = (int) $toId;
		return $this;
	}
	
	public function getToId()
	{
		return $this->_toId;
	}
	
	public function setFrom(Application_Model_User $from)
	{
		$this->_from = $from;
		return $this;
	}
	
	public function getFrom()
	{
		return $this->_from;
	}
	
	public function setTo(Application_Model_User $to)
	{
		$this->_to = $to;
		return $this;
	}
	
	public function getTo()
	{
		return $this->_to;
	}

	public function setMessage($message)
	{
		$this->_message = (string) $message;
		return $this;
	}

	public function getMessage()
	{
		return $this->_message;
	}
	
	public function setTimestamp($timestamp)
	{
		$this->_timestamp = $timestamp;
		return $this;
	}
	
	public function getTimestamp()
	{
		return $this->_timestamp;
	}
	

}