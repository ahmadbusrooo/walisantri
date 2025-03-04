<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Izin_pulang_model extends CI_Model
{
    // Ambil data izin pulang berdasarkan ID santri dan periode
    public function get_by_student_period($student_id, $period_id)
    {
        $this->db->select('*');
        $this->db->from('izin_pulang');
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Tambah data izin pulang
    public function add($data)
    {
        $this->db->insert('izin_pulang', $data);
    }

    public function get_total_days_by_period($period_id)
{
    $this->db->select_sum('jumlah_hari', 'total_days');
    $this->db->where('period_id', $period_id);
    $query = $this->db->get('izin_pulang');
    return $query->row()->total_days ? $query->row()->total_days : 0; // Jika tidak ada data, kembalikan 0
}

public function get_monthly_days_by_period($period_id)
{
    $this->db->select('MONTH(tanggal) as month, SUM(jumlah_hari) as total_days');
    $this->db->where('period_id', $period_id);
    $this->db->group_by('MONTH(tanggal)');
    $this->db->order_by('MONTH(tanggal)', 'ASC');
    $query = $this->db->get('izin_pulang');
    return $query->result_array(); // Mengembalikan total hari per bulan
}


    // Hapus data izin pulang
    public function delete($id)
    {
        $this->db->where('izin_id', $id); // Ganti izin_pulang_id dengan izin_id
        $this->db->delete('izin_pulang');
    }
    
}
