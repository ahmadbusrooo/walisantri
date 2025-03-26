<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Isi extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('amalan/Amalan_model');
        $this->load->helper('file');
        $this->load->library('session'); // Pastikan library session di-load
    }

    public function edit($bab_id) {
        $this->form_validation->set_rules('isi_content', 'Konten', 'required');
    
        if($this->form_validation->run()) {
            $data = ['isi_content' => $this->input->post('isi_content')];
            
            // Dapatkan data bab untuk ambil amalan_id
            $bab = $this->Amalan_model->get_single_bab($bab_id); // 👈 Ambil data bab
            
            // FLASH DATA UNTUK SUKSES UPDATE/INSERT
            if($this->Amalan_model->get_isi($bab_id)) {
                $this->Amalan_model->update_isi($bab_id, $data);
                $this->session->set_flashdata('success', 'Isi bab berhasil diperbarui');
            } else {
                $data['bab_id'] = $bab_id;
                $this->Amalan_model->insert_isi($data);
                $this->session->set_flashdata('success', 'Isi bab berhasil ditambahkan');
            }
            
            // Redirect ke amalan/bab/index/amalan_id (sesuai struktur bab)
            redirect('amalan/bab/index/'.$bab['amalan_id']); // 👈 Redirect ke sini
        } else {
            if (validation_errors()) {
                $this->session->set_flashdata('error', validation_errors('<div class="alert alert-danger">', '</div>')); 
            }
        }
    
        $data['isi'] = $this->Amalan_model->get_isi($bab_id);
        $data['bab'] = $this->Amalan_model->get_single_bab($bab_id);
        $data['title'] = 'Edit Isi Bab';
        $data['main'] = 'amalan/isi_form';
        $this->load->view('manage/layout', $data);
    }
}