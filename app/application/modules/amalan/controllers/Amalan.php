<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Amalan extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('amalan/Amalan_model');
    }

    public function index() {
        $data['amalan'] = $this->Amalan_model->get_amalan();
        $data['title'] = 'Kelola Kitab';
		$data['main'] = 'amalan/amalan_list';

        $this->load->view('manage/layout', $data);
    }

    public function add() {
        $this->form_validation->set_rules('amalan_title', 'Judul Amalan', 'required');

        if($this->form_validation->run()) {
            $post = $this->input->post();
            $data = [
                'amalan_title' => $post['amalan_title'],
                'amalan_slug' => url_title($post['amalan_title'], '-', TRUE),
                'amalan_publish' => $post['amalan_publish']
            ];
            
            $this->Amalan_model->insert_amalan($data);
            redirect('amalan/amalan');
        }

        $data['title'] = 'Tambah Amalan';
        $data['main'] = 'amalan/amalan_form';
        $this->load->view('manage/layout', $data);
    }

    public function edit($id) {
        $this->form_validation->set_rules('amalan_title', 'Judul Amalan', 'required');

        if($this->form_validation->run()) {
            $post = $this->input->post();
            $data = [
                'amalan_title' => $post['amalan_title'],
                'amalan_slug' => url_title($post['amalan_title'], '-', TRUE),
                'amalan_publish' => $post['amalan_publish']
            ];
            
            $this->Amalan_model->update_amalan($id, $data);
            redirect('amalan/amalan');
        }

        $data['amalan'] = $this->Amalan_model->get_amalan($id);
        $data['title'] = 'Edit Kitab';
        $data['main'] = 'amalan/amalan_form';
        $this->load->view('manage/layout', $data);
    }

    public function delete($id) {
        $this->Amalan_model->delete_amalan($id);
        redirect('amalan/amalan');
    }
}