<?php

class Physician_model extends CI_Model {
    
    function test_physician() {
        echo 'model';
    }

    function insert_data($data) {
        $this->db->inset('ci_physician', $data);
    }
}