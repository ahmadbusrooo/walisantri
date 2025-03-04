<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class KitabDikelas_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Menambahkan hubungan antara kelas, kitab, dan periode.
     *
     * @param array $data
     * @return int
     */
    public function add($data) {
        $this->db->insert('class_kitab', $data);
        return $this->db->insert_id();
    }

    /**
     * Menghapus hubungan kitab berdasarkan kelas dan periode.
     *
     * @param int $class_id
     * @param int $period_id
     * @return bool
     */
    public function delete_by_class($class_id, $period_id) {
        $this->db->where('class_id', $class_id);
        $this->db->where('period_id', $period_id);
        $this->db->delete('class_kitab');
        return $this->db->affected_rows() > 0;
    }

    /**
     * Mendapatkan kitab yang terkait dengan kelas dan periode tertentu.
     *
     * @param int $class_id
     * @param int $period_id
     * @return array
     */
    public function get_by_class($class_id, $period_id) {
        $this->db->select('class_kitab.id, class_kitab.class_id, class_kitab.kitab_id, class_kitab.period_id, kitab.nama_kitab');
        $this->db->from('class_kitab');
        $this->db->join('kitab', 'kitab.kitab_id = class_kitab.kitab_id', 'left');
        $this->db->where('class_kitab.class_id', $class_id);
        $this->db->where('class_kitab.period_id', $period_id);
        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan semua hubungan kitab untuk semua kelas dan periode (opsional).
     *
     * @param array $params
     * @return array
     */
    public function get_all($params = []) {
        $this->db->select('class_kitab.id, class_kitab.class_id, class_kitab.kitab_id, class_kitab.period_id, kitab.nama_kitab, class.class_name, period.period_start, period.period_end');
        $this->db->from('class_kitab');
        $this->db->join('kitab', 'kitab.kitab_id = class_kitab.kitab_id', 'left');
        $this->db->join('class', 'class.class_id = class_kitab.class_id', 'left');
        $this->db->join('period', 'period.period_id = class_kitab.period_id', 'left');

        if (!empty($params['class_id'])) {
            $this->db->where('class_kitab.class_id', $params['class_id']);
        }

        if (!empty($params['period_id'])) {
            $this->db->where('class_kitab.period_id', $params['period_id']);
        }

        return $this->db->get()->result_array();
    }

    /**
     * Mendapatkan data class_kitab berdasarkan parameter tertentu.
     *
     * @param array $params
     * @return array
     */
    public function get($params = []) {
        if (!empty($params['class_id'])) {
            $this->db->where('class_id', $params['class_id']);
        }
        if (!empty($params['period_id'])) {
            $this->db->where('period_id', $params['period_id']);
        }
        if (!empty($params['kitab_id'])) {
            $this->db->where('kitab_id', $params['kitab_id']);
        }

        $query = $this->db->get('class_kitab');
        return $query->result_array();
    }
}
