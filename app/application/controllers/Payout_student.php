<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payout_student extends CI_Controller {

  public function __construct() {
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
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model'));
  }

  public function get_payout_data() {
    header('Content-Type: application/json');

    // Ambil NIS dari session (key: unis_student)
    $nis = $this->session->userdata('unis_student');
    if (empty($nis)) {
      echo json_encode([
        "status" => false,
        "message" => "NIS not found in session."
      ]);
      return;
    }

    // Ambil data santri berdasarkan NIS
    $Santri = $this->Student_model->get(array('student_nis' => $nis));
    if (empty($Santri)) {
      echo json_encode([
        "status" => false,
        "message" => "Student data not found."
      ]);
      return;
    }

    // Persiapkan parameter untuk query
    $params = array(
      'group' => TRUE,
      'student_id' => $Santri['student_id'],
    );
    $pay = array(
      'student_id' => $Santri['student_id'],
      'paymentt' => TRUE,
    );

    // Ambil data yang diperlukan
    $period = $this->Period_model->get($params);
    $student = $this->Bulan_model->get($pay);
    $bebas = $this->Bebas_model->get($pay);
    $free = $this->Bebas_pay_model->get($params);
    $bill = $this->Bulan_model->get_total($params);
    $bulan = $this->Bulan_model->get(array('student_id' => $Santri['student_id']));
    $in = $this->Bulan_model->get_total(array('student_id' => $Santri['student_id'], 'status' => 1));

    // Perhitungan total tagihan
    $total = 0;
    foreach ($bill as $key) {
      $total += $key['bulan_bill'];
    }

    $pay = 0;
    foreach ($in as $row) {
      $pay += $row['bulan_bill'];
    }

    $pay_bill = 0;
    foreach ($free as $row) {
      $pay_bill += $row['bebas_pay_bill'];
    }

    // Siapkan respons JSON
    $response = [
      "status" => true,
      "message" => "Payout data retrieved successfully.",
      "data" => [
        "period" => $period,
        "student" => $student,
        "bebas" => $bebas,
        "free" => $free,
        "bill" => $bill,
        "bulan" => $bulan,
        "in" => $in,
        "total" => $total,
        "pay" => $pay,
        "pay_bill" => $pay_bill
      ]
    ];

    // Kirim respons JSON
    echo json_encode($response);
  }
}
