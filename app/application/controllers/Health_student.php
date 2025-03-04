<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Health_student extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model(['health/Health_model', 'student/Student_model']);
    }

    public function get_health_data()
    {
        header('Content-Type: application/json');

        // Ambil NIS dari session
        $nis = $this->session->userdata('unis_student');
        if (!$nis) {
            echo json_encode([
                "status" => false,
                "message" => "NIS not found in session."
            ]);
            return;
        }

        // Ambil data siswa berdasarkan NIS
        $student = $this->Student_model->get_by_nis($nis);
        if (!$student) {
            echo json_encode([
                "status" => false,
                "message" => "Student data not found."
            ]);
            return;
        }

        // Ambil data kesehatan berdasarkan student_id
        $kesehatan = $this->Health_model->get_by_student($student['student_id']);

        // Siapkan respons JSON
        $response = [
            "status" => true,
            "message" => "Health data retrieved successfully.",
            "data" => [
                "student" => $student,
                "kesehatan" => $kesehatan
            ]
        ];

        // Kirim respons JSON
        echo json_encode($response);
    }
}
