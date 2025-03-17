<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Student_set extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }

    $this->load->model(array('student/Student_model', 'setting/Setting_model', 'bulan/Bulan_model', 'bebas/Bebas_model'));
    $this->load->helper(array('form', 'url'));
  }

  // User_customer view in list
  public function index($offset = NULL)
  {
    $this->load->library('pagination');

    // Ambil semua parameter GET
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;

    // Inisialisasi filter
    $params = array();

    // Filter berdasarkan NIS atau nama
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['student_search'] = $f['n'];
    }

    // Filter berdasarkan kelas
    if (isset($f['class']) && !empty($f['class']) && $f['class'] != '') {
      $params['class_id'] = $f['class'];
    }

    if (isset($f['juzz']) && !empty($f['juzz']) && $f['juzz'] != '') {
      $params['juzz_id'] = $f['juzz'];
    }

    // **Filter berdasarkan Komplek**
    if (!empty($f['komplek_id'])) {
      $params['komplek_id'] = $f['komplek_id'];
    }
    // Filter berdasarkan kamar (hanya jika sistem mendukung)
    if (isset($f['kamar']) && !empty($f['kamar']) && $f['kamar'] != '') {
      $params['majors_id'] = $f['kamar'];
    }

    // Ambil data dengan filter
    $paramsPage = $params;
    $params['limit'] = 100;
    $params['offset'] = $offset;
    $params['student_status'] = 1; // Hanya ambil santri yang aktif
    // Ambil data santri dan total santri
    $data['student'] = $this->Student_model->get_filtered_students($params);
    $data['total_students'] = $this->Student_model->count_filtered_students($params);
    $data['complete_count'] = $this->Student_model->count_complete_students();
    $data['incomplete_count'] = $this->Student_model->count_incomplete_students();
    // Pagination
    $config['per_page'] = 100;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/student/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_filtered_students($paramsPage));
    // var_dump($this->Student_model->get_filtered_students($paramsPage));
    // exit;

    $this->pagination->initialize($config);

    // Data tambahan untuk dropdown filter
    $data['class'] = $this->Student_model->get_all_classes();
    $data['juzz'] = $this->Student_model->get_all_juzzes();
    $data['majors'] = $this->Student_model->get_all_majors();
    $data['komplek'] = $this->Student_model->get_komplek();
    $data['title'] = 'Data Santri';
    $data['main'] = 'student/student_list';
    $this->load->view('manage/layout', $data);
  }

  public function view_only($offset = NULL)
  {
    $this->load->library('pagination');

    // Ambil parameter filter
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;

    // Filter parameter
    $params = array();
    if (isset($f['n']) && !empty($f['n'])) {
      $params['student_search'] = $f['n'];
    }
    if (isset($f['class']) && !empty($f['class'])) {
      $params['class_id'] = $f['class'];
    }
    if (isset($f['juzz']) && !empty($f['juzz'])) {
      $params['juzz_id'] = $f['juzz'];
    }
    if (!empty($f['komplek_id'])) {
      $params['komplek_id'] = $f['komplek_id'];
    }
    if (isset($f['kamar']) && !empty($f['kamar'])) {
      $params['majors_id'] = $f['kamar'];
    }

    // Konfigurasi data
    $params['limit'] = 100;
    $params['offset'] = $offset;
    $params['student_status'] = 1; // Hanya aktif

    $data['student'] = $this->Student_model->get_filtered_students($params);

    // Pagination
    $config['per_page'] = 100;
    $config['uri_segment'] = 4;
    $config['base_url'] = site_url('manage/student/view_only');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get_filtered_students($params));
    $this->pagination->initialize($config);

    // Data untuk view
    $data['class'] = $this->Student_model->get_all_classes();
    $data['juzz'] = $this->Student_model->get_all_juzzes();
    $data['majors'] = $this->Student_model->get_all_majors();
    $data['komplek'] = $this->Student_model->get_komplek();
    $data['title'] = 'View Data Santri';
    $data['main'] = 'student/student_list_view'; // File view baru

    $this->load->view('manage/layout', $data); // Layout khusus view-only
  }

  // Add User and Update
  public function add($id = NULL)
  {

    $this->load->library('form_validation');

    if (!$this->input->post('student_id')) {
      $this->form_validation->set_rules('student_nis', 'NIS', 'trim|required|xss_clean|is_unique[student.student_nis]');
      $this->form_validation->set_rules('student_password', 'Password', 'trim|required|xss_clean|min_length[6]');
      $this->form_validation->set_rules('passconf', 'Konfirmasi password', 'trim|required|xss_clean|min_length[6]|matches[student_password]');
      $this->form_validation->set_message('passconf', 'Password dan konfirmasi password tidak cocok');
    }
    $this->form_validation->set_rules('student_full_name', 'Nama lengkap', 'trim|required|xss_clean');
    $this->form_validation->set_rules('student_gender', 'Jenis Kelamin', 'trim|required|xss_clean');
    $this->form_validation->set_rules(
      'student_born_date',
      'Tanggal Lahir',
      'trim|required|xss_clean|callback_validate_date_format'
    );
    $this->form_validation->set_rules('class_class_id', 'Kelas', 'trim|required|xss_clean');
    $this->form_validation->set_rules('juzz_juzz_id', 'Juzz', 'trim|xss_clean');
    $this->form_validation->set_rules('majors_majors_id', 'Kamar', 'trim|required|xss_clean');
    $this->form_validation->set_rules('student_name_of_father', 'Ayah Kandung', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button position="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST and $this->form_validation->run() == TRUE) {

      if ($this->input->post('student_id')) {
        $params['student_id'] = $id;
      } else {
        $params['student_input_date'] = date('Y-m-d H:i:s');
        $params['student_password'] = sha1($this->input->post('student_password'));
      }
      $params['student_nis'] = $this->input->post('student_nis');
      $params['student_nisn'] = $this->input->post('student_nisn');
      $params['student_gender'] = $this->input->post('student_gender');
      $params['student_phone'] = $this->input->post('student_phone');
      $params['student_hobby'] = $this->input->post('student_hobby');
      $params['class_class_id'] = $this->input->post('class_class_id');
      $juzz_input = $this->input->post('juzz_juzz_id');
      $params['juzz_juzz_id'] = ($juzz_input !== "") ? $juzz_input : NULL;
      $params['majors_majors_id'] = $this->input->post('majors_majors_id'); // Kamar harus sesuai dengan komplek yang dipilih
      $params['komplek_id'] = $this->input->post('komplek_id'); // Tambahkan komplek_id
      $params['student_last_update'] = date('Y-m-d H:i:s');
      $params['student_full_name'] = $this->input->post('student_full_name');
      $params['student_born_place'] = $this->input->post('student_born_place');
      $born_date = $this->input->post('student_born_date');
      if (!empty($born_date)) {
        $date = DateTime::createFromFormat('d/m/Y', $born_date);

        // Validasi tanggal
        if (!$date) {
          $this->session->set_flashdata('error', 'Format tanggal salah! Gunakan DD/MM/YYYY');
          redirect('manage/student/add'); // Redirect kembali ke form
        }

        $params['student_born_date'] = $date->format('Y-m-d'); // Format MySQL
      } else {
        $params['student_born_date'] = null; // Atur null jika kosong
      }
      $params['student_address'] = $this->input->post('student_address');
      $params['student_name_of_mother'] = $this->input->post('student_name_of_mother');
      $params['student_name_of_father'] = $this->input->post('student_name_of_father');
      $params['student_parent_phone'] = $this->input->post('student_parent_phone');
      $params['student_status'] = $this->input->post('student_status');
      $status = $this->Student_model->add($params);
      // echo "<pre>";
      // var_dump($params['juzz_juzz_id']);
      // die();
      if (!empty($_FILES['student_img']['name'])) {
        $paramsupdate['student_img'] = $this->do_upload($name = 'student_img', $fileName = $params['student_full_name']);
      }

      $paramsupdate['student_id'] = $status;
      $this->Student_model->add($paramsupdate);

      // activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Student',
          'log_action' => $data['operation'],
          'log_info' => 'ID:' . $status . ';Name:' . $this->input->post('student_full_name')
        )
      );

      $this->session->set_flashdata('success', $data['operation'] . ' Santri Berhasil');
      redirect('manage/student');
    } else {
      if ($this->input->post('student_id')) {
        redirect('manage/student/edit/' . $this->input->post('student_id'));
      }

      // Edit mode
      if (!is_null($id)) {
        $object = $this->Student_model->get(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/student');
        } else {
          // 🔥 Konversi format tanggal dari database (Y-m-d) ke dd/mm/YYYY
          $object['student_born_date'] = date('d/m/Y', strtotime($object['student_born_date']));
          $data['student'] = $object;
        }
      }
      
      $data['setting_level'] = $this->Setting_model->get(array('id' => 7));
      $data['ngapp'] = 'ng-app="classApp"';
      $data['class'] = $this->Student_model->get_class();
      $data['juzz'] = $this->Student_model->get_juzz();
      // Ambil daftar komplek dan kirim ke view
      $data['komplek'] = $this->Student_model->get_komplek();
      $data['majors'] = []; // Kosongkan daftar kamar, nanti diisi dengan AJAX
      $data['title'] = $data['operation'] . ' Santri';
      $data['main'] = 'student/student_add';
      $this->load->view('manage/layout', $data);
    }
  }


  public function validate_date_format($date)
  {
    $d = DateTime::createFromFormat('d/m/Y', $date);
    if ($d && $d->format('d/m/Y') === $date) {
      return TRUE;
    } else {
      $this->form_validation->set_message('validate_date_format', 'Format tanggal harus DD/MM/YYYY');
      return FALSE;
    }
  }
  // Student_set.php
  public function monitoring()
  {
    $params = array();

    // Filter status kelengkapan
    if ($this->input->get('status') == 'complete') {
      $params['is_complete'] = 1;
    } elseif ($this->input->get('status') == 'incomplete') {
      $params['is_complete'] = 0;
    }

    $data['students'] = $this->Student_model->get_completion_status($params);
    $data['complete_count'] = $this->Student_model->count_complete_students();
    $data['incomplete_count'] = $this->Student_model->count_incomplete_students();

    $data['title'] = 'Monitoring Kelengkapan Data Santri';
    $data['main'] = 'student/monitoring_view';
    $this->load->view('manage/layout', $data);
  }
  public function get_kamar_by_komplek()
  {
    $komplek_id = $this->input->post('komplek_id');
    $data = $this->Student_model->get_kamar_by_komplek($komplek_id);
    echo json_encode($data);
  }


  public function report()
  {
    $this->load->library('pagination');

    // Ambil parameter filter dari GET
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;
    $params = array();

    // Filter berdasarkan NIS atau Nama
    if (isset($f['n']) && !empty($f['n'])) {
      $params['student_search'] = $f['n'];
    }

    // Filter berdasarkan Kelas
    if (isset($f['class']) && !empty($f['class'])) {
      $params['class_id'] = $f['class'];
    }

    // Filter berdasarkan Kelas
    if (isset($f['juzz']) && !empty($f['juzz'])) {
      $params['juzz_id'] = $f['juzz'];
    }

    // Filter berdasarkan Komplek
    if (isset($f['komplek_id']) && !empty($f['komplek_id'])) {
      $params['komplek_id'] = $f['komplek_id'];
    }

    // Ambil data santri dengan filter
    $data['students'] = $this->Student_model->get_filtered_students($params);
    $data['total_students'] = count($data['students']);

    // Data untuk dropdown filter
    $data['classes'] = $this->Student_model->get_all_classes();
    $data['juzzes'] = $this->Student_model->get_all_juzzes();
    $data['komplek'] = $this->Student_model->get_komplek(); // Tambahkan ini

    // Load tampilan laporan
    $data['title'] = 'Laporan Data Santri';
    $data['main'] = 'student/student_report';
    $this->load->view('manage/layout', $data);
  }

  public function print_report_pdf()
  {
    $this->load->helper(array('dompdf', 'tanggal'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');

    // Ambil filter dari GET
    $f = $this->input->get(NULL, TRUE);
    $params = array();

    // Filter berdasarkan NIS/Nama
    if (isset($f['n']) && !empty($f['n'])) {
      $params['student_search'] = $f['n'];
    }

    // Filter berdasarkan Kelas
    $data['selected_class'] = 'Semua Kelas'; // Default jika tidak ada kelas yang dipilih
    if (isset($f['class']) && !empty($f['class'])) {
      $params['class_id'] = $f['class'];

      // Ambil data kelas
      $class = $this->Student_model->get_class(array('id' => $f['class']));

      // Cek apakah data kelas tersedia
      if (!empty($class) && isset($class['class_name'])) {
        $data['selected_class'] = $class['class_name'];
      }
    }

     // Filter berdasarkan Kelas
     $data['selected_juzz'] = 'Semua Kelas'; // Default jika tidak ada kelas yang dipilih
     if (isset($f['juzz']) && !empty($f['juzz'])) {
       $params['juzz_id'] = $f['juzz'];
 
       // Ambil data kelas
       $juzz = $this->Student_model->get_juzz(array('id' => $f['juzz']));
 
       // Cek apakah data kelas tersedia
       if (!empty($juzz) && isset($juzz['juzz_name'])) {
         $data['selected_juzz'] = $juzz['juzz_name'];
       }
     }
    // Tambahkan filter komplek
    $data['selected_komplek'] = 'Semua Komplek'; // Default value
    if (isset($f['komplek_id']) && !empty($f['komplek_id'])) {
      $params['komplek_id'] = $f['komplek_id'];

      // Ambil data komplek
      $komplek = $this->Student_model->get_komplek(array('komplek_id' => $f['komplek_id']));
      if (!empty($komplek) && isset($komplek['komplek_name'])) {
        $data['selected_komplek'] = $komplek['komplek_name'];
      }
    }


    if (isset($f['komplek_id']) && !empty($f['komplek_id'])) {
      $params['komplek_id'] = $f['komplek_id'];

      // Ambil data komplek
      $komplek = $this->Student_model->get_komplek(array('id' => $f['komplek_id']));
      if (!empty($komplek) && isset($komplek['komplek_name'])) {
        $data['selected_komplek'] = $komplek['komplek_name'];
      }
    }

    // Ambil data santri berdasarkan filter
    $data['students'] = $this->Student_model->get_filtered_students($params);

    // Cek apakah ada data
    if (empty($data['students'])) {
      $this->session->set_flashdata('failed', 'Data santri tidak ditemukan');
      redirect('manage/student');
      return;
    }


    // Ambil data sekolah untuk header laporan
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));

    // Load tampilan PDF
    $html = $this->load->view('student/student_report_pdf', $data, true);

    // Buat PDF dengan nama "LAPORAN_SANTRI_TANGGAL.pdf"
    pdf_create($html, 'LAPORAN_SANTRI_' . date('d_m_Y'), TRUE, 'F4', 'landscape');
  }



  public function pelanggaran_siswa()
  {
    $student_id = $this->session->userdata('student_id'); // Ambil ID siswa dari sesi
    if (!$student_id) {
      redirect('student/auth/login'); // Redirect jika belum login
    }

    $data['pelanggaran'] = $this->Pelanggaran_model->get_pelanggaran_by_student($student_id); // Ambil data pelanggaran
    $data['title'] = 'Data Pelanggaran Siswa';
    $this->load->view('student/pelanggaran_siswa', $data); // Muat view
  }


  // View data detail
  public function view($id = NULL)
  {
    $data['student'] = $this->Student_model->get(array('id' => $id));
    $data['title'] = 'Detail Santri';
    $data['main'] = 'student/student_view';
    $this->load->view('manage/layout', $data);
  }

  // Delete to database
  public function delete($id = NULL)
  {
    if ($_POST) {

      $bulan = $this->Bulan_model->get(array('student_id' => $this->input->post('student_id')));
      $bebas = $this->Bebas_model->get(array('student_id' => $this->input->post('student_id')));

      if (count($bulan) > 0 or count($bebas) > 0) {
        $this->session->set_flashdata('failed', 'Santri tidak dapat dihapus');
        redirect('manage/student');
      }

      $this->Student_model->delete($this->input->post('student_id'));

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
      $this->session->set_flashdata('success', 'Hapus Santri berhasil');
      redirect('manage/student');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/student/edit/' . $id);
    }
  }

  // Class view in list
  public function clasess($offset = NULL)
  {
    $this->load->library('pagination');

    $data['class'] = $this->Student_model->get_class(array('limit' => 10, 'offset' => $offset));
    $data['title'] = 'Daftar Kelas';
    $data['main'] = 'student/class_list';
    $config['total_rows'] = count($this->Student_model->get_class());
    $this->pagination->initialize($config);

    $this->load->view('manage/layout', $data);
  }

  // Setting Upload File Requied
  function do_upload($name = NULL, $fileName = NULL)
  {
    $this->load->library('upload');

    $config['upload_path'] = FCPATH . 'uploads/student/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }

    $config['allowed_types'] = 'gif|jpg|jpeg|png';
    $config['max_size'] = '1024';
    $config['file_name'] = $fileName;
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($name)) {
      $this->session->set_flashdata('success', $this->upload->display_errors('', ''));
      redirect(uri_string());
    }

    $upload_data = $this->upload->data();

    return $upload_data['file_name'];
  }


  // Add User_customer and Update
  public function add_class($id = NULL)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('class_name', 'Name', 'trim|required|xss_clean');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button ket="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    $data['operation'] = is_null($id) ? 'Tambah' : 'Sunting';

    if ($_POST and $this->form_validation->run() == TRUE) {

      if ($this->input->post('class_id')) {
        $params['class_id'] = $this->input->post('class_id');
      }
      $params['class_name'] = $this->input->post('class_name');
      $status = $this->Student_model->add_class($params);


      $this->session->set_flashdata('success', $data['operation'] . ' Keterangan Kelas');
      redirect('manage/student/add');

      if ($this->input->post('from_angular')) {
        echo $status;
      }
    } else {
      if ($this->input->post('class_id')) {
        redirect('manage/student/class/edit/' . $this->input->post('class_id'));
      }

      // Edit mode
      if (!is_null($id)) {
        $object = $this->Student_model->get_ket(array('id' => $id));
        if ($object == NULL) {
          redirect('manage/student/class');
        } else {
          $data['class'] = $object;
        }
      }
      $data['title'] = $data['operation'] . ' Keterangan Kelas';
      $data['main'] = 'manage/student/class_add';
      $this->load->view('manage/layout', $data);
    }
  }

  public function import()
  {
    if ($_POST) {
      $rows = explode("\n", $this->input->post('rows'));
      $success = 0;
      $failled = 0;
      $exist = 0;
      $nis = '';
      foreach ($rows as $row) {
        $exp = explode("\t", $row);
        $count = (majors() == 'senior') ? 14 : 13;
        if (count($exp) != $count) continue;
        $nis = trim($exp[0]);
        $ttl = trim($exp[5]);
        $date = str_replace('-', '', $ttl);
        $arr = [
          'student_nis' => trim($exp[0]),
          'student_nisn' => trim($exp[1]),
          'student_password' => sha1(date('dmY', strtotime($date))),
          'student_full_name' => trim($exp[2]),
          'student_gender' => trim($exp[3]),
          'student_born_place' => trim($exp[4]),
          'student_born_date' => trim($exp[5]),
          'student_hobby' => trim($exp[6]),
          'student_phone' => trim($exp[7]),
          'student_address' => trim($exp[8]),
          'student_name_of_mother' => trim($exp[9]),
          'student_name_of_father' => trim($exp[10]),
          'student_parent_phone' => trim($exp[11]),
          'class_class_id' => trim($exp[12]),
          'majors_majors_id' => (majors() == 'senior') ? trim($exp[13]) : NULL,
          'student_input_date' => date('Y-m-d H:i:s'),
          'student_last_update' => date('Y-m-d H:i:s')
        ];
        $class = $this->Student_model->get_class(array('id' => trim($exp[12])));
        if (majors() == 'senior') {
          $majors = $this->Student_model->get_majors(array('id' => trim($exp[13])));
        }
        $check = $this->db
          ->where('student_nis', trim($exp[0]))
          ->count_all_results('student');
        if ($check == 0) {
          if (trim($exp[12]) == NULL or is_null($class)) {
            $this->session->set_flashdata('failed', 'ID Kelas tidak ada');
            redirect('manage/student/import');
          } else if ($this->db->insert('student', $arr)) {
            $success++;
          } else {
            $failled++;
          }
        } else {
          $exist++;
        }
      }
      $msg = 'Sukses : ' . $success . ' baris, Gagal : ' . $failled . ', Duplikat : ' . $exist;
      $this->session->set_flashdata('success', $msg);
      redirect('manage/student/import');
    } else {
      $data['title'] = 'Import Data Santri';
      $data['main'] = 'student/student_upload';
      $data['action'] = site_url(uri_string());
      $this->load->view('manage/layout', $data);
    }
  }

  function rpw($id = NULL)
  {
    $this->load->library('form_validation');
    $this->form_validation->set_rules('student_password', 'Password', 'trim|required|xss_clean|min_length[6]');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'trim|required|xss_clean|min_length[6]|matches[student_password]');
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>', '</div>');
    if ($_POST and $this->form_validation->run() == TRUE) {
      $id = $this->input->post('student_id');
      $params['student_password'] = sha1($this->input->post('student_password'));
      $status = $this->Student_model->change_password($id, $params);

      $this->session->set_flashdata('success', 'Reset Password Berhasil');
      redirect('manage/student');
    } else {
      if ($this->Student_model->get(array('id' => $id)) == NULL) {
        redirect('manage/student');
      }
      $data['student'] = $this->Student_model->get(array('id' => $id));
      $data['title'] = 'Reset Password';
      $data['main'] = 'student/change_pass';
      $this->load->view('manage/layout', $data);
    }
  }

  public function download()
  {
    if (majors() == 'senior') {
      $data = file_get_contents("./media/template_excel/Template_Data_Santri_Senior.xls");
      $name = 'Template_Data_Santri_Senior.xls';
    } else {
      $data = file_get_contents("./media/template_excel/Template_Data_Santri_Primary.xls");
      $name = 'Template_Data_Santri_Primary.xls';
    }

    $this->load->helper('download');
    force_download($name, $data);
  }

  public function pass($offset = NULL)
  {
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;
    $params = array();
    // Nip
    if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
      $params['class_id'] = $f['pr'];
    }

    $paramsPage = $params;
    $params['status'] = TRUE;
    $params['offset'] = $offset;
    $data['notpass'] = $this->Student_model->get($params);
    $data['pass'] = $this->Student_model->get(array('status' => 0));
    $data['class'] = $this->Student_model->get_class($params);
    $config['base_url'] = site_url('manage/student/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get($paramsPage));


    $data['title'] = 'Kelulusan Santri';
    $data['main'] = 'student/student_pass';
    $this->load->view('manage/layout', $data);
  }

  public function upgrade($offset = NULL)
  {
    $f = $this->input->get(NULL, TRUE);
    $data['f'] = $f;
    $params = array();
    // Nip
    if (isset($f['pr']) && !empty($f['pr']) && $f['pr'] != '') {
      $params['class_id'] = $f['pr'];
    }

    $params['status'] = 1;

    $paramsPage = $params;
    $params['offset'] = $offset;
    $data['student'] = $this->Student_model->get($params);
    $data['class'] = $this->Student_model->get_class($params);
    $data['upgrade'] = $this->Student_model->get_class();
    $config['base_url'] = site_url('manage/student/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Student_model->get($paramsPage));

    $data['title'] = 'Kenaikan Kelas';
    $data['main'] = 'student/student_upgrade';
    $this->load->view('manage/layout', $data);
  }
  public function kenaikan_juz($offset = NULL)
  {
      $f = $this->input->get(NULL, TRUE);
      $data['f'] = $f;
      $params = array();
  
      // Filter berdasarkan Juz saat ini
      if (isset($f['pr']) && !empty($f['pr'])) {
          $params['juzz_id'] = $f['pr'];
      }
  
      $params['status'] = 1; // Hanya siswa aktif
  
      // Ambil data siswa
      $data['student'] = $this->Student_model->get_filtered_students($params);
      
      // Data untuk dropdown Juz
      $data['juzz'] = $this->Student_model->get_all_juzzes();
      $data['upgrade_juzz'] = $this->Student_model->get_all_juzzes();
  
      $data['title'] = 'Kenaikan Juz Santri';
      $data['main'] = 'student/student_juz'; // File view baru
      $this->load->view('manage/layout', $data);
  }
  function multiple()
  {
    $action = $this->input->post('action');
    $print = array();
    $idcard = array();
    if ($action == "pass") {
      $pass = $this->input->post('msg');
      for ($i = 0; $i < count($pass); $i++) {
        $this->Student_model->add(array('student_id' => $pass[$i], 'student_status' => 0, 'student_last_update' => date('Y-m-d H:i:s')));
        $this->session->set_flashdata('success', 'Proses Lulus berhasil');
      }
      redirect('manage/student/pass');
    } elseif ($action == "notpass") {
      $notpass = $this->input->post('msg');
      for ($i = 0; $i < count($notpass); $i++) {
        $this->Student_model->add(array('student_id' => $notpass[$i], 'student_status' => 1, 'student_last_update' => date('Y-m-d H:i:s')));
        $this->session->set_flashdata('success', 'Proses Kembali berhasil');
      }
      redirect('manage/student/pass');
    } elseif ($action == "upgrade") {
      $upgrade = $this->input->post('msg');
      for ($i = 0; $i < count($upgrade); $i++) {
        $this->Student_model->add(array('student_id' => $upgrade[$i], 'class_class_id' => $this->input->post('class_id'), 'student_last_update' => date('Y-m-d H:i:s')));
        $this->session->set_flashdata('success', 'Proses Kenaikan Kelas berhasil');
      }
      redirect('manage/student/upgrade');
    }elseif ($action == "upgrade_juz") {
        $upgrade = $this->input->post('msg');
        for ($i = 0; $i < count($upgrade); $i++) {
            $this->Student_model->add(array(
                'student_id' => $upgrade[$i], 
                'juzz_juzz_id' => $this->input->post('juzz_id'), // Update juz
                'student_last_update' => date('Y-m-d H:i:s')
            ));
        }
        $this->session->set_flashdata('success', 'Proses Kenaikan Juz berhasil');
        redirect('manage/student/kenaikan_juz');
    }
     elseif ($action == "printPdf") {
      $this->load->helper(array('dompdf'));
      $idcard = $this->input->post('msg');
      for ($i = 0; $i < count($idcard); $i++) {
        $print[] = $idcard[$i];
      }

      $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
      $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
      $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
      $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
      $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
      $data['student'] = $this->Student_model->get(array('multiple_id' => $print));

      for ($i = 0; $i < count($data['student']); $i++) {
        $this->barcode2($data['student'][$i]['student_nis'], '');
      }
      $html = $this->load->view('student/student_multiple_pdf', $data, true);
      $data = pdf_create($html, 'KARTU_' . date('d_m_Y'), TRUE, 'A4', 'potrait');
    }
  }

  public function printAllPdf()
  {
    $this->load->helper(array('dompdf', 'tanggal'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');

    $idcard = $this->input->post('msg'); // Ambil ID siswa yang dipilih

    // Cek apakah ada data yang dikirimkan
    if (empty($idcard) || !is_array($idcard)) {
      $this->session->set_flashdata('failed', 'Tidak ada santri yang dipilih');
      redirect('manage/student');
      return;
    }

    // Ambil data sekolah untuk header laporan
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));

    // Ambil data siswa berdasarkan ID yang dipilih
    $data['students'] = $this->Student_model->get(array('multiple_id' => $idcard));

    if (empty($data['students'])) {
      $this->session->set_flashdata('failed', 'Data santri tidak ditemukan');
      redirect('manage/student');
      return;
    }

    // Generate barcode untuk setiap siswa
    foreach ($data['students'] as $student) {
      $this->barcode2($student['student_nis'], '');
    }

    // Load tampilan PDF
    $html = $this->load->view('student/student_all_pdf', $data, true);

    // Buat PDF dengan nama "DATA_SANTRI_TANGGAL.pdf"
    pdf_create($html, 'DATA_SANTRI_' . date('d_m_Y'), TRUE, 'F4', 'landscape');
  }

  public function send_multiple_wa()
  {
      $students = $this->input->post('students');
      $message = $this->input->post('message');
  
      if (empty($students)) {
          echo json_encode(["status" => "error", "message" => "Pilih santri terlebih dahulu!"]);
          return;
      }
  
      $this->load->model('Student_model');
      
      // 1. Ambil semua data santri yang dipilih
      $allStudents = $this->Student_model->get(['multiple_id' => $students]);
      
      // 2. Proses validasi nomor
      $validNumbers = [];
      $failedNumbers = [];
      
      foreach ($allStudents as $student) {
          $phone = $student['student_parent_phone'];
          $rawPhone = $phone;
          
          // Normalisasi nomor
          $phone = preg_replace('/[^0-9]/', '', $phone);
          $originalPhone = $phone;
          
          if (preg_match('/^0/', $phone)) {
              $phone = '62' . substr($phone, 1);
          }
          
          // Validasi akhir
          if (preg_match('/^628\d{8,15}$/', $phone)) {
              $validNumbers[] = [
                  'student_id' => $student['student_id'],
                  'name' => $student['student_full_name'],
                  'phone' => $phone
              ];
          } else {
              $failedNumbers[] = [
                  'student_id' => $student['student_id'],
                  'name' => $student['student_full_name'],
                  'phone' => $rawPhone,
                  'reason' => $this->get_failure_reason($originalPhone)
              ];
          }
      }
  
      if (empty($validNumbers)) {
          echo json_encode([
              "status" => "error",
              "message" => "Tidak ada nomor valid",
              "details" => "Format nomor harus 08xxx atau 628xxx (min 10 digit)",
              "failed" => $failedNumbers
          ]);
          return;
      }
  
      // 3. Dapatkan konfigurasi API
      $api_url = $this->Setting_model->get_value(['id' => 8]);
      $api_token = $this->Setting_model->get_value(['id' => 9]);
  
      if (empty($api_url) || empty($api_token)) {
          log_message('error', 'WA API config missing');
          echo json_encode([
              "status" => "error", 
              "message" => "Server error: WA01",
              "failed" => $failedNumbers
          ]);
          return;
      }
  
      // 4. Format payload
      $payload = [
          "data" => array_map(function($item) use ($message) {
              return [
                  'phone' => $item['phone'],
                  'message' => $message
              ];
          }, $validNumbers)
      ];
  
      // 5. Eksekusi API
      $curl = curl_init();
      curl_setopt_array($curl, [
          CURLOPT_URL => $api_url,
          CURLOPT_HTTPHEADER => [
              "Authorization: $api_token",
              "Content-Type: application/json"
          ],
          CURLOPT_POST => true,
          CURLOPT_POSTFIELDS => json_encode($payload),
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_SSL_VERIFYHOST => 0,
          CURLOPT_SSL_VERIFYPEER => 0
      ]);
  
      $response = curl_exec($curl);
      $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
      $error = curl_error($curl);
      curl_close($curl);
  
      // 6. Logging untuk debugging
      log_message('debug', 'WA Request: ' . json_encode($payload));
      log_message('debug', 'WA Response: ' . $response);
  
      // 7. Handle response
      $responseData = json_decode($response, true);
      
      // 8. Tentukan status pengiriman
      $status = "warning";
      $message = "Terjadi kesalahan pengiriman";
      
      if ($httpCode == 200 && isset($responseData['status']) && $responseData['status'] == 'sent') {
          $status = "success";
          $message = "Berhasil mengirim ke " . count($validNumbers) . " nomor";
      }
  
      // 9. Kembalikan response dengan data lengkap
      echo json_encode([
          "status" => $status,
          "message" => $message,
          "success" => $validNumbers,
          "failed" => $failedNumbers,
          "api_response" => $responseData,
          "http_code" => $httpCode
      ]);
  }
  
  private function get_failure_reason($phone)
  {
      if (empty($phone)) return 'Nomor tidak terisi';
      
      $phone = preg_replace('/[^0-9]/', '', $phone);
      
      if (!preg_match('/^(0|62)/', $phone)) return 'Format awal nomor salah';
      if (preg_match('/^0/', $phone) && strlen($phone) < 10) return 'Nomor terlalu pendek';
      if (preg_match('/^62/', $phone) && strlen($phone) < 11) return 'Nomor terlalu pendek';
      if (!preg_match('/^628\d{8,15}$/', $phone)) return 'Format nomor tidak valid';
      
      return 'Nomor tidak valid';
  }

  // satuan
  function printPdf($id = NULL)
  {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $this->load->model('student/Student_model');
    $this->load->model('setting/Setting_model');
    if ($id == NULL)
      redirect('manage/student');

    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    $data['student'] = $this->Student_model->get(array('id' => $id));
    $this->barcode2($data['student']['student_nis'], '');
    $html = $this->load->view('student/student_pdf', $data, true);
    $data = pdf_create($html, $data['student']['student_full_name'], TRUE, 'A4', 'potrait');
  }



  private function barcode2($sparepart_code, $barcode_type = 39, $scale = 6, $fontsize = 1, $thickness = 30, $dpi = 72)
  {

    $this->load->library('upload');
    $config['upload_path'] = FCPATH . 'media/barcode_student/';

    /* create directory if not exist */
    if (!is_dir($config['upload_path'])) {
      mkdir($config['upload_path'], 0777, TRUE);
    }
    $this->upload->initialize($config);

    // CREATE BARCODE GENERATOR
    // Including all required classes
    require_once(APPPATH . 'libraries/barcodegen/BCGFontFile.php');
    require_once(APPPATH . 'libraries/barcodegen/BCGColor.php');
    require_once(APPPATH . 'libraries/barcodegen/BCGDrawing.php');

    // Including the barcode technology
    // Ini bisa diganti-ganti mau yang 39, ato 128, dll, liat di folder barcodegen
    require_once(APPPATH . 'libraries/barcodegen/BCGcode39.barcode.php');

    // Loading Font
    // kalo mau ganti font, jangan lupa tambahin dulu ke folder font, baru loadnya di sini
    $font = new BCGFontFile(APPPATH . 'libraries/font/Arial.ttf', $fontsize);

    // Text apa yang mau dijadiin barcode, biasanya kode produk
    $text = $sparepart_code;

    // The arguments are R, G, B for color.
    $color_black = new BCGColor(0, 0, 0);
    $color_white = new BCGColor(255, 255, 255);

    $drawException = null;
    try {
      $code = new BCGcode39(); // kalo pake yg code39, klo yg lain mesti disesuaikan
      $code->setScale($scale); // Resolution
      $code->setThickness($thickness); // Thickness
      $code->setForegroundColor($color_black); // Color of bars
      $code->setBackgroundColor($color_white); // Color of spaces
      $code->setFont($font); // Font (or 0)
      $code->parse($text); // Text
    } catch (Exception $exception) {
      $drawException = $exception;
    }

    /* Here is the list of the arguments
    1 - Filename (empty : display on screen)
    2 - Background color */
    $drawing = new BCGDrawing('', $color_white);
    if ($drawException) {
      $drawing->drawException($drawException);
    } else {
      $drawing->setDPI($dpi);
      $drawing->setBarcode($code);
      $drawing->draw();
    }
    // ini cuma labeling dari sisi aplikasi saya, penamaan file menjadi png barcode.
    $filename_img_barcode = $sparepart_code . '_' . $barcode_type . '.png';
    // folder untuk menyimpan barcode
    $drawing->setFilename(FCPATH . 'media/barcode_student/' . $sparepart_code . '.png');
    // proses penyimpanan barcode hasil generate
    $drawing->finish(BCGDrawing::IMG_FORMAT_PNG);

    return $filename_img_barcode;
  }
}
