<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ustadz_model extends CI_Model {

    private $table = 'ustadz';

    public function __construct() {
        parent::__construct();
    }

    // Ambil semua data ustadz (dengan opsi filter dan join ke tabel class)
    public function get_all_ustadz($params = array()) {
        $this->db->select('ustadz.*, class.class_name'); // Tambahkan nama kelas
        $this->db->from($this->table);
        $this->db->join('class', 'class.class_id = ustadz.class_id', 'left'); // LEFT JOIN agar ustadz tanpa kelas tetap muncul

        if (!empty($params['search'])) {
            $this->db->like('ustadz.ustadz_nama', $params['search']);
        }

        if (isset($params['status'])) {
            $this->db->where('ustadz.ustadz_status', $params['status']);
        }

        return $this->db->get()->result_array();
    }

    // Ambil data ustadz berdasarkan ID (termasuk nama kelas)
    public function get_ustadz_by_id($id) {
        $this->db->select('ustadz.*, class.class_name');
        $this->db->from($this->table);
        $this->db->join('class', 'class.class_id = ustadz.class_id', 'left');
        $this->db->where('ustadz.ustadz_id', $id);

        return $this->db->get()->row_array();
    }

    // Ambil data ustadz berdasarkan daftar ID yang dipilih
    public function get_ustadz_by_ids($ustadz_ids) {
        $this->db->where_in('ustadz_id', $ustadz_ids);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }

    // Ambil nomor telepon ustadz berdasarkan daftar ID
    public function get_ustadz_phones($ustadz_ids) {
        $this->db->select('ustadz_telepon');
        $this->db->where_in('ustadz_id', $ustadz_ids);
        $query = $this->db->get($this->table);

        $phones = [];
        foreach ($query->result_array() as $row) {
            if (!empty($row['ustadz_telepon'])) {
                $phones[] = $row['ustadz_telepon'];
            }
        }
        return $phones;
    }

    // Tambah atau edit data ustadz (dengan pengecekan NIK)
    public function save_ustadz($data) {
        // Jika sedang menambah data baru, cek apakah NIK sudah ada
        if (!isset($data['ustadz_id'])) {
            $this->db->where('ustadz_nik', $data['ustadz_nik']);
            $existing = $this->db->get($this->table)->row_array();

            if ($existing) {
                return ['status' => 'error', 'message' => 'NIK sudah terdaftar. Gunakan NIK lain.'];
            }

            // Insert data baru jika NIK belum ada
            return $this->db->insert($this->table, $data);
        } else {
            // Jika sedang edit, pastikan NIK tidak duplikat dengan data lain
            $this->db->where('ustadz_nik', $data['ustadz_nik']);
            $this->db->where('ustadz_id !=', $data['ustadz_id']);
            $existing = $this->db->get($this->table)->row_array();

            if ($existing) {
                return ['status' => 'error', 'message' => 'NIK sudah digunakan oleh ustadz lain.'];
            }

            // Lanjut update data jika tidak ada duplikasi
            $this->db->where('ustadz_id', $data['ustadz_id']);
            return $this->db->update($this->table, $data);
        }
    }
    public function get_wali_kelas() {
        $this->db->select('ustadz_id, ustadz_nama');
        $this->db->from('ustadz');
        $this->db->where('ustadz_status', 1); // Misalnya, hanya ustadz aktif yang bisa jadi wali kelas
        return $this->db->get()->result_array();
    }
    
    // Hapus ustadz
    public function delete_ustadz($id) {
        return $this->db->delete($this->table, ['ustadz_id' => $id]);
    }

    // Ambil data ustadz beserta nama kelasnya berdasarkan ID
    public function get_ustadz_with_class($id) {
        $this->db->select('ustadz.*, class.class_name');
        $this->db->from($this->table);
        $this->db->join('class', 'class.class_id = ustadz.class_id', 'left');
        $this->db->where('ustadz.ustadz_id', $id);

        return $this->db->get()->row_array();
    }
}
?>
