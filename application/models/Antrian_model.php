<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Antrian_model extends CI_Model
{

    // public function get_loket_with_last_number() {
    //     $this->db->select('loket.*, COALESCE(MAX(antrian.nomor), 0) as nomor_terakhir');
    //     $this->db->from('loket');
    //     $this->db->join('antrian', 'antrian.kode_loket = loket.kode_loket', 'left');
    //     $this->db->group_by('loket.id');
    //     $query = $this->db->get();
    //     return $query->result();
    // }

    // public function generate_nomor_urut($kode_loket) {
    //     $this->db->select('nomor');
    //     $this->db->from('antrian');
    //     $this->db->where('kode_loket', $kode_loket);
    //     $this->db->order_by('nomor', 'DESC');
    //     $this->db->limit(1);

    //     $query = $this->db->get();
    //     $nomor_terakhir = $query->row() ? $query->row()->nomor : 0;

    //     $nomor_baru = $nomor_terakhir + 1;

    //     $data = [
    //         'nomor' => $nomor_baru,
    //         'kode_loket' => $kode_loket,
    //         'status' => 'menunggu',
    //         'waktu' => date('Y-m-d H:i:s')
    //     ];

    //     $this->db->insert('antrian', $data);

    //     return $nomor_baru;
    // }

    // public function panggil_nomor($kode_loket) {
    //     $this->db->select('nomor, waktu');
    //     $this->db->from('antrian');
    //     $this->db->where('kode_loket', $kode_loket);
    //     $this->db->where('status', 'menunggu');
    //     $this->db->order_by('nomor', 'ASC');
    //     $this->db->limit(1);

    //     $query = $this->db->get();
    //     $nomor = $query->row() ? $query->row()->nomor : null;

    //     if ($nomor) {
    //         // Ambil waktu saat ini
    //         $waktu_sekarang = date('Y-m-d H:i:s');

    //         // Update status dan waktu
    //         $this->db->where('kode_loket', $kode_loket);
    //         $this->db->where('nomor', $nomor);
    //         $this->db->update('antrian', ['status' => 'dipanggil', 'waktu' => $waktu_sekarang]);
    //     }

    //     return $nomor;
    // }

    public function get_loket_with_last_number()
    {
        $this->db->select('loket.*, COALESCE(MAX(CASE WHEN DATE(antrian.waktu) = CURDATE() THEN antrian.nomor ELSE 0 END), 0) as nomor_terakhir, MAX(antrian.waktu) as waktu_terakhir');
        $this->db->from('loket');
        $this->db->join('antrian', 'antrian.kode_loket = loket.kode_loket', 'left');
        $this->db->group_by('loket.id');
        $query = $this->db->get();
        return $query->result();
    }


    public function generate_nomor_urut($kode_loket)
    {
        $tanggal = date('Y-m-d');
        $this->db->select('nomor');
        $this->db->from('antrian');
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('DATE(waktu)', $tanggal);
        $this->db->order_by('nomor', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();

        if ($result) {
            $nomor_urut = $result->nomor + 1;
        } else {
            $nomor_urut = 1;
        }

        // Simpan nomor urut dengan status menunggu
        $this->simpan_nomor_urut($kode_loket, $nomor_urut, 'menunggu');

        return $nomor_urut;
    }

    public function simpan_nomor_urut($kode_loket, $nomor_urut, $status)
    {
        // Menetapkan zona waktu Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');

        // Data yang akan disimpan ke database
        $data = array(
            'kode_loket' => $kode_loket,
            'nomor' => $nomor_urut,
            'waktu' => date('Y-m-d H:i:s'), // Mengambil waktu sesuai timezone
            'status' => $status
        );

        // Memasukkan data ke tabel 'antrian'
        $this->db->insert('antrian', $data);
    }


    public function hapus_antrian($id_antrian)
    {
        $this->db->where('id', $id_antrian); // Sesuaikan dengan primary key tabel antrian
        $this->db->delete('antrian');
    }

    public function get_last_displayed_antrian_by_loket($kode_loket)
    {
        // Cari nomor antrian terakhir yang dipanggil atau selesai untuk loket tertentu
        $tanggal = date('Y-m-d');
        $this->db->select('nomor');
        $this->db->from('antrian');
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('DATE(waktu)', $tanggal);
        $this->db->where_in('status', ['dipanggil', 'selesai']); // Memperhitungkan status dipanggil dan selesai
        $this->db->order_by('nomor', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();
        $result = $query->row();

        // Jika tidak ada yang dipanggil atau selesai, kembalikan '-'
        if ($result) {
            return $result->nomor;
        } else {
            return '-';
        }
    }


    public function get_antrian_by_loket($kode_loket)
    {
        $tanggal = date('Y-m-d');
        $this->db->select('*');
        $this->db->from('antrian');
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('DATE(waktu)', $tanggal);
        $this->db->where_not_in('status', ['selesai']); // Tambahkan filter untuk tidak mengambil status 'selesai'
        $this->db->order_by('nomor', 'ASC');
        $query = $this->db->get();
        return $query->result();
    }

    public function update_status_antrian($id, $status)
    {
        // Update status antrian berdasarkan id
        if ($status === 'selesai') {
            // Tambahkan logika tambahan jika diperlukan
        }
        $data = array('status' => $status);
        $this->db->where('id', $id);
        $this->db->update('antrian', $data);
    }

    public function get_antrian_loket($kode_loket)
    {
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('status !=', 'selesai');
        $this->db->order_by('nomor', 'ASC');
        return $this->db->get('antrian')->result_array();
    }

    public function update_status($id, $status)
    {
        $this->db->where('id', $id);
        $this->db->update('antrian', ['status' => $status]);
    }

    public function is_any_called_by_loket($kode_loket)
    {
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('status', 'dipanggil');
        $query = $this->db->get('antrian');
        return $query->num_rows() > 0;
    }

    public function get_status($id)
    {
        $this->db->select('status');
        $this->db->from('antrian');
        $this->db->where('id', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row()->status;
        }
        return null;
    }

    // public function is_any_called($kode_loket)
    // {
    //     $this->db->where('kode_loket', $kode_loket);
    //     $this->db->where('status', 'dipanggil');
    //     $query = $this->db->get('antrian');
    //     return $query->num_rows() > 0;
    // }

    public function is_any_called($kode_loket)
    {
        $tanggal = date('Y-m-d'); // Mendapatkan tanggal hari ini
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('status', 'dipanggil');
        $this->db->where('DATE(waktu)', $tanggal); // Memastikan hanya antrian hari ini yang diperiksa
        $query = $this->db->get('antrian');
        return $query->num_rows() > 0; // Mengembalikan true jika ada baris dengan status 'dipanggil'
    }


    public function get_daily_visitors_data($year, $month)
    {
        $this->db->select('DAY(waktu) as day, COUNT(*) as count');
        $this->db->from('antrian');
        $this->db->where('YEAR(waktu)', $year);
        $this->db->where('MONTH(waktu)', $month);
        $this->db->group_by('DAY(waktu)');
        $this->db->order_by('DAY(waktu)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_monthly_report_data($year)
    {
        $this->db->select('MONTH(waktu) as month, COUNT(*) as count');
        $this->db->from('antrian');
        $this->db->where('YEAR(waktu)', $year);
        $this->db->group_by('MONTH(waktu)');
        $this->db->order_by('MONTH(waktu)', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_antrian_count_by_laporan($kode_loket, $year, $month)
    {
        $this->db->select('COUNT(*) as count');
        $this->db->from('antrian');
        $this->db->where('kode_loket', $kode_loket);
        $this->db->where('YEAR(waktu)', $year);
        $this->db->where('MONTH(waktu)', $month);
        $this->db->where_not_in('status', ['selesai']);
        $query = $this->db->get();
        return $query->row()->count;
    }

    public function post_buku_tamu($data)
    {
        // Insert data ke tabel pengunjung
        $this->db->insert('pengunjung', $data);

        // Mengembalikan ID terakhir yang di-insert (jika berhasil)
        if ($this->db->affected_rows() > 0) {
            return $this->db->insert_id();
        } else {
            return false; // Jika tidak ada baris yang terpengaruh
        }
    }

    public function get_all_pengunjung()
    {
        // Urutkan berdasarkan waktu secara descending (terbaru dulu)
        $this->db->order_by('waktu', 'DESC'); // Benar penempatan order_by sebelum get()

        // Jalankan query untuk mendapatkan data dari tabel pengunjung
        $query = $this->db->get('pengunjung');

        return $query->result_array();  // Mengembalikan data sebagai array
    }

    
    public function update_data_pengunjung($id_user, $data) {
        $this->db->where('id', $id_user);
        return $this->db->update('pengunjung', $data);
    }

    public function delete_data_pengunjung($id_user) {
        $this->db->where('id', $id_user);
        return $this->db->delete('pengunjung');
    }

    public function get_cetak_laporan_antrian($bulan, $tahun) {
        $this->db->select('kode_loket, COUNT(*) as jumlah_antrian');
        $this->db->from('antrian');
        $this->db->where('MONTH(waktu)', $bulan);
        $this->db->where('YEAR(waktu)', $tahun);
        $this->db->group_by('kode_loket');
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false; // Data tidak ditemukan
        }
    }

    // Mengambil total pengunjung dari tabel pengunjung
    // Mengambil total pengunjung dari tabel pengunjung
    public function get_total_pengunjung($bulan, $tahun)
    {

        // Mengambil seluruh data pengunjung
        $this->db->select('*');
        $this->db->from('pengunjung');
        $this->db->where('MONTH(waktu)', $bulan);
        $this->db->where('YEAR(waktu)', $tahun);
        $queryPengunjung = $this->db->get();

        $resultPengunjung = $queryPengunjung->result_array();

        // Mengambil total pengunjung
        $this->db->select('COUNT(*) as total_pengunjung');
        $this->db->from('pengunjung');
        $this->db->where('MONTH(waktu)', $bulan);
        $this->db->where('YEAR(waktu)', $tahun);
        $query = $this->db->get();

        $totalPengunjung = ($query->num_rows() > 0) ? $query->row()->total_pengunjung : 0;

        // Menghitung jumlah pengunjung berdasarkan tingkat pendidikan
        $this->db->select('pendidikan, COUNT(*) as total');
        $this->db->from('pengunjung');
        $this->db->where('MONTH(waktu)', $bulan);
        $this->db->where('YEAR(waktu)', $tahun);
        $this->db->group_by('pendidikan');
        $pendidikanQuery = $this->db->get();

        $pendidikanCounts = $pendidikanQuery->result_array();

        // Menghitung jumlah pengunjung berdasarkan jenis kelamin
        $this->db->select('jenis_kelamin, COUNT(*) as total');
        $this->db->from('pengunjung');
        $this->db->where('MONTH(waktu)', $bulan);
        $this->db->where('YEAR(waktu)', $tahun);
        $this->db->group_by('jenis_kelamin');
        $jenisKelaminQuery = $this->db->get();

        $jenisKelaminCounts = $jenisKelaminQuery->result_array();

        // Mengembalikan hasil dalam array
        return [
                'dataPengunjung' => $resultPengunjung,
                'total_pengunjung' => $totalPengunjung,
                'pendidikan' => $pendidikanCounts,
                'jenis_kelamin' => $jenisKelaminCounts
            ];
    }

    public function get_pengunjung_by_pendidikan() {
        $this->db->select('pendidikan, COUNT(*) as total');
        $this->db->group_by('pendidikan');
        return $this->db->get('pengunjung')->result();
    }

    public function get_pengunjung_by_gender() {
        $this->db->select('jenis_kelamin, COUNT(*) as total');
        $this->db->group_by('jenis_kelamin');
        return $this->db->get('pengunjung')->result();
    }


    
    
}
