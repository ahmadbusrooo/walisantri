<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth_student_api extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('student/Student_model');
        $this->load->model('setting/Setting_model');
        $this->load->library('form_validation');
        $this->load->helper('string');
        header('Content-Type: application/json'); // Set JSON header
    }

    // Login API
    public function login() {
        $response = ['status' => false, 'message' => ''];
    
        // Validasi input
        $this->form_validation->set_rules('nis', 'NIS', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
    
        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
            echo json_encode($response);
            return;
        }
    
        // Ambil data dari POST
        $nis = $this->input->post('nis', TRUE);
        $password = $this->input->post('password', TRUE);
    
        // Cek data siswa
        $student = $this->Student_model->get(array('nis' => $nis, 'password' => sha1($password)));
    
        if (!empty($student)) {
            // Login berhasil
            $this->session->set_userdata('logged_student', TRUE);
            $this->session->set_userdata('uid_student', $student[0]['student_id']);
            $this->session->set_userdata('unis_student', $student[0]['student_nis']);
            $this->session->set_userdata('ufullname_student', $student[0]['student_full_name']);
            $this->session->set_userdata('student_img', $student[0]['student_img']);
    
            // Buat token unik
            $token = random_string('alnum', 40); // Token acak 40 karakter
            $this->session->set_userdata('token', $token);
    
            $response['status'] = true;
            $response['message'] = 'Login successful';
            $response['data'] = [
                'student_id' => $student[0]['student_id'],
                'nis' => $student[0]['student_nis'],
                'full_name' => $student[0]['student_full_name'],
                'student_img' => $student[0]['student_img'],
                'token' => $token, // Sertakan token di respons
            ];
        } else {
            // Login gagal
            $response['message'] = 'NIS atau Password tidak cocok.';
        }
    
        echo json_encode($response);
    }
    

    // Logout API
    public function logout() {
        $response = ['status' => true, 'message' => 'Logout berhasil'];

        $this->session->unset_userdata('logged_student');
        $this->session->unset_userdata('uid_student');
        $this->session->unset_userdata('unis_student');
        $this->session->unset_userdata('ufullname_student');
        $this->session->unset_userdata('student_img');

        echo json_encode($response);
    }
}
