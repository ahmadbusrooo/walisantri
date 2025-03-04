<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Health_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get health records
     * 
     * @param array $params
     * @return array|object
     */
    public function get($params = [])
    {
        if (isset($params['health_record_id'])) {
            $this->db->where('health_record_id', $params['health_record_id']);
        }
    
        if (isset($params['student_id'])) {
            $this->db->where('student_id', $params['student_id']);
        }
    
        if (isset($params['period_id'])) {
            $this->db->where('period_id', $params['period_id']);
        }
    
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get('health_records');
        return isset($params['health_record_id']) ? $query->row_array() : $query->result_array();
    }
    

    /**
     * Get health records by student_id
     * 
     * @param int $student_id
     * @return array
     */
    public function get_by_student($student_id)
{
    if (empty($student_id)) {
        return [];
    }

    return $this->db->select('health_records.*, student.student_full_name')
        ->from('health_records')
        ->join('student', 'health_records.student_id = student.student_id', 'left')
        ->where('health_records.student_id', $student_id)
        ->order_by('health_records.tanggal', 'DESC')
        ->get()
        ->result_array();
}



    public function get_nis($student_id)
    {
        $this->db->select('student_nis');
        $this->db->from('student');
        $this->db->where('student_id', $student_id);
        $result = $this->db->get()->row_array();
    
        return $result ? $result['student_nis'] : null;
    }
    
    
    
    /**
     * Add new health record
     * 
     * @param array $data
     * @return int Insert ID
     */
    public function add($data)
    {
        if (empty($data['student_id']) || empty($data['period_id']) || empty($data['tanggal'])) {
            return false;
        }
    
        $this->db->insert('health_records', $data);
        return $this->db->insert_id();
    }
    
    public function update($data, $id)
    {
        if (empty($data) || empty($id)) {
            return false;
        }
    
        $this->db->where('health_record_id', $id);
        $this->db->update('health_records', $data);
        return $this->db->affected_rows();
    }
    

    /**
     * Delete health record
     * 
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        if (empty($id)) {
            return false;
        }
    
        $record = $this->get(['health_record_id' => $id]);
        if (!$record) {
            return false; // Jika data tidak ditemukan, return false
        }
    
        $this->db->where('health_record_id', $id);
        $this->db->delete('health_records');
        return $this->db->affected_rows() > 0;
    }
    
}
