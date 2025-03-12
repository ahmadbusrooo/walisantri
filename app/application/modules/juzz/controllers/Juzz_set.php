<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Juzz_set extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $list_access = array(SUPERUSER);
    if (!in_array($this->session->userdata('uroleid'),$list_access)) {
      redirect('manage');
    }

    $this->load->model(array('student/Student_model', 'setting/Setting_model'));
    $this->load->model('ustadz/Ustadz_model'); // Pastikan model dimuat
    $this->load->model('juzz/Juzz_model'); // Perhatikan huruf kecil
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
      $params['juzz_name'] = $f['n'];
    }

    $paramsPage = $params;
    $params['limit'] = 10;
    $params['offset'] = $offset;
    $data['juzzes'] = $this->Student_model->get_juzz($params);
    $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
    $data['ustadz'] = $this->Ustadz_model->get_wali_kelas();
    $data['juzzes'] = $this->Juzz_model->get_all();
    $config['per_page'] = 10;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/juzz/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_juzz($paramsPage));
    $this->pagination->initialize($config);

    $data['title'] = 'Juzz';
    $data['main'] = 'juzz/juzz_list';
    $this->load->view('manage/layout', $data);
  }

  public function add_glob(){
    if ($_POST == TRUE) {
        $juzzName = $_POST['juzz_name'];
        $waliJuzz = $_POST['wali_kelas_id']; // Tambahkan wali kelas
        $cpt = count($_POST['juzz_name']);

        for ($i = 0; $i < $cpt; $i++) {
            $params = array(
                'juzz_name' => $juzzName[$i],
                'wali_kelas_id' => isset($waliJuzz[$i]) ? $waliJuzz[$i] : NULL // Pastikan wali_kelas_id juga disimpan
            );

            $this->Juzz_model->save_juzz($params); // Gunakan save_juzz() yang baru dibuat
        }
    }

    $this->session->set_flashdata('success', 'Tambah Juzz Berhasil');
    redirect('manage/juzz');
}


  public function add($id = NULL) {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('juzz_name', 'Nama Juzz', 'trim|required|xss_clean');
    $this->form_validation->set_rules('wali_kelas_id', 'Wali Juzz', 'trim|integer');

    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($this->input->post() && $this->form_validation->run() == TRUE) {
        $params = array(
            'juzz_name' => $this->input->post('juzz_name'),
            'wali_kelas_id' => $this->input->post('wali_kelas_id') // Menyimpan wali kelas
        );

        if ($this->input->post('juzz_id')) {
            $params['juzz_id'] = $this->input->post('juzz_id');
        }

        $this->Juzz_model->save_juzz($params);

        $this->session->set_flashdata('success', $data['operation'] . ' Data Juzz Berhasil.');
        redirect('manage/juzz');
    } else {
        // Ambil daftar ustadz yang bisa dijadikan wali kelas
        $this->load->model('Ustadz_model');
        $data['ustadz'] = $this->Ustadz_model->get_wali_kelas();

        if (!is_null($id)) {
            $juzz = $this->Juzz_model->get_by_id($id);
            if (!$juzz) {
                $this->session->set_flashdata('error', 'Data kelas tidak ditemukan.');
                redirect('manage/juzz');
            } else {
                $data['juzz'] = $juzz;
            }
        } else {
            $data['juzz'] = array('juzz_id' => '', 'juzz_name' => '', 'wali_kelas_id' => '');
        }

        $data['title'] = $data['operation'] . ' Keterangan Juzz';
        $data['main'] = 'juzz/juzz_add';
        $this->load->view('manage/layout', $data);
    }
}


// Delete to database
public function delete($id = NULL) {
  if ($this->session->userdata('uroleid') != SUPERUSER) {
      redirect('manage');
  }

  // Periksa apakah ada siswa yang terdaftar di kelas ini
  $Santri = $this->Student_model->get(array('juzz_id' => $id));
  
  // Periksa apakah kelas ini digunakan di tabel juzz_kitab
  $juzz_kitab = $this->db->get_where('juzz_kitab', ['juzz_id' => $id])->result_array();

  if ($_POST) {
      if (count($Santri) > 0 || count($juzz_kitab) > 0) {
          $this->session->set_flashdata('failed', 'Data Juzz tidak dapat dihapus karena masih digunakan.');
          redirect('manage/juzz');
      }

      // Hapus data kelas jika tidak ada relasi
      $this->Student_model->delete_juzz($id);

      // Catat log aktivitas
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
          array(
              'log_date' => date('Y-m-d H:i:s'),
              'user_id' => $this->session->userdata('uid'),
              'log_module' => 'Juzz',
              'log_action' => 'Hapus',
              'log_info' => 'ID:' . $id . '; Nama:' . $this->input->post('delName')
          )
      );

      $this->session->set_flashdata('success', 'Hapus Juzz berhasil.');
      redirect('manage/juzz');
  } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/juzz/edit/' . $id);
  }
}

}
