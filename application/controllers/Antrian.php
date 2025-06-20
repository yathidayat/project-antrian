<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Antrian_model');
    }

    // public function cetak_nomor() {
    //     $kode_loket = $this->input->post('kode_loket');
    //     $nomor_urut = $this->Antrian_model->generate_nomor_urut($kode_loket);
    //     echo "Nomor antrian: " . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT) . '-' . strtoupper($kode_loket);
    // }

    public function cetak_nomor()
    {
        $kode_loket = $this->input->post('kode_loket');
        $nomor_urut = $this->Antrian_model->generate_nomor_urut($kode_loket);
        echo "Nomor antrian: " . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT) . '-' . strtoupper($kode_loket);
    }


    public function panggil_nomor()
    {
        $kode_loket = $this->input->post('kode_loket');
        $nomor_urut = $this->Antrian_model->panggil_nomor($kode_loket);
        if ($nomor_urut) {
            echo "Nomor antrian yang dipanggil: " . str_pad($nomor_urut, 3, '0', STR_PAD_LEFT) . '-' . strtoupper($kode_loket);
        } else {
            echo "Tidak ada nomor antrian yang menunggu.";
        }
    }

    public function hapus_antrian($id_antrian)
    {
        // Panggil model untuk menghapus data
        $this->Antrian_model->hapus_antrian($id_antrian);

        // Redirect atau tampilkan pesan sukses/hapus berhasil
        redirect('antrian'); // Ganti 'antrian' dengan halaman yang sesuai
    }

    public function get_current_calling()
    {
        $this->db->where('status', 'dipanggil');
        $query = $this->db->get('antrian');
        return $query->row();
    }

    // Fungsi untuk memperbarui status antrian
    public function update_status_antrian($id, $action)
    {
        $status = ($action === 'panggil') ? 'dipanggil' : 'selesai';

        $this->db->where('id', $id);
        $this->db->update('antrian', ['status' => $status]);
    }

    // Fungsi untuk mengambil antrian berdasarkan loket
    public function get_antrian_by_loket($loket_code)
    {
        $this->db->where('kode_loket', $loket_code);
        $this->db->order_by('nomor', 'ASC');
        $query = $this->db->get('antrian');
        return $query->result();
    }

    public function update_antrian($kode_loket)
    {
        $id = $this->input->post('id');
        $action = $this->input->post('action');
        $status = ($action === 'panggil') ? 'dipanggil' : 'selesai';

        if ($action === 'panggil') {
            // Cek apakah masih ada nomor yang sedang dipanggil sebelum memanggil nomor baru
            if ($this->Antrian_model->is_any_called($kode_loket)) {
                echo json_encode(['success' => false, 'message' => 'Masih ada nomor urut yang dipanggil']);
                return;
            }
            $this->Antrian_model->update_status_antrian($id, $status);
        } elseif ($action === 'selesai') {
            // Ambil status saat ini dari nomor antrian
            $currentStatus = $this->Antrian_model->get_status($id);

            // Pastikan nomor antrian sudah dipanggil sebelum ditandai sebagai selesai
            if (
                $currentStatus === 'menunggu'
            ) {
                echo json_encode(['success' => false, 'message' => 'Nomor antrian harus dipanggil terlebih dahulu']);
                return;
            } else if ($currentStatus !== 'dipanggil') {
                echo json_encode(['success' => false, 'message' => 'Tidak ada nomor antrian yang sedang dipanggil']);
                return;
            }

            $this->Antrian_model->update_status_antrian($id, 'selesai');
        }

        echo json_encode(['success' => true]);
    }
}
