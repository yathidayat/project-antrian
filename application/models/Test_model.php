<?php
class Test_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_data() {
        $query = $this->db->get('tb_anggota'); 
        return $query->result();
    }
}