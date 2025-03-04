<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Majors_set extends CI_Controller
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

    $this->load->model(array('student/Student_model', 'setting/Setting_model'));
    $this->load->helper(array('form', 'url'));
  }

  // User_customer view in list
  public function index($offset = NULL)
  {
    $this->load->library('pagination');
    // Apply Filter
    // Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
    // Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['majors_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 10;
    $params['offset'] = $offset;
    $data['majors'] = $this->Student_model->get_majors($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $config['per_page'] = 10;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/majors/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_class($paramsPage));
    $this->pagination->initialize($config);
    $data['komplek'] = $this->Student_model->get_komplek(); // Ambil daftar komplek
    $data['title'] = 'Kamar';
    $data['main'] = 'majors/majors_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob()
  {
      if ($_POST) {
          $majorsName = $this->input->post('majors_name'); // Ambil dari form
          $komplekId = $this->input->post('komplek_id'); // Ambil komplek_id dari form
  
          // Pastikan data diterima dalam bentuk array
          if (!is_array($majorsName) || !is_array($komplekId)) {
              $this->session->set_flashdata('failed', 'Terjadi kesalahan, data tidak valid.');
              redirect('manage/majors');
              return;
          }
  
          $cpt = count($majorsName);
  
          for ($i = 0; $i < $cpt; $i++) {
              // Pastikan komplek_id ada sebelum menyimpan
              if (!isset($komplekId[$i]) || empty($komplekId[$i])) {
                  $this->session->set_flashdata('failed', 'Harap pilih komplek sebelum menambahkan kamar.');
                  redirect('manage/majors');
                  return;
              }
  
              $params = array(
                  'majors_name' => $majorsName[$i],
                  'komplek_id' => $komplekId[$i]
              );
  
              // Debug sebelum menyimpan ke database
              echo "<pre>";
              print_r($params);
              echo "</pre>";
              // exit(); // Uncomment ini untuk debugging
  
              $this->Student_model->add_majors($params);
          }
  
          $this->session->set_flashdata('success', 'Tambah Kamar Berhasil');
      } else {
          $this->session->set_flashdata('failed', 'Terjadi kesalahan, kamar tidak dapat ditambahkan.');
      }
  
      redirect('manage/majors');
  }
  
  

  // Add User_customer and Update
  public function add($id = NULL)
  {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('majors_name', 'Nama Kamar', 'trim|required|xss_clean');
      $this->form_validation->set_rules('komplek_id', 'Komplek', 'trim|required|xss_clean');
  
      $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
      $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';
  
      if ($_POST and $this->form_validation->run() == TRUE) {
          $params['majors_name'] = $this->input->post('majors_name');
          $params['majors_short_name'] = $this->input->post('majors_short_name');
          $params['komplek_id'] = $this->input->post('komplek_id');
  
          $status = $this->Student_model->add_majors($params);
          $this->session->set_flashdata('success', $data['operation'] . ' Kamar Berhasil');
          redirect('manage/majors');
      } else {
          // **Pastikan data komplek dikirim ke view**
          $data['komplek'] = $this->Student_model->get_komplek(); // Ambil daftar komplek
          
          $data['title'] = $data['operation'] . ' Kamar';
          $data['main'] = 'majors/majors_add';
          $this->load->view('manage/layout', $data);
      }
  }
  

  // Delete to database
  public function delete($id = NULL)
  {
    if ($this->session->userdata('uroleid') != SUPERUSER) {
      redirect('manage');
    }
    if ($_POST) {

      $Santri = $this->Student_model->get(array('majors_id' => $id));

      if (count($Santri) > 0) {
        $this->session->set_flashdata('failed', 'Data Kamar tidak dapat dihapus');
        redirect('manage/majors');
      }

      $this->Student_model->delete_majors($id);
      // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'user',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Kamar berhasil');
      redirect('manage/majors');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/majors/edit/' . $id);
    }
  }
}
