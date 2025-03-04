<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Period_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get period from database
    function get($params = array())
    {
        if(isset($params['id']))
        {
            $this->db->where('period_id', $params['id']);
        }

        if(isset($params['status']))
        {
            $this->db->where('period_status', $params['status']);
        }

        if(isset($params['period_start']))
        {
            $this->db->where('period_start', $params['period_start']);
        }

        if(isset($params['period_end']))
        {
            $this->db->where('period_end', $params['period_end']);
        }

        if(isset($params['is_active']))
        {
            $this->db->where('period_status', 1); // Anggap `period_status` digunakan untuk menandai aktif
        }

        if(isset($params['limit']))
        {
            if(!isset($params['offset']))
            {
                $params['offset'] = NULL;
            }

            $this->db->limit($params['limit'], $params['offset']);
        }

        if(isset($params['order_by']))
        {
            $this->db->order_by($params['order_by'], 'desc');
        }
        else
        {
            $this->db->order_by('period_id', 'desc');
        }

        $this->db->select('period_id, period_start, period_end, period_status');
        $res = $this->db->get('period');

        if(isset($params['id']))
        {
            return $res->row_array();
        }
        else
        {
            return $res->result_array();
        }
    }

    // Mendapatkan semua periode
    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('period'); // Pastikan tabel 'period' ada di database
        return $this->db->get()->result_array();
    }

    // Mendapatkan data periode berdasarkan ID
    public function get_by_id($period_id)
    {
        $this->db->select('*');
        $this->db->from('period');
        $this->db->where('period_id', $period_id);
        return $this->db->get()->row_array();
    }

    // Menambahkan atau memperbarui data ke database
    function add($data = array())
    {
        if(isset($data['period_id']))
        {
            $this->db->set('period_id', $data['period_id']);
        }

        if(isset($data['period_start']))
        {
            $this->db->set('period_start', $data['period_start']);
        }

        if(isset($data['period_end']))
        {
            $this->db->set('period_end', $data['period_end']);
        }

        if(isset($data['period_status']))
        {
            $this->db->set('period_status', $data['period_status']);
        }

        if (isset($data['period_id']))
        {
            $this->db->where('period_id', $data['period_id']);
            $this->db->update('period');
            $id = $data['period_id'];
        }
        else if (isset($data['status_active']))
        {
            $this->db->update('period');
            $id = NULL;
        }
        else
        {
            $this->db->insert('period');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    // Menghapus periode berdasarkan ID
    function delete($id)
    {
        $this->db->where('period_id', $id);
        $this->db->delete('period');
    }

    // Mendapatkan periode aktif
    public function get_active_period()
    {
        $this->db->select('*');
        $this->db->from('period');
        $this->db->where('period_status', 1); // Anggap 'period_status' digunakan untuk menandai aktif
        return $this->db->get()->row_array();
    }
}
