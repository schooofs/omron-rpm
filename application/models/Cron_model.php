<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
    }

    function test_cron() {
        echo 'model';
    }

}