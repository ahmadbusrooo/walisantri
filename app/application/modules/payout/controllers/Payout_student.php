<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payout_student extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged_student') == NULL) {
      header("Location:" . site_url('student/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model'));
  }

  public function index() {
    // Ambil NIS dari session (key: unis_student)
    $nis = $this->session->userdata('unis_student');
    if (empty($nis)) {
      show_error("NIS tidak ditemukan di session.");
    }

    // Ambil data santri berdasarkan NIS
    $Santri = $this->Student_model->get(array('student_nis' => $nis));
    if (empty($Santri)) {
      show_error("Data santri tidak ditemukan.");
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
    $data['period'] = $this->Period_model->get($params);
    $data['Santri'] = $Santri;
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bebas'] = $this->Bebas_model->get($pay);
    $data['free'] = $this->Bebas_pay_model->get($params);
    $data['bill'] = $this->Bulan_model->get_total($params);
    $data['bulan'] = $this->Bulan_model->get(array('student_id' => $Santri['student_id']));
    $data['in'] = $this->Bulan_model->get_total(array('student_id' => $Santri['student_id'], 'status' => 1));

    // Perhitungan total tagihan
    $data['total'] = 0;
    foreach ($data['bill'] as $key) {
      $data['total'] += $key['bulan_bill'];
    }

    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['pay_bill'] = 0;
    foreach ($data['free'] as $row) {
      $data['pay_bill'] += $row['bebas_pay_bill'];
    }

    // Atur tampilan
    $data['title'] = 'Cek Pembayaran Santri';
    $data['main'] = 'payout/payout_student_list';
    $this->load->view('student/layout', $data);
  }
}
