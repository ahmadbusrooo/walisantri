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
            echo json_encode([
                "status" => false,
                "message" => "Unauthorized access. Please log in."
            ]);
            exit;
        }

        // Load model yang dibutuhkan
        $this->load->model(array(
            'pelanggaran/Pelanggaran_model',
            'student/Student_model'
        ));
    }

    public function get_pelanggaran() {
        header('Content-Type: application/json');

        // Ambil NIS dari session
        $nis = $this->session->userdata('unis_student');
        if (empty($nis)) {
            echo json_encode([
                "status" => false,
                "message" => "NIS not found in session."
            ]);
            return;
        }

        // Ambil data siswa berdasarkan NIS
        $student = $this->Student_model->get(array('student_nis' => $nis));
        if (empty($student)) {
            echo json_encode([
                "status" => false,
                "message" => "Student data not found."
            ]);
            return;
        }

        // Ambil data pelanggaran berdasarkan student_id
        $pelanggaran = $this->Pelanggaran_model->get_by_student($student['student_id']);

        // Siapkan respons JSON
        $response = [
            "status" => true,
            "message" => "Violation data retrieved successfully.",
            "data" => [
                "student" => $student,
                "pelanggaran" => $pelanggaran
            ]
        ];

        // Kirim respons JSON
        echo json_encode($response);
    }
}
