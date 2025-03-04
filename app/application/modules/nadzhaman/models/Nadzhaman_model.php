<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nadzhaman_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get data Nadzhaman
     *
     * @param array $params
     * @return array|object
     */
    public function get($params = [])
    {
        $this->db->select('nadzhaman.*, kitab.nama_kitab, nadzhaman.status');
        $this->db->from('nadzhaman');
        $this->db->join('kitab', 'nadzhaman.kitab_id = kitab.kitab_id', 'left');
    
        if (isset($params['student_id'])) {
            $this->db->where('nadzhaman.student_id', $params['student_id']);
        }
        if (isset($params['kitab_id'])) {
            $this->db->where('nadzhaman.kitab_id', $params['kitab_id']);
        }
        if (isset($params['period_id'])) {
            $this->db->where('nadzhaman.period_id', $params['period_id']);
        }
        if (isset($params['nadzhaman_id'])) {
            $this->db->where('nadzhaman.nadzhaman_id', $params['nadzhaman_id']);
        }
    
        $this->db->order_by('nadzhaman.tanggal', 'DESC');
    
        $query = $this->db->get();
    
        if (isset($params['nadzhaman_id'])) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }
    

    /**
     * Get data Nadzhaman by student_id
     *
     * @param int $student_id
     * @return array
     */
    public function get_by_student($student_id)
    {
        if (empty($student_id)) {
            return [];
        }

        return $this->db->select('nadzhaman.*, kitab.nama_kitab')
            ->from('nadzhaman')
            ->join('kitab', 'kitab.kitab_id = nadzhaman.kitab_id', 'left')
            ->where('nadzhaman.student_id', $student_id)
            ->order_by('tanggal', 'DESC')
            ->get()
            ->result_array();
    }

    /**
     * Add new Nadzhaman record
     *
     * @param array $data
     * @return int
     */
    public function add($data)
    {
        $this->db->insert('nadzhaman', $data);
        return $this->db->insert_id();
    }

    /**
     * Update Nadzhaman record
     *
     * @param array $data
     * @param int $id
     * @return int
     */
    public function update($data, $id)
    {
        $this->db->where('nadzhaman_id', $id);
        $this->db->update('nadzhaman', $data);
        return $this->db->affected_rows();
    }

    /**
     * Delete Nadzhaman record
     *
     * @param int $id
     * @return bool
     */
    public function delete($id)
    {
        $this->db->where('nadzhaman_id', $id);
        $this->db->delete('nadzhaman');
        return $this->db->affected_rows() > 0;
    }

    /**
     * Count total Nadzhaman records by student
     *
     * @param int $student_id
     * @return int
     */
    public function count_by_student($student_id)
    {
        $this->db->where('student_id', $student_id);
        return $this->db->count_all_results('nadzhaman');
    }

    public function update_status($student_id, $kitab_id, $period_id)
{
    $this->db->select_sum('jumlah_hafalan');
    $this->db->where('student_id', $student_id);
    $this->db->where('kitab_id', $kitab_id);
    $this->db->where('period_id', $period_id);
    $total_hafalan = $this->db->get('nadzhaman')->row()->jumlah_hafalan;

    // Ambil target hafalan kitab
    $this->db->select('target');
    $this->db->where('kitab_id', $kitab_id);
    $target_hafalan = $this->db->get('kitab')->row()->target;

    // Update status
    $status = ($total_hafalan >= $target_hafalan) ? 'Khatam' : 'Belum Khatam';
    $this->db->where('student_id', $student_id);
    $this->db->where('kitab_id', $kitab_id);
    $this->db->where('period_id', $period_id);
    $this->db->update('nadzhaman', ['status' => $status]);
}


    public function check_and_update_status($student_id, $kitab_id, $period_id) {
        // Dapatkan target hafalan dari kitab
        $this->db->select('target');
        $this->db->from('kitab');
        $this->db->where('kitab_id', $kitab_id);
        $target = $this->db->get()->row_array();
    
        if ($target) {
            $target_hafalan = $target['target'];
    
            // Hitung total hafalan siswa untuk kitab tersebut di periode yang sama
            $this->db->select_sum('jumlah_hafalan');
            $this->db->from('nadzhaman');
            $this->db->where('student_id', $student_id);
            $this->db->where('kitab_id', $kitab_id);
            $this->db->where('period_id', $period_id);
            $total_hafalan = $this->db->get()->row_array();
    
            if ($total_hafalan && $total_hafalan['jumlah_hafalan'] >= $target_hafalan) {
                // Perbarui status menjadi "Khatam"
                $this->db->where('student_id', $student_id);
                $this->db->where('kitab_id', $kitab_id);
                $this->db->where('period_id', $period_id);
                $this->db->update('nadzhaman', ['status' => 'Khatam']);
            }
        }
    }
    

    /**
     * Check target hafalan for a kitab
     *
     * @param int $student_id
     * @param int $kitab_id
     * @return void
     */
    public function check_target($student_id, $kitab_id)
    {
        // Get total hafalan and target
        $this->db->select('SUM(nadzhaman.jumlah_hafalan) AS total_hafalan, kitab.target');
        $this->db->from('nadzhaman');
        $this->db->join('kitab', 'kitab.kitab_id = nadzhaman.kitab_id');
        $this->db->where('nadzhaman.student_id', $student_id);
        $this->db->where('nadzhaman.kitab_id', $kitab_id);
        $result = $this->db->get()->row_array();

        // Check if target is reached
        if ($result['total_hafalan'] >= $result['target']) {
            $this->db->where('student_id', $student_id);
            $this->db->where('kitab_id', $kitab_id);
            $this->db->update('nadzhaman', ['status' => 'Khatam']);
        }
    }


    public function get_total_hafalan_by_period($student_id, $period_id)
{
    $this->db->select('SUM(jumlah_hafalan) as total_hafalan');
    $this->db->from('nadzhaman');
    $this->db->where('student_id', $student_id);
    $this->db->where('period_id', $period_id);
    $result = $this->db->get()->row_array();
    return isset($result['total_hafalan']) ? $result['total_hafalan'] : 0;
}


public function get_monthly_hafalan($student_id, $period_id)
{
    $this->db->select('MONTH(tanggal) as bulan, SUM(jumlah_hafalan) as total_hafalan');
    $this->db->from('nadzhaman');
    $this->db->where('student_id', $student_id);
    $this->db->where('period_id', $period_id);
    $this->db->group_by('MONTH(tanggal)');
    $this->db->order_by('MONTH(tanggal)', 'ASC');
    return $this->db->get()->result_array();
}
public function get_yearly_hafalan($student_id)
{
    $this->db->select('YEAR(tanggal) as tahun, SUM(jumlah_hafalan) as total_hafalan');
    $this->db->from('nadzhaman');
    $this->db->where('student_id', $student_id);
    $this->db->group_by('YEAR(tanggal)');
    $this->db->order_by('YEAR(tanggal)', 'ASC');
    return $this->db->get()->result_array();
}

}
