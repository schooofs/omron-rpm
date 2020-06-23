<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submission_model extends CI_Model {
    private $table_name = 'ci_data_models';

    public function __construct() {
        parent::__construct();
    }

    public function update( $data, $id ) {
        $this->db->update( $this->table_name, $data, array('id' => intval($id)) );
    }

    public function insert( $data ) {
        $this->db->insert( $this->table_name, $data );
    }

    public function getThisMonth( ) {
        return $this->db->select('*')->from($this->table_name)
        ->where('MONTH(created_at)', date('m'))
        ->where('YEAR(created_at)', date('Y'))
        ->get()
        ->result();
    }

    public function getUnprocessed() {
        return $this->db->select('*')->from($this->table_name)
        ->where('data_processed_time', null)
        ->get()
        ->result();
    }
}