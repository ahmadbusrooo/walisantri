<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen_setoran_model extends CI_Model {

    public function get_by_student($student_id, $period_id) {
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id);
        $this->db->order_by('tanggal_mulai', 'DESC');
        return $this->db->get('absen_setoran')->result_array();
    }
    // Absen_setoran_model.php
public function get_by_id($id) {
    $this->db->where('setoran_id', $id);
    return $this->db->get('absen_setoran')->row_array();
}

    public function add($data) {
        // Hitung jumlah hari
        $start = new DateTime($data['tanggal_mulai']);
        $end = new DateTime($data['tanggal_selesai']);
        
        $this->db->insert('absen_setoran', $data);
        return $this->db->insert_id();
    }

    public function delete($id) {
        $this->db->where('setoran_id', $id);
        return $this->db->delete('absen_setoran');
    }

    public function get_total_absen($student_id, $period_id) {
        $this->db->select_sum('jumlah_tidak_setoran');
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id);
        $result = $this->db->get('absen_setoran')->row();
        return (!empty($result->jumlah_tidak_setoran)) ? $result->jumlah_tidak_setoran : 0;
    }
    
    public function get_top_absent($period_id, $limit = 10) {
        $this->db->select('s.student_nis, s.student_full_name, c.class_name, SUM(a.jumlah_tidak_setoran) as total');
        $this->db->from('absen_setoran a');
        $this->db->join('student s', 'a.student_id = s.student_id');
        $this->db->join('class c', 's.class_class_id = c.class_id', 'left'); // Sesuaikan disini
        $this->db->where('a.period_id', $period_id);
        $this->db->group_by('a.student_id');
        $this->db->order_by('total', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }
}