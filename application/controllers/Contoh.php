<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contoh extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('Test_model');
    }

	public function index()
	{
		$data['data'] = $this->Test_model->get_data();

		// var_dump($data);exit;
		$this->load->view('v_test', $data);
    }

	public function get_anggota() {
        $data = $this->Test_model->get_data();
        echo json_encode($data);
    }
	
}
