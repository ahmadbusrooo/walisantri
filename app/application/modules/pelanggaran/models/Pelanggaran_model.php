<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pelanggaran_model extends CI_Model {

    // Ambil data pelanggaran berdasarkan ID santri
    public function get_by_student($student_id) {
        $this->db->select('*');
        $this->db->from('pelanggaran');
        $this->db->where('student_id', $student_id);
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function get_monthly_violations($student_id, $period_id)
{
    $this->db->select('MONTH(tanggal) as month, SUM(poin) as total_points');
    $this->db->where('student_id', $student_id);
    $this->db->where('period_id', $period_id);
    $this->db->group_by('MONTH(tanggal)');
    $this->db->order_by('MONTH(tanggal)', 'ASC');
    $query = $this->db->get('pelanggaran');
    return $query->result_array(); // Mengembalikan array dengan total poin per bulan
}

public function get_top_violators($month, $year, $limit = 5)
{
    $this->db->select('s.student_id, s.student_full_name, SUM(p.poin) as total_points');
    $this->db->from('pelanggaran p');
    $this->db->join('student s', 'p.student_id = s.student_id');
    $this->db->where('MONTH(p.tanggal)', $month);
    $this->db->where('YEAR(p.tanggal)', $year);
    $this->db->group_by('p.student_id');
    $this->db->order_by('total_points', 'DESC');
    $this->db->limit($limit); // Batas jumlah santri yang ditampilkan
    $query = $this->db->get();
    return $query->result_array();
}

public function get_yearly_violations($student_id, $period_id)
{
    $this->db->select('SUM(poin) as total_points');
    $this->db->where('student_id', $student_id);
    $this->db->where('period_id', $period_id);
    $query = $this->db->get('pelanggaran');
    return isset($query->row()->total_points) ? $query->row()->total_points : 0; // Jika tidak ada pelanggaran, kembalikan 0
}


    // Ambil data pelanggaran berdasarkan ID santri dan periode
    public function get_by_student_period($student_id, $period_id) {
        $this->db->select('*');
        $this->db->from('pelanggaran');
        $this->db->where('student_id', $student_id);
        $this->db->where('period_id', $period_id); // Filter berdasarkan periode
        $this->db->order_by('tanggal', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }

    // Tambah data pelanggaran
    public function add($data) {
        $this->db->insert('pelanggaran', $data);
    }

    // Ambil data pelanggaran berdasarkan ID
    public function get_by_id($id) {
        $this->db->where('pelanggaran_id', $id);
        $query = $this->db->get('pelanggaran');
        return $query->row_array();
    }
    public function get_violations_by_month($student_id, $year)
{
    $this->db->select("MONTH(tanggal) as month, SUM(poin) as total_points");
    $this->db->where('student_id', $student_id);
    $this->db->where('YEAR(tanggal)', $year);
    $this->db->group_by("MONTH(tanggal)");
    $this->db->order_by("MONTH(tanggal)", "ASC");
    $query = $this->db->get('pelanggaran');
    return $query->result_array(); // Mengembalikan data dalam bentuk array
}
public function get_total_violations_by_year($student_id, $year)
{
    $this->db->select_sum('poin', 'total_points');
    $this->db->where('student_id', $student_id);
    $this->db->where('YEAR(tanggal)', $year);
    $query = $this->db->get('pelanggaran');
    return isset($query->row()->total_points) ? $query->row()->total_points : 0; // Jika tidak ada pelanggaran, kembalikan 0
}


    // Update data pelanggaran
    public function update($data) {
        $this->db->where('pelanggaran_id', $data['pelanggaran_id']);
        $this->db->update('pelanggaran', $data);
    }

    // Hapus data pelanggaran
    public function delete($id) {
        $this->db->where('pelanggaran_id', $id);
        $this->db->delete('pelanggaran');
    }

    // Pencarian santri berdasarkan keyword
    public function search_santri($keyword) {
        $this->db->select('student_id as id, CONCAT(student_nis, " - ", student_full_name) as text');
        $this->db->from('student');
        $this->db->like('student_nis', $keyword);
        $this->db->or_like('student_full_name', $keyword);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_top_violators_active_period($limit = 10) {
        $this->db->select('s.student_id, s.student_full_name, s.student_nis, c.class_name, SUM(p.poin) as total_points');
        $this->db->from('pelanggaran p');
        $this->db->join('student s', 'p.student_id = s.student_id');
        $this->db->join('class c', 's.class_class_id = c.class_id');
        $this->db->join('period pd', 'p.period_id = pd.period_id');
        $this->db->where('pd.period_status', 1); // Hanya periode aktif
        $this->db->group_by('p.student_id');
        $this->db->order_by('total_points', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result_array();
    }
}
