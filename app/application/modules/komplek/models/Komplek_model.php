<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Komplek_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // Ambil data komplek berdasarkan ID atau semua data
    public function get_komplek($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('komplek_id', $params['id']);
        }

        if (isset($params['komplek_name'])) {
            $this->db->like('komplek_name', $params['komplek_name']);
        }

        if (isset($params['limit'])) {
            $this->db->limit($params['limit'], isset($params['offset']) ? $params['offset'] : NULL);
        }

        $this->db->order_by('komplek_name', 'ASC');
        $query = $this->db->get('komplek');

        if (isset($params['id'])) {
            return $query->row_array();
        } else {
            return $query->result_array();
        }
    }

    // Menambahkan atau memperbarui komplek
    public function add_komplek($data = array()) {
        if (isset($data['komplek_id'])) {
            $this->db->where('komplek_id', $data['komplek_id']);
            $this->db->update('komplek', $data);
            return $data['komplek_id'];
        } else {
            $this->db->insert('komplek', $data);
            return $this->db->insert_id();
        }
    }

    public function get_kamar_by_komplek($komplek_id) {
        $this->db->select('majors.majors_id, majors.majors_name, komplek.komplek_name');
        $this->db->from('majors');
        $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left');
        $this->db->where('majors.komplek_id', $komplek_id);
        return $this->db->get()->result_array();
    }
    public function get_komplek_with_kamar_count() {
        $this->db->select('komplek.komplek_id, komplek.komplek_name, COUNT(majors.majors_id) as jumlah_kamar');
        $this->db->from('komplek');
        $this->db->join('majors', 'majors.komplek_id = komplek.komplek_id', 'left');
        $this->db->group_by('komplek.komplek_id');
        $this->db->order_by('komplek.komplek_name', 'ASC');
        return $this->db->get()->result_array();
    }
    
    

    // Menghapus komplek berdasarkan ID
    public function delete_komplek($id) {
        $this->db->where('komplek_id', $id);
        $this->db->delete('komplek');
    }
}
