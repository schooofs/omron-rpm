<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
    private $table_name = 'ci_users';

    public function __construct() {
        parent::__construct();
    }

    public function getByPhysicianId( $physicianId ) {
        if( !$physicianId ) {
            throw new \Exception("PhysicianId is missing.");
        }

        //Get Physician
        $gcReference = null;
        $query = $this->db->query("SELECT * FROM `{$this->table_name}` WHERE physician_id='".$physicianId."' LIMIT 1;");
        $user = $query->row();

        if( !$user ) {
            throw new \Exception("This username ". $gcReference ." is not registered on the server");
        }

        return $user;
    }

    public function getByUsername( $username ) {
        if( !$username ) {
            throw new \Exception("Username is missing");
        }

        $query = $this->db->query("SELECT * FROM `{$this->table_name}` WHERE username='". $username ."' LIMIT 1;");
        $user = $query->row();

        return $user;
    }

    public function getById( $id ) {
        if( !$id ) {
            throw new \Exception("ID is missing");
        }

        $query = $this->db->query("SELECT * FROM `{$this->table_name}` WHERE id=".intval($id)." LIMIT 1;");
        $user = $query->row();

        if( !$user ) {
            throw new \Exception("This ID ". $id ." is not registered on the server");
        }

        return $user;
    }

    public function update( $data, $username ) {
        $this->db->update( $this->table_name, $data, array('username' => $username) );
    }

    public function insert( $data ) {
        $this->db->insert( $this->table_name, $data );
    }

    public function forgotPassword($user) {

        $this->load->library('cordial');

        $resetToken = $this->generateRandomString(25);

        $data = array(
            'pw_reset_token'    => $resetToken,
            'pw_reset_token_created_at' => time(),
        );

        $this->update($data, $user->username);

        $cordialBody =  [
            'identifyBy'    => 'email',
            'to'            => [
                'contact'       => [
                    'email'         => 'edelin.petrov@mentormate.com',
                ],
                'extVars'           => [
                    'link'                  => $resetToken,
                ],
            ],
        ];

        //Send pw reset email
        // $cordial = $this->cordial->postPasswordReset($cordialBody);

        return true;
    }
    
    public function generateRandomString($length) {
        $include_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        /* Uncomment below to include symbols */
        /* $include_chars .= "[{(!@#$%^/&*_+;?\:)}]"; */
        $charLength = strlen($include_chars);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $include_chars [rand(0, $charLength - 1)];
        }
        return $randomString;
    }
    
}