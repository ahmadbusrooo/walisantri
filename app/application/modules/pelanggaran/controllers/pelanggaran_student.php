<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggaran_student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct(TRUE);

        // Cek apakah siswa sudah login
        if ($this->session->userdata('logged_student') == NULL) {
            header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }

        // Load model yang dibutuhkan
        $this->load->model(array(
            'pelanggaran/Pelanggaran_model',
            'student/Student_model'
        ));
    }

    public function index()
    {
        // Ambil NIS dari session
        $nis = $this->session->userdata('unis_student');
        if (empty($nis)) {
            show_error("NIS tidak ditemukan di session.");
        }

        // Ambil data siswa berdasarkan NIS
        $student = $this->Student_model->get(array('student_nis' => $nis));
        if (empty($student)) {
            show_error("Data siswa tidak ditemukan.");
        }

        // Ambil data pelanggaran berdasarkan student_id
        $data['pelanggaran'] = $this->Pelanggaran_model->get_by_student($student['student_id']);
        $data['student'] = $student;

        // Atur tampilan
        $data['title'] = 'Data Pelanggaran Siswa';
        $data['main'] = 'student/pelanggaran_siswa';
$this->load->view('student/layout', $data);

    }
}
