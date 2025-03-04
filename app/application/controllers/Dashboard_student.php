<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_student extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('student/Student_model', 'bulan/Bulan_model', 'setting/Setting_model','bebas/Bebas_model', 'information/Information_model', 'bebas/Bebas_pay_model'));
        if ($this->session->userdata('logged_student') == NULL) {
            echo json_encode([
                "status" => false,
                "message" => "Unauthorized access. Please log in."
            ]);
            exit;
        }
    }

    // API for Dashboard Data
    public function get_dashboard_data() {
        header('Content-Type: application/json');

        // Retrieve student ID from session
        $student_id = $this->session->userdata('uid_student');
        if (!$student_id) {
            echo json_encode([
                "status" => false,
                "message" => "Student ID is not available in session."
            ]);
            return;
        }

        // Fetch information data
        $information = $this->Information_model->get(array('information_publish' => 1));

        // Fetch billing and payment data for the student
        $bulan = $this->Bulan_model->get(array('status' => 0, 'period_status' => 1, 'student_id' => $student_id));
        $bebas = $this->Bebas_model->get(array('period_status' => 1, 'student_id' => $student_id));

        // Calculate totals
        $total_bulan = 0;
        foreach ($bulan as $row) {
            $total_bulan += $row['bulan_bill'];
        }

        $total_bebas = 0;
        $total_bebas_pay = 0;
        foreach ($bebas as $row) {
            $total_bebas += $row['bebas_bill'];
            $total_bebas_pay += $row['bebas_total_pay'];
        }

        // Prepare response data
        $response = [
            "status" => true,
            "message" => "Dashboard data retrieved successfully.",
            "data" => [
                "information" => $information,
                "bulan" => $bulan,
                "bebas" => $bebas,
                "total_bulan" => $total_bulan,
                "total_bebas" => $total_bebas,
                "total_bebas_pay" => $total_bebas_pay
            ]
        ];

        // Send response
        echo json_encode($response);
    }
}
