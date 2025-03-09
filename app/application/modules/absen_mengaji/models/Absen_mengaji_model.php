<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen_mengaji_model extends CI_Model {

    public function get_by_student($student_id, $period_id) {
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id);
        $this->db->order_by('tanggal_mulai', 'DESC');
        return $this->db->get('absen_mengaji')->result_array();
    }
    // Absen_mengaji_model.php
public function get_by_id($id) {
    $this->db->where('absen_id', $id);
    return $this->db->get('absen_mengaji')->row_array();
}

    public function add($data) {
        // Hitung jumlah hari
        $start = new DateTime($data['tanggal_mulai']);
        $end = new DateTime($data['tanggal_selesai']);
        
        $this->db->insert('absen_mengaji', $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->where('absen_id', $id);
        return $this->db->delete('absen_mengaji');
    }

    public function get_total_absen($student_id, $period_id) {
        $this->db->select_sum('jumlah_absen');
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id);
        $result = $this->db->get('absen_mengaji')->row();
        return (!empty($result->jumlah_absen)) ? $result->jumlah_absen : 0;
    }
    
}