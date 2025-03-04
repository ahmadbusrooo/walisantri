<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nadzhaman_student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_student') == NULL) {
            redirect('student/auth/login?location=' . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(['nadzhaman/Nadzhaman_model', 'student/Student_model']);
    }



    

    public function index()
    {
        // Ambil NIS dari session
        $nis = $this->session->userdata('unis_student');
        if (empty($nis)) {
            show_error('NIS tidak ditemukan di session.');
        }

        // Ambil data siswa berdasarkan NIS
        $student = $this->Student_model->get_by_nis($nis);
        if (empty($student)) {
            show_error('Data siswa tidak ditemukan.');
        }

        // Ambil data nadzhaman berdasarkan student_id
        $data['nadzhaman'] = $this->Nadzhaman_model->get_by_student($student['student_id']);

        // Atur data tampilan
        $data['title'] = 'Riwayat Nadzhaman Siswa';
        $data['student'] = $student;
        $data['main'] = 'nadzhaman/student_list';
        $this->load->view('student/layout', $data);

    }
}
