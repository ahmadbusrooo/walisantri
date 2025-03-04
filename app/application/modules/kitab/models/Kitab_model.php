<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitab_model extends CI_Model
{
    public function get($params = [])
    {
        if (isset($params['kitab_id'])) {
            $this->db->where('kitab_id', $params['kitab_id']);
        }
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by']['column'], $params['order_by']['direction']);
        } else {
            $this->db->order_by('nama_kitab', 'ASC');
        }
        $query = $this->db->get('kitab');
        return isset($params['kitab_id']) ? $query->row_array() : $query->result_array();
    }

    public function add($data)
    {
        $this->db->insert('kitab', $data);
        return $this->db->insert_id();
    }

    public function update($data, $id)
    {
        $this->db->where('kitab_id', $id);
        $this->db->update('kitab', $data);
        return $this->db->affected_rows();
    }

    public function delete($kitab_id)
    {
        // Periksa apakah kitab sedang digunakan di tabel class_kitab
        $this->db->where('kitab_id', $kitab_id);
        $query = $this->db->get('class_kitab');
        if ($query->num_rows() > 0) {
            return false; // Tidak dapat menghapus karena masih digunakan
        }
    
        // Hapus data di tabel kitab
        $this->db->where('kitab_id', $kitab_id);
        $this->db->delete('kitab');
    
        // Periksa apakah penghapusan berhasil
        return $this->db->affected_rows() > 0;
    }
    

    public function get_target($kitab_id)
    {
        return $this->db->get_where('kitab', ['kitab_id' => $kitab_id])->row_array();
    }

    public function is_unique_name($nama_kitab, $exclude_id = null)
    {
        $this->db->where('nama_kitab', $nama_kitab);
        if ($exclude_id) {
            $this->db->where('kitab_id !=', $exclude_id);
        }
        $query = $this->db->get('kitab');
        return $query->num_rows() == 0;
    }

    public function get_by_target($min_target = 0, $max_target = null)
    {
        $this->db->where('target >=', $min_target);
        if (!is_null($max_target)) {
            $this->db->where('target <=', $max_target);
        }
        $this->db->order_by('target', 'ASC');
        return $this->db->get('kitab')->result_array();
    }

    public function count_by_target($min_target = 0, $max_target = null)
    {
        $this->db->where('target >=', $min_target);
        if (!is_null($max_target)) {
            $this->db->where('target <=', $max_target);
        }
        return $this->db->count_all_results('kitab');
    }

    public function batch_update($data)
    {
        $this->db->update_batch('kitab', $data, 'kitab_id');
    }

    public function get_unfinished_kitab($student_id)
    {
        $this->db->select('k.*');
        $this->db->from('kitab k');
        $this->db->join('nadzhaman n', 'n.kitab_id = k.kitab_id', 'left');
        $this->db->where('n.student_id', $student_id);
        $this->db->where('n.status !=', 'Khatam');
        return $this->db->get()->result_array();
    }
}
