<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus_model extends CI_Model {

    private $table = 'pengurus';

    public function __construct() {
        parent::__construct();
    }

    // Ambil semua data pengurus
    public function get_all_pengurus() {
        return $this->db->get($this->table)->result_array();
    }

    // Ambil data pengurus berdasarkan ID
    public function get_pengurus_by_id($id) {
        return $this->db->get_where($this->table, ['pengurus_id' => $id])->row_array();
    }

    public function get_pengurus_by_ids($pengurus_ids) {
        $this->db->where_in('pengurus_id', $pengurus_ids);
        $query = $this->db->get($this->table);
        return $query->result_array();
    }
    
    // Ambil nomor telepon hanya untuk pengurus aktif
public function get_active_pengurus_phones($pengurus_ids) {
    $this->db->select('pengurus_telepon');
    $this->db->where_in('pengurus_id', $pengurus_ids);
    $this->db->where('pengurus_status', 1); // Hanya pengurus aktif
    $query = $this->db->get($this->table);

    $phones = [];
    foreach ($query->result_array() as $row) {
        if (!empty($row['pengurus_telepon'])) {
            $phones[] = $row['pengurus_telepon'];
        }
    }
    return $phones;
}
public function get_total_active_pengurus() {
    $this->db->where('pengurus_status', 1); // Hanya pengurus dengan status aktif
    return $this->db->count_all_results($this->table);
}


// Ambil data pengurus yang aktif
public function get_active_pengurus_by_ids($pengurus_ids) {
    $this->db->where_in('pengurus_id', $pengurus_ids);
    $this->db->where('pengurus_status', 1); // Hanya pengurus aktif
    $query = $this->db->get($this->table);
    return $query->result_array();
}

    // Ambil nomor telepon pengurus berdasarkan daftar ID
    public function get_pengurus_phones($pengurus_ids) {
        $this->db->select('pengurus_telepon');
        $this->db->where_in('pengurus_id', $pengurus_ids);
        $query = $this->db->get($this->table);

        $phones = [];
        foreach ($query->result_array() as $row) {
            if (!empty($row['pengurus_telepon'])) {
                $phones[] = $row['pengurus_telepon'];
            }
        }
        return $phones;
    }

    // Tambah atau edit data pengurus
    public function save_pengurus($data) {
        if (!isset($data['pengurus_id'])) {
            $this->db->where('pengurus_nik', $data['pengurus_nik']);
            $existing = $this->db->get($this->table)->row_array();

            if ($existing) {
                return ['status' => 'error', 'message' => 'NIK sudah terdaftar.'];
            }

            return $this->db->insert($this->table, $data);
        } else {
            $this->db->where('pengurus_nik', $data['pengurus_nik']);
            $this->db->where('pengurus_id !=', $data['pengurus_id']);
            $existing = $this->db->get($this->table)->row_array();

            if ($existing) {
                return ['status' => 'error', 'message' => 'NIK sudah digunakan oleh pengurus lain.'];
            }

            $this->db->where('pengurus_id', $data['pengurus_id']);
            return $this->db->update($this->table, $data);
        }
    }

    // Hapus pengurus
    public function delete_pengurus($id) {
        return $this->db->delete($this->table, ['pengurus_id' => $id]);
    }
}
?>
