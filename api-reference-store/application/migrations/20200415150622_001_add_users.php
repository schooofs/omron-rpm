<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_001_add_users extends CI_Migration {

	/**
	 * Name of the table to be used in this migration!
	 *
	 * @var string
	 */
	protected $_table_name = "ci_users";

	public function up()
	{
		$this->dbforge->add_field(
            array(
                'id' => array(
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
                ),
                'physician_id' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'gc_reference' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'username' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'terms_accepted' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'policy_accepted' => array(
                    'type' => 'TEXT',
                    'null' => true,
                ),
                'data_assigned' => array(
                    'type' => 'LONGTEXT',
                    'null' => true,
                ),
                'data_processed' => array(
                    'type' => 'INT',
                    'null' => true,
                ),
                'data_processed_time' => array(
                    'type' => 'INT',
                    'null' => true,
                ),
            )
		);

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