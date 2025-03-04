<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kitab extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('kitab/Kitab_model');
    }

    public function index()
    {
        $data['kitab'] = $this->Kitab_model->get();
        $data['title'] = 'Data Kitab';
        $data['main'] = 'kitab/kitab_list'; // View di modul
        $this->load->view('manage/layout', $data);
    }

    public function add()
    {
        if ($_POST) {
            $data = [
                'nama_kitab' => $this->input->post('nama_kitab', TRUE),
                'target' => $this->input->post('target', TRUE),
            ];
            $this->Kitab_model->add($data);
            $this->session->set_flashdata('success', 'Kitab berhasil ditambahkan.');
            redirect('kitab');
        }
    }

    public function edit($id = NULL)
    {
        if ($id === NULL || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'ID Kitab tidak valid.');
            redirect('kitab');
        }

        if ($_POST) {
            $data = [
                'nama_kitab' => $this->input->post('nama_kitab', TRUE),
                'target' => $this->input->post('target', TRUE),
            ];
            $this->Kitab_model->update($data, $id);
            $this->session->set_flashdata('success', 'Kitab berhasil diperbarui.');
            redirect('kitab');
        } else {
            $data['kitab'] = $this->Kitab_model->get(['kitab_id' => $id]);
            if (empty($data['kitab'])) {
                $this->session->set_flashdata('error', 'Kitab tidak ditemukan.');
                redirect('kitab');
            }
            $data['title'] = 'Edit Kitab';
            $data['main'] = 'kitab/kitab_edit';
            $this->load->view('manage/layout', $data);
        }
    }

    public function delete($kitab_id)
    {
        if ($this->Kitab_model->delete($kitab_id)) {
            $this->session->set_flashdata('success', 'Kitab berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Kitab gagal dihapus. Data ini masih digunakan di tabel lain.');
        }
        redirect('kitab');
    }
    
}
