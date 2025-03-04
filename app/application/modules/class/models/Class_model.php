<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Class_model extends CI_Model {

    // Mendapatkan semua data kelas
    public function get_all() {
        $this->db->select('class.*, ustadz.ustadz_nama AS wali_kelas');
        $this->db->from('class');
        $this->db->join('ustadz', 'ustadz.ustadz_id = class.wali_kelas_id', 'left'); // LEFT JOIN agar tetap tampil meskipun tidak ada wali kelas
        return $this->db->get()->result_array();
    }
    
    public function get_all_classes() {
        $this->db->select('*');
        $this->db->from('class');
        return $this->db->get()->result_array();
    }
    
    // Mendapatkan kelas berdasarkan ID
    public function get_by_id($class_id) {
        $this->db->select('class.*, ustadz.ustadz_nama AS wali_kelas');
        $this->db->from('class');
        $this->db->join('ustadz', 'ustadz.ustadz_id = class.wali_kelas_id', 'left');
        $this->db->where('class.class_id', $class_id);
        return $this->db->get()->row_array();
    }

    function add_class($data = array()) {

        if (isset($data['class_id'])) {
            $this->db->set('class_id', $data['class_id']);
        }

        if (isset($data['class_name'])) {
            $this->db->set('class_name', $data['class_name']);
        }

        if (isset($data['class_id'])) {
            $this->db->where('class_id', $data['class_id']);
            $this->db->update('class');
            $id = $data['class_id'];
        } else {
            $this->db->insert('class');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    public function save_class($data) {
        if (isset($data['class_id'])) {
            // Jika class_id ada, lakukan update data kelas
            $this->db->where('class_id', $data['class_id']);
            return $this->db->update('class', $data);
        } else {
            // Jika class_id tidak ada, lakukan insert data kelas baru
            return $this->db->insert('class', $data);
        }
    }
    
    // Mendapatkan data kelas berdasarkan parameter
public function get($params = []) {
    $this->db->select('class.*, ustadz.ustadz_nama AS wali_kelas');
    $this->db->from('class');
    $this->db->join('ustadz', 'ustadz.ustadz_id = class.wali_kelas_id', 'left');

    if (!empty($params['class_id'])) {
        $this->db->where('class.class_id', $params['class_id']);
    }

    if (!empty($params['wali_kelas_id'])) {
        $this->db->where('class.wali_kelas_id', $params['wali_kelas_id']);
    }

    // 🔥 Tambahkan filter berdasarkan student_id jika ada
    if (!empty($params['student_id'])) {
        $this->db->join('student', 'student.class_class_id = class.class_id', 'left');
        $this->db->where('student.student_id', $params['student_id']);
    }

    return $this->db->get()->row_array();
}

    
}
?>
