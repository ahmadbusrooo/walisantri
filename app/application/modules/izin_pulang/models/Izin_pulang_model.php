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

    public function get_today_izin($limit = 10)
{
    $this->db->select('ip.*, s.student_full_name, c.class_name');
    $this->db->from('izin_pulang ip');
    $this->db->join('student s', 's.student_id = ip.student_id');
    $this->db->join('class c', 'c.class_id = s.class_class_id');
    $this->db->where('ip.tanggal', date('Y-m-d'));
    $this->db->or_where('ip.tanggal_akhir', date('Y-m-d'));
    $this->db->order_by('ip.tanggal', 'DESC');
    $this->db->limit($limit);
    return $this->db->get()->result_array();
}


     public function get_by_id($id)
    {
        $this->db->where('izin_id', $id);
        return $this->db->get('izin_pulang')->row_array();
    }


    public function add($data)
    {
        // Hitung jumlah hari otomatis
        $start = new DateTime($data['tanggal']);
        $end = new DateTime($data['tanggal_akhir']);
        $data['jumlah_hari'] = $end->diff($start)->days + 1; // +1 untuk include hari pertama
        $data['tanggal'] = $data['tanggal'];

        $this->db->insert('izin_pulang', $data);
        return $this->db->insert_id();
    }

    public function update_status($izin_id, $status)
    {
        $this->db->where('izin_id', $izin_id);
        $this->db->update('izin_pulang', ['status' => $status]);
        return $this->db->affected_rows();
    }


    // Di file models/Izin_pulang_model.php - fungsi get_top_izen()

    public function get_top_izin($period_id, $limit = 10)
    {
        $this->db->select([
            's.student_id',
            's.student_address',
            's.student_full_name',
            'c.class_name',
            'COUNT(ip.izin_id) as total_izin',
            'SUM(ip.jumlah_hari) as total_hari',
            'SUM(CASE WHEN ip.status = "Terlambat" THEN 1 ELSE 0 END) as total_telat'
        ]);

        $this->db->from('izin_pulang ip');
        $this->db->join('student s', 's.student_id = ip.student_id');
        $this->db->join('class c', 'c.class_id = s.class_class_id');

        $this->db->where('ip.period_id', $period_id);
        $this->db->group_by('s.student_id');
        $this->db->order_by('total_hari', 'DESC');
        $this->db->limit($limit);

        return $this->db->get()->result_array();
    }

    // Total hari per periode DAN santri tertentu
    public function get_total_days_by_period($period_id, $student_id)
    {
        $this->db->select_sum('jumlah_hari', 'total_days');
        $this->db->where('period_id', $period_id);
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('izin_pulang');
        return $query->row()->total_days ? $query->row()->total_days : 0;
    }

    // Total hari per bulan, per periode DAN santri tertentu
    public function get_monthly_days_by_period($period_id, $student_id)
    {
        $this->db->select('MONTH(tanggal) as month, SUM(jumlah_hari) as total_days');
        $this->db->where('period_id', $period_id);
        $this->db->where('student_id', $student_id);
        $this->db->group_by('MONTH(tanggal)');
        $query = $this->db->get('izin_pulang');
        return $query->result_array();
    }

    // Hapus data izin pulang
    public function delete($id)
    {
        $this->db->where('izin_id', $id);
        $this->db->delete('izin_pulang');
    }
}
