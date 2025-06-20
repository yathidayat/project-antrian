<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Antrian_model');
        
        
    }
 

    public function index() {
        // Ambil data nomor antrian terakhir dari masing-masing loket
        $data['loket_kasir'] = $this->Antrian_model->get_last_displayed_antrian_by_loket('k');
        $data['loket_perkara'] = $this->Antrian_model->get_last_displayed_antrian_by_loket('p');
        $data['loket_hukum'] = $this->Antrian_model->get_last_displayed_antrian_by_loket('h');
        $data['loket_umum'] = $this->Antrian_model->get_last_displayed_antrian_by_loket('u');
        $data['loket_ecourt'] = $this->Antrian_model->get_last_displayed_antrian_by_loket('e');
        
        // Kirim data ke view
        $this->load->view('home', $data);
    }

    // public function login() {
    //     $this->load->view('login');
    // }

    public function get_antrian_data() {
        $data = array(
            'loket_kasir' => $this->Antrian_model->get_last_displayed_antrian_by_loket('k') ?: '0',
            'loket_perkara' => $this->Antrian_model->get_last_displayed_antrian_by_loket('p') ?: '0',
            'loket_hukum' => $this->Antrian_model->get_last_displayed_antrian_by_loket('h') ?: '0',
            'loket_umum' => $this->Antrian_model->get_last_displayed_antrian_by_loket('u') ?: '0',
            'loket_ecourt' => $this->Antrian_model->get_last_displayed_antrian_by_loket('e') ?: '0'
        );
    
        // Convert any non-numeric values to '0'
        foreach ($data as &$value) {
            if (!is_numeric($value)) {
                $value = '0';
            }
        }
    
        echo json_encode($data);
    }
    
}
?>
