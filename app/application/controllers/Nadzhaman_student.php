<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Nadzhaman_student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged_student') == NULL) {
            echo json_encode([
                "status" => false,
                "message" => "Unauthorized access. Please log in."
            ]);
            exit;
        }
        $this->load->model(['nadzhaman/Nadzhaman_model', 'student/Student_model']);
    }

    public function get_nadzhaman_data()
    {
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
        $student = $this->Student_model->get_by_nis($nis);
        if (empty($student)) {
            echo json_encode([
                "status" => false,
                "message" => "Student data not found."
            ]);
            return;
        }

        // Ambil data nadzhaman berdasarkan student_id
        $nadzhaman = $this->Nadzhaman_model->get_by_student($student['student_id']);

        // Siapkan respons JSON
        $response = [
            "status" => true,
            "message" => "Nadzhaman data retrieved successfully.",
            "data" => [
                "student" => $student,
                "nadzhaman" => $nadzhaman
            ]
        ];

        // Kirim respons JSON
        echo json_encode($response);
    }
}
