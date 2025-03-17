<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Class_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

    $this->load->model(array('student/Student_model', 'setting/Setting_model'));
    $this->load->model('ustadz/Ustadz_model'); // Pastikan model dimuat
    $this->load->model('class/Class_model'); // Perhatikan huruf kecil
    $this->load->helper(array('form', 'url'));
  }

// User_customer view in list
  public function index($offset = NULL) {
    $this->load->library('pagination');
// Apply Filter
// Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $params = array();
// Nip
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['class_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 10;
    $params['offset'] = $offset;
    $data['classes'] = $this->Student_model->get_class($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $data['ustadz'] = $this->Ustadz_model->get_wali_kelas();
    $data['classes'] = $this->Class_model->get_all();
    $config['per_page'] = 10;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/class/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_class($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Kelas';
    $data['main'] = 'class/class_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
        $className = $_POST['class_name'];
        $waliKelas = $_POST['wali_kelas_id']; // Tambahkan wali kelas
        $cpt = count($_POST['class_name']);

        for ($i = 0; $i < $cpt; $i++) {
            $params = array(
                'class_name' => $className[$i],
                'wali_kelas_id' => isset($waliKelas[$i]) ? $waliKelas[$i] : NULL // Pastikan wali_kelas_id juga disimpan
            );

            $this->Class_model->save_class($params); // Gunakan save_class() yang baru dibuat
        }
    }

    $this->session->set_flashdata('success', 'Tambah Kelas Berhasil');
    redirect('manage/class');
}


  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('class_name', 'Nama Kelas', 'trim|required|xss_clean');
    $this->form_validation->set_rules('wali_kelas_id', 'Wali Kelas', 'trim|integer');

    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($this->input->post() && $this->form_validation->run() == TRUE) {
        $params = array(
            'class_name' => $this->input->post('class_name'),
            'wali_kelas_id' => $this->input->post('wali_kelas_id') // Menyimpan wali kelas
        );

        if ($this->input->post('class_id')) {
            $params['class_id'] = $this->input->post('class_id');
        }

        $this->Class_model->save_class($params);

        $this->session->set_flashdata('success', $data['operation'] . ' Data Kelas Berhasil.');
        redirect('manage/class');
    } else {
        // Ambil daftar ustadz yang bisa dijadikan wali kelas
        $this->load->model('Ustadz_model');
        $data['ustadz'] = $this->Ustadz_model->get_wali_kelas();

        if (!is_null($id)) {
            $class = $this->Class_model->get_by_id($id);
            if (!$class) {
                $this->session->set_flashdata('error', 'Data kelas tidak ditemukan.');
                redirect('manage/class');
            } else {
                $data['class'] = $class;
            }
        } else {
            $data['class'] = array('class_id' => '', 'class_name' => '', 'wali_kelas_id' => '');
        }

        $data['title'] = $data['operation'] . ' Keterangan Kelas';
        $data['main'] = 'class/class_add';
        $this->load->view('manage/layout', $data);
    }
}


// Delete to database
public function delete($id = NULL) {

  // Periksa apakah ada siswa yang terdaftar di kelas ini
  $Santri = $this->Student_model->get(array('class_id' => $id));
  
  // Periksa apakah kelas ini digunakan di tabel class_kitab
  $class_kitab = $this->db->get_where('class_kitab', ['class_id' => $id])->result_array();

  if ($_POST) {
      if (count($Santri) > 0 || count($class_kitab) > 0) {
          $this->session->set_flashdata('failed', 'Data Kelas tidak dapat dihapus karena masih digunakan.');
          redirect('manage/class');
      }

      // Hapus data kelas jika tidak ada relasi
      $this->Student_model->delete_class($id);

      // Catat log aktivitas
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
          array(
              'log_date' => date('Y-m-d H:i:s'),
              'user_id' => $this->session->userdata('uid'),
              'log_module' => 'Kelas',
              'log_action' => 'Hapus',
              'log_info' => 'ID:' . $id . '; Nama:' . $this->input->post('delName')
          )
      );

      $this->session->set_flashdata('success', 'Hapus Kelas berhasil.');
      redirect('manage/class');
  } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/class/edit/' . $id);
  }
}

}
