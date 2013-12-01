<?php
class Application_Model_DbTable_Message extends Zend_Db_Table_Abstract {
	
	//Table name
	protected $_name = 'messages';

	protected $_referenceMap    = array(
			'From' => array(
					'columns'           => array('from_id'),
					'refTableClass'     => 'User',
					'refColumns'        => array('id')
			),
			'To' => array(
					'columns'           => array('to_id'),
					'refTableClass'     => 'User',
					'refColumns'        => array('id')
			)
	);
}