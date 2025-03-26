<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bab extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('amalan/Amalan_model');
    }

    public function index($amalan_id) {
        $data['bab'] = $this->Amalan_model->get_bab($amalan_id);
        $data['amalan'] = $this->Amalan_model->get_amalan($amalan_id);
        $data['title'] = 'Kelola Bab - '.$data['amalan']['amalan_title'];
        $data['main'] = 'amalan/bab_list';
        $this->load->view('manage/layout', $data);
    }

    public function add($amalan_id) {
        $this->form_validation->set_rules('bab_title', 'Judul Bab', 'required');

        if($this->form_validation->run()) {
            $post = $this->input->post();
            $data = [
                'amalan_id' => $amalan_id,
                'bab_title' => $post['bab_title'],
                'bab_order' => $post['bab_order']
            ];
            
            $this->Amalan_model->insert_bab($data);
            redirect('amalan/bab/index/'.$amalan_id);
        }

        $data['amalan'] = $this->Amalan_model->get_amalan($amalan_id);
        $data['title'] = 'Tambah Bab';
        $data['main'] = 'amalan/bab_form';
        $this->load->view('manage/layout', $data);
    }

    public function edit($bab_id) {
        $this->form_validation->set_rules('bab_title', 'Judul Bab', 'required');
    
        if ($this->form_validation->run()) {
            $post = $this->input->post();
            $data = [
                'bab_title' => $post['bab_title'],
                'bab_order' => $post['bab_order']
            ];
            
            $this->Amalan_model->update_bab($bab_id, $data);
            redirect('amalan/bab/index/'.$post['amalan_id']);
        }
    
        // Ambil data bab
        $data['bab'] = $this->Amalan_model->get_single_bab($bab_id);
    
        // Ambil amalan_id dari data bab
        $amalan_id = $data['bab']['amalan_id']; // Pastikan struktur data bab benar
    
        // Ambil data amalan berdasarkan amalan_id
        $data['amalan'] = $this->Amalan_model->get_amalan($amalan_id); // <-- TAMBAHKAN INI
    
        $data['title'] = 'Edit Bab';
        $data['main'] = 'amalan/bab_form';
        $this->load->view('manage/layout', $data);
    }

    public function delete($bab_id) {
        $bab = $this->Amalan_model->get_single_bab($bab_id);
        $this->Amalan_model->delete_bab($bab_id);
        redirect('amalan/bab/index/'.$bab['amalan_id']);
    }
}