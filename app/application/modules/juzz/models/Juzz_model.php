<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Juzz_model extends CI_Model {

    // Mendapatkan semua data kelas
    public function get_all() {
        $this->db->select('juzz.*, ustadz.ustadz_nama AS wali_kelas');
        $this->db->from('juzz');
        $this->db->join('ustadz', 'ustadz.ustadz_id = juzz.wali_kelas_id', 'left'); // LEFT JOIN agar tetap tampil meskipun tidak ada wali kelas
        return $this->db->get()->result_array();
    }
    
    public function get_all_juzzes() {
        $this->db->select('*');
        $this->db->from('juzz');
        return $this->db->get()->result_array();
    }
    
    // Mendapatkan kelas berdasarkan ID
    public function get_by_id($juzz_id) {
        $this->db->select('juzz.*, ustadz.ustadz_nama AS wali_kelas');
        $this->db->from('juzz');
        $this->db->join('ustadz', 'ustadz.ustadz_id = juzz.wali_kelas_id', 'left');
        $this->db->where('juzz.juzz_id', $juzz_id);
        return $this->db->get()->row_array();
    }

    function add_juzz($data = array()) {

        if (isset($data['juzz_id'])) {
            $this->db->set('juzz_id', $data['juzz_id']);
        }

        if (isset($data['juzz_name'])) {
            $this->db->set('juzz_name', $data['juzz_name']);
        }

        if (isset($data['juzz_id'])) {
            $this->db->where('juzz_id', $data['juzz_id']);
            $this->db->update('juzz');
            $id = $data['juzz_id'];
        } else {
            $this->db->insert('juzz');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    public function save_juzz($data) {
        if (isset($data['juzz_id'])) {
            // Jika juzz_id ada, lakukan update data kelas
            $this->db->where('juzz_id', $data['juzz_id']);
            return $this->db->update('juzz', $data);
        } else {
            // Jika juzz_id tidak ada, lakukan insert data kelas baru
            return $this->db->insert('juzz', $data);
        }
    }
    
    // Mendapatkan data kelas berdasarkan parameter
public function get($params = []) {
    $this->db->select('juzz.*, ustadz.ustadz_nama AS wali_kelas');
    $this->db->from('juzz');
    $this->db->join('ustadz', 'ustadz.ustadz_id = juzz.wali_kelas_id', 'left');

    if (!empty($params['juzz_id'])) {
        $this->db->where('juzz.juzz_id', $params['juzz_id']);
    }

    if (!empty($params['wali_kelas_id'])) {
        $this->db->where('juzz.wali_kelas_id', $params['wali_kelas_id']);
    }

    // 🔥 Tambahkan filter berdasarkan student_id jika ada
    if (!empty($params['student_id'])) {
        $this->db->join('student', 'student.juzz_juzz_id = juzz.juzz_id', 'left');
        $this->db->where('student.student_id', $params['student_id']);
    }

    return $this->db->get()->row_array();
}

    
}
?>
