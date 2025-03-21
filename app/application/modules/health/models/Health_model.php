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
        $data['status'] = 'Masih Sakit';
    
        if ($this->db->insert('health_records', $data)) {
            return $this->db->insert_id();
        }
        return false;
        
    }
    
    public function update($data, $id)
    {
        if (empty($data) || empty($id)) {
            return false;
        }
        if (isset($data['status']) && $data['status'] == 'Sudah Sembuh') {
            $data['tanggal_sembuh'] = date('Y-m-d');
        }
        
        $this->db->where('health_record_id', $id);
        $this->db->update('health_records', $data);
        return $this->db->affected_rows();
    }
    public function get_current_sick()
    {
        $this->db->select('health_records.*, student.student_nis, student.student_full_name, class.class_name, student.class_class_id, majors.majors_name, student.majors_majors_id');  
        $this->db->join('student', 'health_records.student_id = student.student_id');
        $this->db->join('class', 'student.class_class_id = class.class_id');
        $this->db->join('majors', 'student.majors_majors_id = majors.majors_id');
        $this->db->where('health_records.status', 'Masih Sakit');
        $this->db->where('health_records.tanggal <=', date('Y-m-d')); // Tanggal mulai sakit <= hari ini
        $this->db->where('health_records.tanggal_sembuh IS NULL'); // Belum ada tanggal sembuh
        return $this->db->get('health_records')->result_array();
    }

public function get_top_sick()
{
    $active_period = $this->Period_model->get_active_period();
    
    $this->db->select('student.student_id, student.student_full_name, student.student_address, class.class_name, COUNT(health_records.health_record_id) as total_sakit');
    $this->db->join('student', 'health_records.student_id = student.student_id');
    $this->db->join('class', 'student.class_class_id = class.class_id');
    $this->db->where('health_records.period_id', $active_period['period_id']);
    $this->db->group_by('student.student_id');
    $this->db->order_by('total_sakit', 'DESC');
    $this->db->limit(10);
    return $this->db->get('health_records')->result_array();
}

public function get_last_sickness($student_id)
{
    $this->db->select('kondisi_kesehatan');
    $this->db->where('student_id', $student_id);
    $this->db->order_by('tanggal', 'DESC');
    $this->db->limit(1);
    $result = $this->db->get('health_records')->row_array();
    return $result ? $result['kondisi_kesehatan'] : '-';
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
