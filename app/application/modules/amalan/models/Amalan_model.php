<?php
class Amalan_model extends CI_Model {

    // AMALAN
    public function get_amalan($id = null) {
        if($id) return $this->db->get_where('amalan', ['amalan_id' => $id])->row_array();
        return $this->db->order_by('created_at', 'DESC')->get('amalan')->result_array();
    }

    public function insert_amalan($data) {
        $this->db->insert('amalan', $data);
        return $this->db->insert_id();
    }

    public function update_amalan($id, $data) {
        $this->db->where('amalan_id', $id);
        return $this->db->update('amalan', $data);
    }

    public function delete_amalan($id) {
        $this->db->where('amalan_id', $id);
        return $this->db->delete('amalan');
    }

    // BAB
    public function get_bab($amalan_id) {
        return $this->db->where('amalan_id', $amalan_id)
                      ->order_by('bab_order', 'ASC')
                      ->get('bab')->result_array();
    }

    public function get_single_bab($bab_id) {
        return $this->db->get_where('bab', ['bab_id' => $bab_id])->row_array();
    }

    public function insert_bab($data) {
        $this->db->insert('bab', $data);
        return $this->db->insert_id();
    }

    public function update_bab($bab_id, $data) {
        $this->db->where('bab_id', $bab_id);
        return $this->db->update('bab', $data);
    }

    public function delete_bab($bab_id) {
        $this->db->where('bab_id', $bab_id);
        return $this->db->delete('bab');
    }

    // ISI BAB
    public function get_isi($bab_id) {
        return $this->db->get_where('isi_bab', ['bab_id' => $bab_id])->row_array();
    }

    public function insert_isi($data) {
        $this->db->insert('isi_bab', $data);
        return $this->db->insert_id();
    }

    public function update_isi($bab_id, $data) {
        $this->db->where('bab_id', $bab_id);
        return $this->db->update('isi_bab', $data);
    }
}