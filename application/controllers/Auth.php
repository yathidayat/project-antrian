<?php

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model'); // Pastikan model User_model diload
        $this->load->library('session'); // Menggunakan session
    }

    public function index()
    {
        $this->load->view('v_awal'); // Tampilan login
    }

    public function login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        // Cek apakah user ada di database
        $user = $this->User_model->get_user_by_username($username);

        if ($user) {
            // Verifikasi password menggunakan MD5
            if (md5($password) === $user['password']) {
                // Jika password benar, cek status untuk redirect
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('status', $user['status']);

                switch ($user['status']) {
                    case 'admin':
                        redirect('dashboard/admin'); // Halaman admin
                        break;
                    case 'loket1':
                        redirect('dashboard/loketone'); // Halaman loket 1
                        break;
                    case 'loket2':
                        redirect('dashboard/lokettwo'); // Halaman loket 2
                        break;
                    case 'loket3':
                        redirect('dashboard/loketthree'); // Halaman loket 3
                        break;
                    case 'loket4':
                        redirect('dashboard/loketfour'); // Halaman loket 4
                        break;
                    case 'loket5':
                        redirect('dashboard/loketfive'); // Halaman loket 5
                        break;
                    default:
                        $this->session->set_flashdata('error', 'Status tidak dikenal.');
                        redirect('auth/index');
                        break;
                }
            } else {
                // Password salah
                $this->session->set_flashdata('error', 'Password salah.');
                redirect('auth/index');
            }
        } else {
            // Username tidak ditemukan
            $this->session->set_flashdata('error', 'Username tidak ditemukan.');
            redirect('auth/index');
        }
    }

    public function logout(){
          // Hancurkan semua session pengguna
          $this->session->sess_destroy();

          // Redirect ke halaman login
          redirect('auth/login');
    }
}
