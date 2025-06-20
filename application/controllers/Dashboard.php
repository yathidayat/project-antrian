<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		// $this->load->library('tcpdf');
		$this->load->model('Antrian_model');
		$this->load->model('User_model');

		if (!$this->session->userdata('username')) {
			redirect('auth/index');  // Jika tidak ada session, redirect ke halaman login
		}
	}

	public function index()
	{
		// echo "<h1> Hello World </h1>";
		// $this->load->view('dasboard');
	}

	public function loketOne()
	{
		$data['antrian'] = $this->Antrian_model->get_antrian_by_loket('K');
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('loket1', $data);
	}

	public function loketTwo()
	{
		$data['antrian'] = $this->Antrian_model->get_antrian_by_loket('P');
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('loket2', $data);
	}

	public function loketThree()
	{
		$data['antrian'] = $this->Antrian_model->get_antrian_by_loket('H');
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('loket3', $data);
	}

	public function loketFour()
	{
		$data['antrian'] = $this->Antrian_model->get_antrian_by_loket('U');
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('loket4', $data);
	}

	public function loketFive()
	{
		$data['antrian'] = $this->Antrian_model->get_antrian_by_loket('E');
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('loket5', $data);
	}


	public function admin()
	{
		$this->load->view('admin');
	}

	public function pelayanan()
	{
		$data['loket'] = $this->Antrian_model->get_loket_with_last_number();
		$this->load->view('pelayanan', $data);
	}

	public function pengguna()
	{
		$this->load->view('pengguna');
	}

	public function pengunjung()
	{
		$this->load->view('pengunjung');
	}


	public function update_pengguna()
	{
		$user_id = $this->input->post('user_id'); // Ambil user_id dari form
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$status = $this->input->post('status');

		// Jika user_id kosong, lakukan insert
		if (empty($user_id)) {
			$data = array(
				'username' => $username,
				'password' => md5($password),  // Menggunakan MD5 untuk hashing password
				'status' => $status
			);
			$this->db->insert('users', $data);
			$this->session->set_flashdata('message', 'Data pengguna berhasil ditambahkan.');
		} else {
			// Jika user_id ada, lakukan update
			$data = array(
				'username' => $username,
				'status' => $status
			);

			// Update password hanya jika diisi
			if (!empty($password)) {
				$data['password'] = password_hash($password, PASSWORD_DEFAULT);
			}

			$this->db->where('id_user', $user_id);
			$this->db->update('users', $data);
			$this->session->set_flashdata(
				'message',
				'Data pengguna berhasil diperbarui.'
			);
		}

		redirect('dashboard/pengguna');
	}

	public function hapus_pengguna()
	{
		$id = $this->input->post('user_id'); // Tangkap user_id dari request POST

		if ($id) {
			// Hapus data dari database melalui model
			$this->User_model->delete_user($id);

			// Kirim response sukses
			echo json_encode(['status' => 'success']);
		} else {
			// Kirim response error jika ID tidak ditemukan
			echo json_encode(['status' => 'error', 'message' => 'ID pengguna tidak ditemukan']);
		}
	}



	public function get_pengguna()
	{
		// Ambil data pengguna dari model
		$users = $this->User_model->get_all_users();

		// Mengirimkan data dalam format JSON
		echo json_encode($users);
	}

	public function get_antrian_loket($loket_code)
	{
		$data = $this->Antrian_model->get_antrian_by_loket($loket_code);

		// var_dump($data);exit();
		echo json_encode($data);
	}


	public function update_antrian()
	{
		$id = $this->input->post('id');
		$action = $this->input->post('action');

		// Update status antrian di model
		$this->Antrian_model->update_status_antrian($id, $action);

		// Kembalikan respons sukses
		echo json_encode(['status' => 'success']);
	}


	public function get_daily_visitors()
	{
		$year = $this->input->get('year');
		$month = $this->input->get('month');
		$data = $this->Antrian_model->get_daily_visitors_data($year, $month);
		echo json_encode($data);
	}

	public function get_monthly_report()
	{
		$year = $this->input->get('year');
		$data = $this->Antrian_model->get_monthly_report_data($year);
		echo json_encode($data);
	}

	public function simpan_buku_tamu()
	{
		 // Ambil data dari POST request
		 $data = array(
			'nama' => ucwords(strtolower(trim($this->input->post('nama', true)))),
			'nohp' => $this->input->post('no_hp', true),
			'umur' => $this->input->post('umur', true),
			'pendidikan' => $this->input->post('pendidikan', true),
			'email' => $this->input->post('email', true),
			'jenis_kelamin' => $this->input->post('jenis_kelamin', true),
			'alamat' => $this->input->post('alamat', true),
			'keperluan' => $this->input->post('keperluan', true),
			'waktu' => date('Y-m-d H:i:s')
		);
	
		// Ambil data base64 dari input hidden "imageData"
		$imageData = $this->input->post('imageData');
	
		if (!empty($imageData)) {
			// Generate nama file berdasarkan tanggal dan waktu
			$fileName = 'foto_' . date('Ymd_His') . '.jpg'; // Nama file dengan format tanggal dan waktu
	
			// Path untuk menyimpan file gambar
			$path = 'assets/pengunjung/uploads/foto_tamu/' . $fileName;
	
			// Menghilangkan prefix base64 dan mendecode datanya
			$imageData = str_replace('data:image/png;base64,', '', $imageData);
			$imageData = str_replace(' ', '+', $imageData);
			$imageContent = base64_decode($imageData);
	
			// Simpan file gambar
			file_put_contents($path, $imageContent);
	
			// Tambahkan nama file foto ke dalam data yang akan disimpan ke database
			$data['foto'] = $fileName;
		}

		// var_dump($data);exit();
	
		// Simpan data ke database
		$insert_id = $this->Antrian_model->post_buku_tamu($data);
	
		// Jika insert berhasil, $insert_id harusnya memiliki nilai
		if ($insert_id) {
			echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan']);
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data']);
		}
	}

	public function get_pengunjung()
	{
		// Ambil data pengguna dari model
		$data = $this->Antrian_model->get_all_pengunjung();

		// Mengirimkan data dalam format JSON
		echo json_encode($data);
	}

	public function ubah_data_pengunjung()
	{
		$id_user = $this->input->post('id_user');
		
		$data = [
			'nama' => $this->input->post('nama'),
			'nohp' => $this->input->post('no_hp'),
			'email' => $this->input->post('email'),
			'alamat' => $this->input->post('alamat'),
			'pendidikan' => $this->input->post('pendidikan'),
			'keperluan' => $this->input->post('keperluan')
		];

		$result = $this->Antrian_model->update_data_pengunjung($id_user, $data);
		if ($result) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	public function hapus_data_pengunjung()
	{
		$id_user = $this->input->post('id_user');

		
		$result = $this->Antrian_model->delete_data_pengunjung($id_user);
		
		if ($result) {
			echo json_encode(['status' => 'success']);
		} else {
			echo json_encode(['status' => 'error']);
		}
	}

	public function laporan(){
		$this->load->view('laporan');
	}


	public function cetak_laporan()
	{
		$bulan = $this->input->post('bulan');
		$tahun = $this->input->post('tahun');
		$username = $this->session->userdata('username');

		// var_dump($bulan);exit();

		// Validasi input
		if (empty($bulan) || empty($tahun)) {
			echo json_encode(['status' => 'error', 'message' => 'Pilih bulan dan tahun terlebih dahulu']);
			return;
		}

		// Ambil data dari model
		$data_laporan_antrian = $this->Antrian_model->get_cetak_laporan_antrian($bulan, $tahun);
		$total_data = $this->Antrian_model->get_total_pengunjung($bulan, $tahun);

		// var_dump($total_data);exit();

		// Cek apakah data tersedia
		if (empty($data_laporan_antrian) && $total_data['total_pengunjung'] == 0) {
			echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan untuk bulan dan tahun yang dipilih']);
			return;
		}

		// Kirim data ke view untuk ditampilkan
		// $data['bulan'] = $bulan;
		// $data['tahun'] = $tahun;
		// $data['laporan'] = $data_laporan_antrian;
		// $data['dataPengunjung'] = $total_data['dataPengunjung'];
		// $data['total_pengunjung'] = $total_data['total_pengunjung'];
		// $data['pendidikan'] = $total_data['pendidikan']; // Menyimpan data pendidikan
		// $data['jenis_kelamin'] = $total_data['jenis_kelamin']; // Menyimpan data jenis kelamin
		// $data['username'] = $username;

		$data['bulan'] = $bulan;
		$data['tahun'] = $tahun;
		$data['laporan'] = !empty($data_laporan_antrian) ? $data_laporan_antrian : [];
		$data['dataPengunjung'] = isset($total_data['dataPengunjung']) ? $total_data['dataPengunjung'] : [];
		$data['total_pengunjung'] = isset($total_data['total_pengunjung']) ? $total_data['total_pengunjung'] : 0;
		$data['pendidikan'] = isset($total_data['pendidikan']) ? $total_data['pendidikan'] : [];
		$data['jenis_kelamin'] = isset($total_data['jenis_kelamin']) ? $total_data['jenis_kelamin'] : [];
		$data['username'] = $username;


		// var_dump($data);exit();

		// Load view dengan data yang telah disiapkan
		$this->load->view('cetak_laporan', $data);
	}


	public function get_pengunjung_by_pendidikan() {
		$data = $this->Antrian_model->get_pengunjung_by_pendidikan();
		echo json_encode($data);
	}
	
	public function get_pengunjung_by_gender() {
		$data = $this->Antrian_model->get_pengunjung_by_gender();
		echo json_encode($data);
	}
	

	
}
