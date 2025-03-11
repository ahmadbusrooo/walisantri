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
public function get_by_id($id) {
    $this->db->where('izin_id', $id);
    return $this->db->get('izin_pulang')->row_array();
}
// Di method add()
public function add($data)
{
    // Hitung jumlah hari otomatis
    $start = new DateTime($data['tanggal']);
    $end = new DateTime($data['tanggal_akhir']);
    $data['jumlah_hari'] = $end->diff($start)->days + 1; // +1 untuk include hari pertama
    $data['tanggal'] = $data['tanggal']; // Simpan tanggal awal di kolom tanggal (jika perlu)
    
    $this->db->insert('izin_pulang', $data);
    return $this->db->insert_id();
}

public function update_status($izin_id, $status)
{
    $this->db->where('izin_id', $izin_id);
    $this->db->update('izin_pulang', ['status' => $status]);
    return $this->db->affected_rows();
}



// Di model Izin_pulang_model:

// Total hari per periode DAN santri tertentu
public function get_total_days_by_period($period_id, $student_id)
{
    $this->db->select_sum('jumlah_hari', 'total_days');
    $this->db->where('period_id', $period_id);
    $this->db->where('student_id', $student_id); // ✅ Tambahkan filter student_id
    $query = $this->db->get('izin_pulang');
    return $query->row()->total_days ? $query->row()->total_days : 0;
}

// Total hari per bulan, per periode DAN santri tertentu
public function get_monthly_days_by_period($period_id, $student_id)
{
    $this->db->select('MONTH(tanggal) as month, SUM(jumlah_hari) as total_days');
    $this->db->where('period_id', $period_id);
    $this->db->where('student_id', $student_id); // ✅ Tambahkan filter student_id
    $this->db->group_by('MONTH(tanggal)');
    $query = $this->db->get('izin_pulang');
    return $query->result_array();
}

    // Hapus data izin pulang
    public function delete($id)
    {
        $this->db->where('izin_id', $id); // Ganti izin_pulang_id dengan izin_id
        $this->db->delete('izin_pulang');
    }
    
}
