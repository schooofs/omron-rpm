<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_ci_data_models extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "data_models";

	public function up()
	{
		$this->dbforge->add_field(array(
			'id' => array(
				'type' => 'INT',
				'unsigned' => true,
				'auto_increment' => true
			),
			'user_id' => array(
				'type' => 'INT',
				'null' => true,
			),
			'data' => array(
				'type' => 'LONGTEXT',
				'null' => true,
			),
			'items' => array(
				'type' => 'LONGTEXT',
				'null' => true,
			),
			'email_notified' => array(
				'type' => 'INT',
				'null' => true,
			),
			'data_received_time' => array(
				'type' => 'INT',
				'null' => true,
			),
			'data_processed_time' => array(
				'type' => 'INT',
				'null' => true,
			),
			'order_submitted'	  => array(
				'type' => 'INT',
				'null' => true,
			),
		));
		
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->add_field("`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->add_field("`updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP");
		$this->dbforge->create_table($this->_table_name, TRUE);
	}

	public function down()
	{
		$this->dbforge->drop_table($this->_table_name, TRUE);
	}

}

?>