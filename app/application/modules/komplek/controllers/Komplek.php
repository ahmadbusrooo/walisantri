<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Komplek extends  CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    if (majors() != 'senior') {
      redirect('manage');
    }

        $this->load->model('komplek/Komplek_model'); 
        $this->load->model('student/Student_model');
        $this->load->helper(array('form', 'url'));
    }

    // Menampilkan daftar komplek
    public function index() {
        $data['title'] = 'Data Komplek';
        $data['komplek'] = $this->Komplek_model->get_komplek_with_kamar_count();
        $this->load->library('pagination');
        $data['main'] = 'komplek/komplek_list';
        $this->load->view('manage/layout', $data);

    }
    
    public function kamar_by_komplek($komplek_id) {
        // Load model
        $this->load->model('Student_model'); 
    
        // Ambil data kamar dan komplek berdasarkan ID
        $data['kamar'] = $this->Student_model->get_kamar_by_komplek($komplek_id);
        $data['komplek'] = $this->Komplek_model->get_komplek(['id' => $komplek_id]);
    
        // Jika komplek tidak ditemukan, kembalikan ke daftar komplek
        if (!$data['komplek']) {
            $this->session->set_flashdata('error', 'Komplek tidak ditemukan!');
            redirect('komplek');
        }
    
        // Load tampilan daftar kamar
        $data['title'] = 'Data Kamar di ' . $data['komplek']['komplek_name'];
        $this->load->library('pagination');
        $data['main'] = 'komplek/kamar_list';
        $this->load->view('manage/layout', $data);
    }
    
    // Menambah/mengedit komplek
    public function add($id = NULL) {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('komplek_name', 'Nama Komplek', 'trim|required');

        if ($this->form_validation->run() == TRUE) {
            $params = array(
                'komplek_name' => $this->input->post('komplek_name')
            );

            if ($id) {
                $params['komplek_id'] = $id;
            }

            $this->Komplek_model->add_komplek($params);
            $this->session->set_flashdata('success', 'Data Komplek berhasil disimpan');
            redirect('komplek');
        } else {
            $data['title'] = $id ? 'Edit Komplek' : 'Tambah Komplek';
            $data['main'] = 'komplek_form';
            if ($id) {
                $data['komplek'] = $this->Komplek_model->get_komplek(array('id' => $id));
            }
        $this->load->view('manage/layout', $data);
            
        }
    }

    // Hapus komplek
    public function delete($id) {
        $this->Komplek_model->delete_komplek($id);
        $this->session->set_flashdata('success', 'Data Komplek berhasil dihapus');
        redirect('komplek');
    }
    public function add_kamar($komplek_id = NULL)
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('majors_name', 'Nama Kamar', 'trim|required|xss_clean');

    if ($this->form_validation->run() == TRUE) {
        $params['majors_name'] = $this->input->post('majors_name');
        $params['komplek_id'] = $komplek_id;

        $this->Student_model->add_majors($params);
        $this->session->set_flashdata('success', 'Tambah Kamar Berhasil');
        redirect('komplek/kamar/' . $komplek_id);
    } else {
        $this->session->set_flashdata('failed', 'Gagal menambahkan kamar. Pastikan semua kolom diisi.');
        redirect('komplek/kamar/' . $komplek_id);
    }
}

public function add_kamar_glob($komplek_id = NULL)
{
    if ($_POST) {
        $majorsName = $this->input->post('majors_name'); 

        if (!is_array($majorsName)) {
            $this->session->set_flashdata('failed', 'Terjadi kesalahan, data tidak valid.');
            redirect('komplek/kamar/' . $komplek_id);
            return;
        }

        $cpt = count($majorsName);
        for ($i = 0; $i < $cpt; $i++) {
            $params = array(
                'majors_name' => $majorsName[$i],
                'komplek_id' => $komplek_id
            );

            $this->Student_model->add_majors($params);
        }

        $this->session->set_flashdata('success', 'Tambah Kamar Berhasil');
    } else {
        $this->session->set_flashdata('failed', 'Terjadi kesalahan, kamar tidak dapat ditambahkan.');
    }

    redirect('komplek/kamar/' . $komplek_id);
}


public function edit_kamar($majors_id = NULL)
{
    $this->load->library('form_validation');
    $this->form_validation->set_rules('majors_name', 'Nama Kamar', 'trim|required|xss_clean');

    if ($this->form_validation->run() == TRUE) {
        $params['majors_name'] = $this->input->post('majors_name');
        $params['komplek_id'] = $this->input->post('komplek_id');

        $this->Student_model->update_majors($majors_id, $params);
        $this->session->set_flashdata('success', 'Edit Kamar Berhasil');
        redirect('komplek/kamar/' . $params['komplek_id']);
    } else {
        // Ambil data kamar berdasarkan ID
        $data['kamar'] = $this->Student_model->get_majors(['id' => $majors_id]);

        // Ambil data komplek berdasarkan ID dari kamar
        $data['komplek'] = $this->Student_model->get_komplek(['id' => $data['kamar']['komplek_id']]);

        // Jika kamar tidak ditemukan, kembali ke halaman komplek
        if (!$data['kamar']) {
            $this->session->set_flashdata('error', 'Kamar tidak ditemukan.');
            redirect('komplek');
        }

        $data['title'] = 'Edit Kamar';
        $data['main'] = 'komplek/kamar_edit';
        $this->load->view('manage/layout', $data);


    }
}

public function delete_kamar($majors_id = NULL)
{
    // Cek apakah user memiliki akses (contoh: hanya SUPERUSER yang boleh hapus)
    if ($this->session->userdata('uroleid') != SUPERUSER) {
        redirect('manage');
    }

    if ($_POST) {
        // Ambil data santri yang masih terkait dengan kamar ini
        $Santri = $this->Student_model->get(array('majors_id' => $majors_id));

        // Jika masih ada santri yang terkait, tampilkan pesan error dan batalkan penghapusan
        if (count($Santri) > 0) {
            $this->session->set_flashdata('failed', 'Data Kamar tidak dapat dihapus karena masih memiliki santri.');
            redirect('manage/majors');
        }

        // Jika tidak ada santri, lanjutkan penghapusan
        $this->Student_model->delete_majors($majors_id);

        // Catat ke dalam activity log
        $this->load->model('logs/Logs_model');
        $this->Logs_model->add(
            array(
                'log_date' => date('Y-m-d H:i:s'),
                'user_id' => $this->session->userdata('uid'),
                'log_module' => 'Kamar',
                'log_action' => 'Hapus',
                'log_info' => 'ID: ' . $majors_id . '; Nama: ' . $this->input->post('delName')
            )
        );

        // Beri notifikasi sukses
        $this->session->set_flashdata('success', 'Hapus Kamar berhasil');
        redirect('manage/majors');
    } elseif (!$_POST) {
        $this->session->set_flashdata('delete', 'Delete');
        redirect('manage/majors/edit/' . $majors_id);
    }

}


}
