<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Health_student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['health/Health_model', 'student/Student_model']);
    }

    public function index()
    {
        $nis = $this->session->userdata('unis_student');
        if (!$nis) {
            show_error('NIS tidak ditemukan.');
        }

        $student = $this->Student_model->get_by_nis($nis);
        if (!$student) {
            show_error('Data siswa tidak ditemukan.');
        }

        $data['kesehatan'] = $this->Health_model->get_by_student($student['student_id']);
        $data['title'] = 'Riwayat Kesehatan Siswa';
        $data['main'] = 'health/health_student';
        $this->load->view('student/layout', $data);
    }
}
