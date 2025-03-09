<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Payout_set extends CI_Controller {

  public function __construct() {
    parent::__construct(TRUE);
    if ($this->session->userdata('logged') == NULL) {
      header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
    }
    $this->load->model(array('payment/Payment_model', 'student/Student_model', 'period/Period_model', 'pos/Pos_model', 'bulan/Bulan_model', 'bebas/Bebas_model', 'bebas/Bebas_pay_model', 'setting/Setting_model', 'letter/Letter_model', 'logs/Logs_model', 'ltrx/Log_trx_model'));
  }

// payment view in list
  public function index($offset = NULL, $id =NULL) {
// Apply Filter
// Get $_GET variable
    $f = $this->input->get(NULL, TRUE);

// Tambahkan validasi untuk memastikan parameter tersedia
$f['n'] = isset($f['n']) ? $f['n'] : null;
$f['r'] = isset($f['r']) ? $f['r'] : null;
$f['d'] = isset($f['d']) ? $f['d'] : null;


    $data['f'] = $f;

    $Santri['student_id'] = '';
    $params = array();
    $param = array();
    $pay = array();
    $cashback = array();
    $logs = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      $cashback['period_id'] = $f['n'];
      $logs['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $cashback['student_nis'] = $f['r'];
      $logs['student_nis'] = $f['r'];
      $Santri = $this->Student_model->get(array('student_nis'=>$f['r']));
    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];

    }


    $params['group'] = TRUE;
    $pay['paymentt'] = TRUE;
    $param['status'] = 1;
    $cashback['status'] = 1;
    $pay['student_id'] = $Santri['student_id'];
    $pay['period_id'] = $f['n'];
    
    $cashback['student_id']=$Santri['student_id'];
    $logs['student_id']=$Santri['student_id'];
    $cashback['date'] = date('Y-m-d');
    $cashback['bebas_pay_input_date'] = date('Y-m-d');
    $logs['limit'] = 5;


    $paramsPage = $params;
    $data['period'] = $this->Period_model->get($params);
    $data['Santri'] = $this->Student_model->get(array('student_id'=>$Santri['student_id'], 'group'=>TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
   $data['bulan'] = [];
   $bulan_raw = $this->Bulan_model->get(array(
    'student_id' => $Santri['student_id'],
    'period_id' => $f['n']
));

$data['bulan'] = [];
if (!empty($bulan_raw)) {
    foreach ($bulan_raw as $item) {
        $month_name = isset($item['month_name']) ? $item['month_name'] : 'Unknown';
        $payment_id = isset($item['payment_payment_id']) ? $item['payment_payment_id'] : 'Unknown';

        if (!isset($data['bulan'][$month_name][$payment_id])) {
            $data['bulan'][$month_name][$payment_id] = $item;
        }
    }
} else {
    $this->session->set_flashdata('error', 'Data bulan tidak ditemukan.');
}

  
    $data['bebas'] = $this->Bebas_model->get($pay);
    $data['free'] = $this->Bebas_pay_model->get($params);
    $data['dom'] = $this->Bebas_pay_model->get($params);
    $data['bill'] = $this->Bulan_model->get_total(array(
      'period_id' => $f['n'],
      'student_id' => $Santri['student_id']
  ));
  
    $data['in'] = $this->Bulan_model->get_total(array('status' => 1, 'period_id' => $f['n']));
    $data['month'] = $this->Bulan_model->get_total(array('period_id' => $f['n'], 'student_id' => $Santri['student_id']));
    $data['beb'] = $this->Bebas_pay_model->get($cashback);
    $data['log'] = $this->Log_trx_model->get($logs);

    // cashback
    $data['cash'] = 0;
    foreach ($data['month'] as $row) {
      $data['cash'] += $row['bulan_bill'];
    }

    $data['cashb'] = 0;
    foreach ($data['beb'] as $row) {
      $data['cashb'] += $row['bebas_pay_bill'];
    }

    // endcashback


    // 
    $data['total'] = $this->Bulan_model->get_total([
    'period_id' => $f['n'], // Tahun pelajaran
    'student_id' => $Santri['student_id'] // Siswa yang dipilih
]);


    $data['pay'] = 0;
    foreach ($data['in'] as $row) {
      $data['pay'] += $row['bulan_bill'];
    }

    $data['pay_bill'] = 0;
    foreach ($data['dom'] as $row) {
      $data['pay_bill'] += $row['bebas_pay_bill'];
    }

    $config['base_url'] = site_url('manage/payment/index');
    $config['suffix'] = '?' . http_build_query($_GET, '', "&");
    $config['total_rows'] = count($this->Bulan_model->get($paramsPage));

    $data['title'] = 'Pembayaran Santri';
    $data['main'] = 'payout/payout_list';
    $data['santri'] = $this->Student_model->get_all_santri();
    $this->load->view('manage/layout', $data);
  } 

  public function search_santri() {
    $keyword = $this->input->get('keyword'); // Ambil kata kunci
    $santri = $this->Student_model->search_santri($keyword); // Panggil model

    // Format data untuk JSON (digunakan oleh Select2)
    $results = [];
    foreach ($santri as $row) {
        $results[] = [
            'id' => $row['student_nis'],
            'text' => $row['student_nis'] . ' - ' . $row['student_full_name']
        ];
    }

    echo json_encode($results); // Kirim data dalam format JSON
}



  function printBill() {
    $this->load->helper(array('dompdf'));
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $Santri['student_id'] = '';
    $params = array();
    $pay = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $Santri = $this->Student_model->get(array('student_nis'=>$f['r']));

    }

    $pay['student_id'] = $Santri['student_id'];
    $pay['period_id'] = $f['n'];
    
    $data['period'] = $this->Period_model->get($params);
    $data['Santri'] = $this->Student_model->get(array('student_id'=>$Santri['student_id'], 'group'=>TRUE));
    $data['bulan'] = $this->Bulan_model->get($pay);
    $data['bebas'] = $this->Bebas_model->get($pay);

    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 

    $html = $this->load->view('payout/payout_bill_pdf', $data, true);
    $data = pdf_create($html, $Santri['student_full_name'], TRUE, 'A4', TRUE);
  }

  function cetakBukti() {
    $this->load->helper(array('dompdf'));
    $f = $this->input->get(NULL, TRUE);

    $data['f'] = $f;

    $Santri['student_id'] = '';
    $params = array();
    $param = array();
    $pay = array();
    $cashback = array();

// Tahun Ajaran
    if (isset($f['n']) && !empty($f['n']) && $f['n'] != '') {
      $params['period_id'] = $f['n'];
      $pay['period_id'] = $f['n'];
      $cashback['period_id'] = $f['n'];
    }

// Santri
    if (isset($f['r']) && !empty($f['r']) && $f['r'] != '') {
      $params['student_nis'] = $f['r'];
      $param['student_nis'] = $f['r'];
      $Santri = $this->Student_model->get(array('student_nis'=>$f['r']));

    }

    // tanggal
    if (isset($f['d']) && !empty($f['d']) && $f['d'] != '') {
      $param['date'] = $f['d'];
      $cashback['date'] = $f['d'];

    }


    $params['group'] = TRUE;
    $pay['paymentt'] = TRUE;
    $param['status'] = 1;
    $param['student_id']=$Santri['student_id'];
    $cashback['status'] = 1;
    $pay['student_id'] = $Santri['student_id'];
    $pay['period_id'] = $f['n'];
    
    $cashback['student_id']=$Santri['student_id'];

    $data['period'] = $this->Period_model->get($params);
    $data['Santri'] = $this->Student_model->get(array('student_id'=>$Santri['student_id'], 'group'=>TRUE));
    $data['student'] = $this->Bulan_model->get($pay);
    $data['bulan'] = $this->Bulan_model->get($param);
    $data['bebas'] = $this->Bebas_model->get($pay);
    $data['free'] = $this->Bebas_pay_model->get($param);
    $data['s_bl'] = $this->Bulan_model->get_total($cashback);
    $data['s_bb'] = $this->Bebas_pay_model->get($cashback);

    //total
    $data['summonth'] = 0;
    foreach ($data['s_bl'] as $row) {
      $data['summonth'] += $row['bulan_bill'];
    }

    $data['sumbeb'] = 0;
    foreach ($data['s_bb'] as $row) {
      $data['sumbeb'] += $row['bebas_pay_bill'];
    }
    // endtotal

    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT)); 
    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME)); 
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS)); 
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 

    $html = $this->load->view('payout/payout_cetak_pdf', $data, true);
    $data = pdf_create($html, 'Cetak_Struk_'.$Santri['student_full_name'].'_'.date('Y-m-d'), TRUE, 'A4', TRUE);
  }



// View data detail
  public function view_bulan($id = NULL) {

// Apply Filter
// Get $_GET variable
    $q = $this->input->get(NULL, TRUE); 

    $data['q'] = $q;
    $params = array();

// Programs
    if (isset($q['pr']) && !empty($q['pr']) && $q['pr'] != '') {
      $params['class_id'] = $q['pr'];
    }

    $data['class'] = $this->Student_model->get_class($params);
    $data['student'] = $this->Student_model->get($params);
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bulan';
    $this->load->view('manage/layout', $data);
  }

// View data detail
  public function view_bebas($id = NULL) {

    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bebas'] = $this->Bebas_model->get(array('id' => $id));
    $data['title'] = 'Tarif Pembayaran';
    $data['main'] = 'payment/payment_view_bebas';
    $this->load->view('manage/layout', $data);
  }


  public function payout_bulan($id = NULL, $student_id = NULL) {

    if ($id == NULL AND $student_id == NULL OR $student_id == NULL) {
      redirect('manage/payout');
    }

    $data['class'] = $this->Student_model->get_class();
    $data['payment'] = $this->Payment_model->get(array('id' => $id));
    $data['bulan'] = $this->Bulan_model->get(array('payment_id' => $id, 'student_id' => $student_id));
    $data['in'] = $this->Bulan_model->get_total(array('status'=>1, 'payment_id' => $id, 'student_id' => $student_id));
    $data['student'] = $this->Student_model->get(array('id'=> $student_id));
    $data['bill'] = $this->Bulan_model->get(array(
      'payment_id' => $id,
      'student_id' => $student_id
  ));
  $data['total'] = 0;
  if (!empty($data['bill'])) {
      foreach ($data['bill'] as $key) {
          $data['total'] += $key['bulan_bill'];
      }
  }
  

   $data['total'] = 0; // Default value jika tidak ada data
if (!empty($data['bill'])) {
    foreach ($data['bill'] as $key) {
        $data['total'] += $key['bulan_bill'];
    }
}

$data['pay'] = 0; // Default value jika tidak ada data
if (!empty($data['in'])) {
    foreach ($data['in'] as $row) {
        $data['pay'] += $row['bulan_bill'];
    }
}


    $data['ngapp'] = 'ng-app="App"';
    $data['title'] = 'Pembayaran Santri';
    $data['main'] = 'payout/payout_add_bulan';
    $this->load->view('manage/layout', $data);
  }

  public function payout_bebas($id = NULL, $student_id = NULL, $bebas_id = NULL, $pay_id =NULL) {

    // if ($id == NULL AND $student_id == NULL AND $bebas_id == NULL OR $bebas_id == NULL) {
    //   redirect('manage/payout');
    // }
    if ($_POST == TRUE) {


      $lastletter = $this->Letter_model->get(array('limit' => 1));
      $student = $this->Bebas_model->get(array('id'=>$this->input->post('bebas_id')));
      $user = $this->Setting_model->get(array('id' => 8));
      $password = $this->Setting_model->get(array('id' => 9));
      $activated = $this->Setting_model->get(array('id' => 10));

      if ($lastletter['letter_year'] < date('Y') OR count($lastletter) == 0) {
        $this->Letter_model->add(array('letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nomor = sprintf('%05d', '00001');
        $nofull = date('Y'). date('m'). $nomor;
      } else {
        $nomor = sprintf('%05d', $lastletter['letter_number'] + 00001);
        $this->Letter_model->add(array('letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')));
        $nofull = date('Y'). date('m'). $nomor;
      }
      if ($this->input->post('bebas_id')) {
        $param['bebas_id'] = $this->input->post('bebas_id');
      } 
      $param['bebas_pay_number'] = $nofull;
      $param['bebas_pay_bill'] = $this->input->post('bebas_pay_bill');
      $param['increase_budget'] = $this->input->post('bebas_pay_bill');
      $param['bebas_pay_desc'] = $this->input->post('bebas_pay_desc');
      $param['user_user_id'] = $this->session->userdata('uid');
      $param['bebas_pay_input_date'] = date('Y-m-d H:i:s');
      $param['bebas_pay_last_update'] = date('Y-m-d H:i:s');

      

      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$this->input->post('bebas_id')));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $this->input->post('payment_payment_id'), 'student_nis' => $this->input->post('student_nis')));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $sisa = $data['total'] - $data['total_pay'];


      if ($this->input->post('bebas_pay_bill') > $sisa OR $this->input->post('bebas_pay_bill') == 0) {
        $this->session->set_flashdata('failed',' Pembayaran yang anda masukkan melebihi total tagihan!!!');
        redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
      } else {

        $idd = $this->Bebas_pay_model->add($param);

        $this->Bebas_model->add(array('increase_budget' => $this->input->post('bebas_pay_bill'), 'bebas_id' =>  $this->input->post('bebas_id'), 'bebas_last_update'=>date('Y-m-d H:i:s'))); 
        
        $log = array(
          'bulan_bulan_id' => NULL,
          'bebas_pay_bebas_pay_id' => $idd,
          'student_student_id' => $this->input->post('student_student_id'),
          'log_trx_input_date' =>  date('Y-m-d H:i:s'),
          'log_trx_last_update' => date('Y-m-d H:i:s'),
        );
        $this->Log_trx_model->add($log);
      }

      if ($activated['setting_value'] == 'Y') {

        $userkey = $user['setting_value']; 
        $passkey = $password['setting_value']; 
        $telepon = $student['student_parent_phone'];
        $message = "Pembayaran ".$student['pos_name'].' - T.A '.$student['period_start'].'/'.$student['period_end'].'-'.$this->input->post('bebas_pay_desc').' a/n '.$student['student_full_name'].' Berhasil';
        $url = "https://reguler.zenziva.net/apps/smsapi.php";
        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, 'userkey='.$userkey.'&passkey='.$passkey.'&nohp='.$telepon.'&pesan='.urlencode($message));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curlHandle, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT,30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $results = curl_exec($curlHandle);
        curl_close($curlHandle);
      }

      $this->session->set_flashdata('success',' Pembayaran Tagihan berhasil');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);

    } else {

      $data['class'] = $this->Student_model->get_class();
      $data['payment'] = $this->Payment_model->get(array('id' => $id));
      $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $id, 'student_id' => $student_id));
      $data['student'] = $this->Student_model->get(array('id'=> $student_id));
      $data['bill'] = $this->Bebas_pay_model->get(array('bebas_id'=>$bebas_id, 'student_id'=>$student_id, 'payment_id'=>$id));

      $data['total'] = 0;
      foreach ($data['bebas'] as $key) {
        $data['total'] += $key['bebas_bill'];
      }

      $data['total_pay'] = 0;
      foreach ($data['bill'] as $row) {
        $data['total_pay'] += $row['bebas_pay_bill'];
      }

      $data['title'] = 'Tagihan Santri';
      // $data['main'] = 'payout/payout_add_bebas';
      $this->load->view('payout/payout_add_bebas', $data);

    }
  }
  public function multiple_pay()
  {
      // Ambil data dari POST
      $post_data = $this->input->post('payments');
  
      if (empty($post_data)) {
          $this->session->set_flashdata('error', 'Tidak ada tagihan yang dipilih.');
          redirect('manage/payout');
          return;
      }
  
      $success_count = 0;
      $failure_count = 0;
      $paid_months = []; 
      $student_id = null;

      $api_url = $this->Setting_model->get(array('id' => 8))['setting_value']; // URL Gateway WA
      $api_token = $this->Setting_model->get(array('id' => 9))['setting_value']; // API Key WA
      $activated_wa = $this->Setting_model->get(array('id' => 10))['setting_value']; // Aktivasi WA
      
      foreach ($post_data as $payment) {
          $payment_data = json_decode($payment, true);
  
          if (!isset($payment_data['bulan_id'], $payment_data['student_id'], $payment_data['amount'])) {
              $failure_count++;
              continue;
          }
  
          $bulan_id = $payment_data['bulan_id'];
          $student_id = $payment_data['student_id'];
          $amount = $payment_data['amount'];
  
          // Generate nomor pembayaran
          $lastletter = $this->Letter_model->get(array('limit' => 1));
          $nofull = $this->generatePaymentNumber($lastletter);
  
          $pay = array(
              'bulan_id' => $bulan_id,
              'bulan_number_pay' => $nofull,
              'bulan_date_pay' => date('Y-m-d H:i:s'),
              'bulan_last_update' => date('Y-m-d H:i:s'),
              'bulan_status' => 1,
              'user_user_id' => $this->session->userdata('uid')
          );
  
          if ($this->Bulan_model->add($pay)) {
              $log = array(
                  'bulan_bulan_id' => $bulan_id,
                  'student_student_id' => $student_id,
                  'bebas_pay_bebas_pay_id' => NULL,
                  'log_trx_input_date' => date('Y-m-d H:i:s'),
                  'log_trx_last_update' => date('Y-m-d H:i:s'),
              );
  
              $this->Log_trx_model->add($log);
  
              // Ambil detail bulan untuk laporan
              $bulan = $this->Bulan_model->get(array('id' => $bulan_id));
              if ($bulan) {
                  $payment_name = $bulan['pos_name'] . ' - T.A ' . $bulan['period_start'] . '/' . $bulan['period_end'];
                  if (!isset($paid_months[$payment_name])) {
                      $paid_months[$payment_name] = [];
                  }
                  $paid_months[$payment_name][] = [
                      'month_name' => $bulan['month_name'],
                      'amount' => $amount
                  ];
              }
  
              $success_count++;
          } else {
              $failure_count++;
          }
      }

      
  
      // Jika pembayaran sukses, ambil FCM token dari database dan kirim notifikasi
      if ($success_count > 0 && $student_id) {
          // Ambil data siswa
          $student = $this->Student_model->get(array('id' => $student_id));
          $student_name = $student ? $student['student_full_name'] : "Anak Anda";
  
          // Ambil semua token FCM terkait dengan student_id
          $this->db->select('fcm_token');
          $this->db->from('student_tokens');
          $this->db->where('student_id', $student_id);
          $query = $this->db->get();
          $fcm_tokens = array_column($query->result_array(), 'fcm_token');
  
          if (!empty($fcm_tokens)) {
              // Format pesan notifikasi
              $title = "Pembayaran Diterima";
              $body = "Pembayaran anak anda $student_name telah berhasil kami terima dengan detail berikut:\n";
              foreach ($paid_months as $payment_name => $months) {
                  $body .= "\n$payment_name\n";
                  foreach ($months as $month) {
                      $body .= "- {$month['month_name']}: Rp. " . number_format($month['amount'], 0, ',', '.') . "\n";
                  }
              }
              $body .= "\nTerima kasih 🙏";
  
              // Data yang akan dikirim ke Flutter
              $extraData = [
                  "title" => $title,
                  "body" => $body,
                  "date" => date('Y-m-d H:i:s'),
                  "student_name" => $student_name,
                  "payments" => $paid_months
              ];
  
              // Kirim FCM dalam batch (max 500 token per request)
              $batch_size = 500;
              $token_chunks = array_chunk($fcm_tokens, $batch_size);
  
              foreach ($token_chunks as $tokens) {
                  $fcm_url = "https://notifikasi.ppalmaruf.com/send_fcm.php";
                  $fcm_data = json_encode([
                      "fcm_tokens" => $tokens,
                      "title" => $title,
                      "body" => $body,
                      "route" => "/notification_detail",
                      "extra_data" => $extraData
                  ]);
  
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, $fcm_url);
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                  curl_setopt($ch, CURLOPT_POST, 1);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $fcm_data);
                  curl_setopt($ch, CURLOPT_HTTPHEADER, [
                      "Content-Type: application/json"
                  ]);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                  $result = curl_exec($ch);
                  curl_close($ch);
  
                  log_message('info', "Notifikasi FCM dikirim ke " . count($tokens) . " token: " . $result);
              }
          } else {
              log_message('error', "Tidak ada token FCM ditemukan untuk student_id: $student_id");
          }
      }

            // Jika WA diaktifkan dan pembayaran sukses
      if ($activated_wa == 'Y' && $success_count > 0 && !empty($api_url) && !empty($api_token)) {
        // Format nomor HP wali santri
        $phone_number = preg_replace('/[^0-9]/', '', $student['student_parent_phone']);
        if (strpos($phone_number, '62') !== 0) {
            $phone_number = '62' . substr($phone_number, 1);
        }

        // Buat pesan WA
        $wa_message = "*Assalamu'alaikum* Bapak/Ibu ".$student['student_name_of_father'].",\n\n";
        $wa_message .= "Pembayaran untuk ".$student['student_full_name']." telah *berhasil diterima:*\n\n";
        
        foreach ($paid_months as $payment_name => $months) {
            $wa_message .= $payment_name.":\n";
            foreach ($months as $month) {
                $wa_message .= "- ".$month['month_name'].": Rp ".number_format($month['amount'], 0, ',', '.')."\n";
            }
            $wa_message .= "\n";
        }
        
        $wa_message .= "*Terima kasih atas pembayarannya.* \n\n_Ini adalah pesan otomatis, tidak perlu dibalas_";

        // Kirim via API Gateway WA
        $postData = [
            "data" => [
                [
                    'phone' => $phone_number,
                    'message' => $wa_message
                ]
            ]
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: ".$api_token,
            "Content-Type: application/json"
        ]);
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Log hasil pengiriman
        if (curl_errno($ch) || $http_code != 200) {
            log_message('error', 'Gagal mengirim WA: '.$result);
        } else {
            log_message('info', 'WA terkirim ke '.$phone_number);
        }
        curl_close($ch);
      }
  
      // Kirim feedback ke pengguna
      if ($success_count > 0) {
          $this->session->set_flashdata('success', "$success_count pembayaran berhasil diproses.");
      }
  
      if ($failure_count > 0) {
          $this->session->set_flashdata('error', "$failure_count pembayaran gagal diproses.");
      }
  
      redirect('manage/payout');
  }
  
  
  
public function send_reminder()
{
    $post_data = $this->input->post('reminders'); // Data tagihan yang dipilih (array)
    if (empty($post_data)) {
        $this->session->set_flashdata('error', 'Tidak ada tagihan yang dipilih untuk dikirimkan pemberitahuan.');
        redirect('manage/payout');
        return;
    }

    // Ambil data WhatsApp Gateway dari database
    $api_url = $this->Setting_model->get_value(['id' => 8]); // Ambil setting_wa_gateway_url
    $api_token = $this->Setting_model->get_value(['id' => 9]); // Ambil setting_wa_api_key

    if (empty($api_url) || empty($api_token)) {
        log_message('error', "WhatsApp API Gateway URL atau API Key tidak ditemukan di database.");
        $this->session->set_flashdata('error', 'Konfigurasi WhatsApp Gateway tidak ditemukan.');
        redirect('manage/payout');
        return;
    }

    $reminder_groups = [];
    $student_id = null;

    foreach ($post_data as $reminder) {
        $reminder_data = json_decode($reminder, true);

        if (!isset($reminder_data['bulan_id'], $reminder_data['student_id'], $reminder_data['amount'])) {
            continue;
        }

        $bulan_id = $reminder_data['bulan_id'];
        $student_id = $reminder_data['student_id'];
        $amount = $reminder_data['amount'];

        $bulan = $this->Bulan_model->get(['id' => $bulan_id]);
        if ($bulan) {
            $key = $bulan['pos_name'] . ' - T.A ' . $bulan['period_start'] . '/' . $bulan['period_end'];

            if (!isset($reminder_groups[$key])) {
                $reminder_groups[$key] = [];
            }

            $reminder_groups[$key][] = [
                'month_name' => $bulan['month_name'],
                'amount' => $amount
            ];
        }
    }

    if (!empty($reminder_groups) && $student_id) {
        $student = $this->Student_model->get(['id' => $student_id]);
        if ($student) {
            $phone_number = preg_replace('/[^0-9]/', '', $student['student_parent_phone']);
            if (strpos($phone_number, '62') !== 0) {
                $phone_number = '62' . substr($phone_number, 1);
            }

            $message = "*Assalamu'alaikum* Bapak/Ibu {$student['student_name_of_father']},\n\n"
                . "Kami ingin mengingatkan bahwa anak Anda, {$student['student_full_name']}, *memiliki tagihan Bulanan yang belum dibayar*:\n\n";

            foreach ($reminder_groups as $payment_name => $months) {
                $message .= "$payment_name:\n";
                foreach ($months as $month) {
                    $message .= "- {$month['month_name']}: Rp. " . number_format($month['amount'], 0, ',', '.') . "\n";
                }
                $message .= "\n";
            }

            $message .= "Kami mohon untuk segera melakukan pembayaran. Terima kasih atas perhatian dan kerjasamanya.";

            // Kirim pesan WhatsApp melalui API Gateway
            $postData = [
                "data" => [
                    [
                        'phone' => $phone_number,
                        'message' => $message
                    ]
                ]
            ];

            $jsonData = json_encode($postData);

            // Kirim request ke API Gateway
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: $api_token",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $response = json_decode($result, true);

            if (curl_errno($ch) || $http_code != 200 || !isset($response['status']) || $response['status'] != true) {
                log_message('error', "WhatsApp gagal dikirim. Pesan: " . json_encode($response));
                $this->session->set_flashdata('error', 'Gagal mengirim pemberitahuan WhatsApp.');
            } else {
                $this->session->set_flashdata('success', 'Pemberitahuan WhatsApp berhasil dikirim.');
            }

            curl_close($ch);

            // === KIRIM NOTIFIKASI FCM ===
            $this->db->select('fcm_token');
            $this->db->from('student_tokens');
            $this->db->where('student_id', $student_id);
            $query = $this->db->get();
            $fcm_tokens = array_column($query->result_array(), 'fcm_token');

            if (!empty($fcm_tokens)) {
                $title = "Pengingat Pembayaran";
                $body = "Tagihan anak Anda {$student['student_full_name']} belum dibayar:\n";
                foreach ($reminder_groups as $payment_name => $months) {
                    $body .= "\n$payment_name\n";
                    foreach ($months as $month) {
                        $body .= "- {$month['month_name']}: Rp. " . number_format($month['amount'], 0, ',', '.') . "\n";
                    }
                }
                $body .= "\nSegera lakukan pembayaran. Terima kasih 🙏";

                $batch_size = 500;
                $token_chunks = array_chunk($fcm_tokens, $batch_size);

                foreach ($token_chunks as $tokens) {
                    $fcm_url = "https://notifikasi.ppalmaruf.com/send_fcm.php";
                    $fcm_data = json_encode([
                        "fcm_tokens" => $tokens,
                        "title" => $title,
                        "body" => $body
                    ]);

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $fcm_url);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fcm_data);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, [
                        "Content-Type: application/json"
                    ]);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                    $result = curl_exec($ch);
                    curl_close($ch);

                    log_message('info', "Notifikasi FCM dikirim ke " . count($tokens) . " token: " . $result);
                }
            } else {
                log_message('error', "Tidak ada token FCM ditemukan untuk student_id: $student_id");
            }
        }
    } else {
        $this->session->set_flashdata('error', 'Tidak ada tagihan yang belum dibayar.');
    }

    redirect('manage/payout');
}




public function pay($payment_id = NULL, $student_id = NULL, $id = NULL) {
  // Cek apakah student ada
  $student = $this->Bulan_model->get(['student_id' => $student_id, 'id' => $id]);
  if (!$student) {
      log_message('error', "Pembayaran gagal: Data siswa tidak ditemukan (student_id: $student_id)");
      $this->session->set_flashdata('error', 'Pembayaran gagal: Data siswa tidak ditemukan.');
      redirect('manage/payout');
      return;
  }

  // Generate nomor pembayaran
  $lastletter = $this->Letter_model->get(['limit' => 1]);
  if (!$lastletter || $lastletter['letter_year'] < date('Y')) {
      $this->Letter_model->add(['letter_number' => '00001', 'letter_month' => date('m'), 'letter_year' => date('Y')]);
      $nofull = sprintf('%04d%02d%05d', date('Y'), date('m'), 1);
  } else {
      $nomor = $lastletter['letter_number'] + 1;
      $this->Letter_model->add(['letter_number' => $nomor, 'letter_month' => date('m'), 'letter_year' => date('Y')]);
      $nofull = sprintf('%04d%02d%05d', date('Y'), date('m'), $nomor);
  }

  // Simpan pembayaran
  $pay = [
      'bulan_id' => $id,
      'bulan_number_pay' => $nofull,
      'bulan_date_pay' => date('Y-m-d H:i:s'),
      'bulan_last_update' => date('Y-m-d H:i:s'),
      'bulan_status' => 1,
      'user_user_id' => $this->session->userdata('uid')
  ];
  $this->Bulan_model->add($pay);

  // Simpan log transaksi
  $log = [
      'bulan_bulan_id' => $id,
      'student_student_id' => $student_id,
      'bebas_pay_bebas_pay_id' => NULL,
      'log_trx_input_date' => date('Y-m-d H:i:s'),
      'log_trx_last_update' => date('Y-m-d H:i:s'),
  ];
  $this->Log_trx_model->add($log);

  // Ambil token FCM terbaru untuk siswa
  $this->db->where('student_id', $student_id);
  $this->db->where('fcm_token IS NOT NULL');
  $this->db->order_by('created_at', 'DESC'); // Ambil token terbaru
  $fcm_data = $this->db->get('student_tokens')->row_array();

  if (!empty($fcm_data['fcm_token'])) {
      $title = "Pembayaran Berhasil";
      $message = "Pembayaran Anak Anda untuk bulan Database telah kami Terima.";

      // Kirim notifikasi ke server PHP 7+ untuk diteruskan ke Firebase
      $this->send_fcm_notification($fcm_data['fcm_token'], $title, $message);
  }

  // Kirim pesan WhatsApp melalui Wablas
  $phone_number = preg_replace('/[^0-9]/', '', $student['student_parent_phone']);
  if (strpos($phone_number, '62') !== 0) {
      $phone_number = '62' . substr($phone_number, 1);
  }

  if (strlen($phone_number) >= 11) {
      $message = "Assalamu'alaikum Bapak/Ibu {$student['student_name_of_father']},\n\n"
          . "Kami ingin menginformasikan bahwa pembayaran Bulanan anak Anda, {$student['student_full_name']}, "
          . "untuk bulan {$student['month_name']} telah berhasil diproses.\n\n"
          . "Nomor Pembayaran: {$nofull}\n"
          . "Tanggal: " . date('d-m-Y H:i:s') . "\n"
          . "Jumlah: Rp. " . number_format($student['bulan_bill'], 0, ',', '.') . "\n\n"
          . "Terima kasih atas perhatian dan kerjasamanya.";

      $this->send_whatsapp_notification($phone_number, $message);
  } else {
      log_message('error', "Nomor WhatsApp tidak valid: $phone_number");
  }

  $this->session->set_flashdata('success', 'Pembayaran berhasil diproses.');
  redirect('manage/payout?n=' . $student['period_period_id'] . '&r=' . $student['student_nis']);
}

// Fungsi untuk mengirim notifikasi ke server PHP 7+ yang akan mengirim FCM
private function send_fcm_notification($student_id, $title, $message) {
  // Ambil token FCM terbaru
  $this->db->where('student_id', $student_id);
  $this->db->where('fcm_token IS NOT NULL');
  $this->db->order_by('created_at', 'DESC'); // Ambil token terbaru
  $fcm_data = $this->db->get('student_tokens')->row_array();

  if (empty($fcm_data['fcm_token'])) {
      log_message('error', "FCM Token tidak ditemukan untuk student_id: $student_id");
      return false;
  }

  $fcm_token = $fcm_data['fcm_token'];

  // Data yang akan dikirim ke server PHP 7+
  $data = [
      "fcm_token" => $fcm_token,
      "title" => $title,
      "body" => $message
  ];

  $ch = curl_init("https://notifikasi.ppalmaruf.com/send_fcm.php");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_POST, 1);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
  curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);

  $result = curl_exec($ch);
  $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  if ($http_code != 200) {
      log_message('error', "FCM gagal dikirim: " . curl_error($ch));
      return false;
  }

  curl_close($ch);
  return true;
}


private function generatePaymentNumber($lastletter) {
  // Cek apakah ada data pada $lastletter
  if ($lastletter && isset($lastletter['letter_year']) && $lastletter['letter_year'] < date('Y')) {
      // Jika tahun baru, reset nomor menjadi 00001
      $this->Letter_model->add(array(
          'letter_number' => '00001',
          'letter_month' => date('m'),
          'letter_year' => date('Y')
      ));
      $nomor = sprintf('%05d', 1); // Format nomor menjadi 5 digit (00001)
  } elseif ($lastletter) {
      // Jika masih dalam tahun yang sama, tambahkan 1 pada nomor terakhir
      $nomor = sprintf('%05d', $lastletter['letter_number'] + 1); // Format nomor menjadi 5 digit
      $this->Letter_model->add(array(
          'letter_number' => $nomor,
          'letter_month' => date('m'),
          'letter_year' => date('Y')
      ));
  } else {
      // Jika tidak ada data sama sekali, buat data baru
      $this->Letter_model->add(array(
          'letter_number' => '00001',
          'letter_month' => date('m'),
          'letter_year' => date('Y')
      ));
      $nomor = sprintf('%05d', 1); // Format nomor menjadi 5 digit (00001)
  }

  // Gabungkan tahun, bulan, dan nomor untuk menghasilkan nomor pembayaran lengkap
  return date('Y') . date('m') . $nomor;
}


  function not_pay($payment_id = NULL, $student_id =NULL, $id = NULL) { 
    $student = $this->Bulan_model->get(array('student_id'=>$student_id,'id'=>$id));
    $pay = array(
      'bulan_id' => $id,
      'bulan_number_pay' => NULL,
      'bulan_status' => 0,
      'bulan_date_pay' => NULL,
      'bulan_last_update' => date('Y-m-d H:i:s'),
      'user_user_id' => NULL
    );

    
    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bulan_id' => $id
    ));



    $this->Bulan_model->add($pay);
    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Hapus Pembayaran Berhasil');
      redirect('manage/payout?n='.$student['period_period_id'].'&r='.$student['student_nis']);
    }
  }


  public function delete_all_bills($student_id = NULL) {
    // Pastikan hanya admin atau user tertentu yang memiliki akses
    if ($this->session->userdata('uroleid') != SUPERUSER) {
        $this->session->set_flashdata('error', 'Anda tidak memiliki akses untuk melakukan aksi ini.');
        redirect('manage/payout');
        return;
    }

    if ($student_id == NULL) {
        $this->session->set_flashdata('error', 'ID siswa tidak ditemukan.');
        redirect('manage/payout');
        return;
    }

    // Ambil data tagihan siswa
    $bills_bulan = $this->Bulan_model->get(array('student_id' => $student_id));
    $bills_bebas = $this->Bebas_model->get(array('student_id' => $student_id));

    // Hapus tagihan bulanan
    if (!empty($bills_bulan)) {
        foreach ($bills_bulan as $bill) {
            $this->Log_trx_model->delete_log(array('bulan_id' => $bill['bulan_id']));
            $this->Bulan_model->delete($bill['bulan_id']);
        }
    }

    // Hapus tagihan bebas
    if (!empty($bills_bebas)) {
        foreach ($bills_bebas as $bill) {
            $this->Log_trx_model->delete_log(array('bebas_id' => $bill['bebas_id']));
            $this->Bebas_model->delete($bill['bebas_id']);
            $this->Bebas_pay_model->delete_by_bebas_id($bill['bebas_id']);
        }
    }

    // Berikan pesan berhasil
    $this->session->set_flashdata('success', 'Semua tagihan siswa berhasil dihapus.');
    redirect('manage/payout');
}


  function printPay($payment_id = NULL, $student_id =NULL, $id = NULL) {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('manage/payout/payout_bulan/'.$payment_id.'/'.$student_id);

    $data['printpay'] = $this->Bulan_model->get(array('id' =>$id));

    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE)); 
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY)); 

    $html = $this->load->view('payout/payout_pdf', $data, true);
    $data = pdf_create($html, $data['printpay']['student_full_name'], TRUE, 'A4', TRUE);
  }

  function printPayFree($payment_id = NULL, $student_id =NULL, $id = NULL) {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));

    if ($id == NULL)
      redirect('manage/payout/payout_bebas/'.$payment_id.'/'.$student_id);

    $data['printpay'] = $this->Bebas_pay_model->get(array('id' =>$id));

    $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
    $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
    $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
    $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
    $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));  
    $data['bebas'] = $this->Bebas_model->get(array('payment_id' => $payment_id, 'student_id' => $student_id));

    $data['total_bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['total_bill'] += $key['bebas_total_pay'];
    }

    $data['bill'] = 0;
    foreach ($data['bebas'] as $key) {
      $data['bill'] += $key['bebas_bill'];
    }

    $html = $this->load->view('payout/payout_free_pdf', $data, true);
    $data = pdf_create($html, $data['printpay']['student_full_name'], TRUE, 'A4', TRUE);
  }

  function multiple() {
    $this->load->helper(array('dompdf'));
    $this->load->helper(array('tanggal'));
    $action = $this->input->post('action');
    $print = array();
    if ($action == "printAll") {
      $bln = $this->input->post('msg');
      for ($i = 0; $i < count($bln); $i++) {
        $print[] = $bln[$i];
      }

      $data['printpay'] = $this->Bulan_model->get(array('multiple_id' => $print, 'group'=>TRUE));
      $data['pay'] = $this->Bulan_model->get(array('multiple_id' => $print));

      $data['total_pay'] = 0;
      foreach ($data['pay'] as $row) {
        $data['total_pay'] += $row['bulan_bill'];
      }

      $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
      $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
      $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
      $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
      $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY)); 

      $html = $this->load->view('payout/payout_bulan_multiple_pdf', $data, true);
      $data = pdf_create($html, 'Tagihan_Pembayaran_'.date('d_m_Y'), TRUE, 'A4', TRUE);

    } 
    redirect('manage/payout');
  }

  function delete_pay_free($payment_id = NULL, $student_id =NULL, $bebas_id = NULL, $id =NULL) {

    $total_pay = $this->Bebas_pay_model->get(array('id'=>$id));

    $this->Bebas_model->add(
      array(
        'decrease_budget'=> $total_pay['bebas_pay_bill'],
        'bebas_id'=>$bebas_id
      )
    );

    $this->Log_trx_model->delete_log(array(
      'student_id' => $student_id,
      'bebas_pay_id' => $id
    ));

    $this->Bebas_pay_model->delete($id);

    if ($this->input->is_ajax_request()) {
      echo $status;
    } else {
      $this->session->set_flashdata('success', 'Delete Berhasil');
      redirect('manage/payout/payout_bebas/' . $payment_id.'/'.$student_id.'/'.$bebas_id);
    }
    
  }

// Delete to database
  public function delete($id = NULL) {
    if ($this->session->userdata('uroleid')!= SUPERUSER){
      redirect('manage');
    }
    if ($_POST) {
      $this->Payment_model->delete($id);
// activity log
      $this->load->model('logs/Logs_model');
      $this->Logs_model->add(
        array(
          'log_date' => date('Y-m-d H:i:s'),
          'user_id' => $this->session->userdata('uid'),
          'log_module' => 'Jenis Pembayaran',
          'log_action' => 'Hapus',
          'log_info' => 'ID:' . $id . ';Title:' . $this->input->post('delName')
        )
      );
      $this->session->set_flashdata('success', 'Hapus Jenis Pembayran berhasil');
      redirect('manage/payment');
    } elseif (!$_POST) {
      $this->session->set_flashdata('delete', 'Delete');
      redirect('manage/payment/edit/' . $id);
    }
  }


}