<?php
class User_model extends CI_Model
{
    public function get_all_users()
    {
        $query = $this->db->get('users');
        return $query->result_array();  // Mengembalikan data sebagai array
    }
    public function insert_user($data)
    {
        return $this->db->insert('users', $data);  // Melakukan insert ke tabel 'users'
    }
    public function update_user($id_user, $data)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->update('users', $data);
    }

    // Metode untuk menghapus data pengguna
    public function delete_user($id)
    {
        $this->db->where('id_user', $id);
        $this->db->delete('users'); // Sesuaikan dengan nama tabel di database kamu
    }

    public function get_user_by_username($username) 
    {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->row_array(); // Mengembalikan 1 baris hasil
    }
}
