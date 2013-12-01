<?php
/*
 * Model Class for the User 
 */
class Application_Model_User
{
	protected $_id;
	protected $_name;
	protected $_username;
	protected $_address;
	protected $_birthday;

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
			throw new Exception('Invalid user property');
		}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
		if (('mapper' == $name) || !method_exists($this, $method)) {
			throw new Exception('Invalid user property');
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

	public function setName($name)
	{
		$this->_name = (string) $name;
		return $this;
	}

	public function getName()
	{
		return $this->_name;
	}

	public function setUsername($username)
	{
		$this->_username= (string) $username;
		return $this;
	}

	public function getUsername()
	{
		return $this->_username;
	}

	public function setAddress($address)
	{
		$this->_address = (string) $address;
		return $this;
	}

	public function getAddress()
	{
		return $this->_address;
	}
	
	public function setBirthday($birthday)
	{
		$this->_birthday = $birthday;
		return $this;
	}
	
	public function getBirthday()
	{
		return $this->_birthday;
	}

}