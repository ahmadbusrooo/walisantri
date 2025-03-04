<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            redirect('manage/auth/login');
        }

        $this->load->model('pengurus/Pengurus_model');
        $this->load->model('setting/Setting_model');

        $this->load->helper(array('form', 'url'));
    }

    public function index() {
        $data['pengurus'] = $this->Pengurus_model->get_all_pengurus();
        $data['title'] = 'Data Pengurus';
        $data['main'] = 'pengurus/pengurus_list';
        $this->load->view('manage/layout', $data);
    }

    public function form($id = null) {
        $data['title'] = $id ? "Edit Pengurus" : "Tambah Pengurus";

        if ($id) {
            $data['pengurus'] = $this->Pengurus_model->get_pengurus_by_id($id);
        }

        $data['main'] = 'pengurus/pengurus_form';
        $this->load->view('manage/layout', $data);
    }

    public function save() {
        $data = [
            'pengurus_nama' => $this->input->post('pengurus_nama'),
            'pengurus_nik' => $this->input->post('pengurus_nik'),
            'pengurus_tgl_lahir' => $this->input->post('pengurus_tgl_lahir'),
            'pengurus_status' => $this->input->post('pengurus_status'),
            'pengurus_alamat' => $this->input->post('pengurus_alamat'),
            'pengurus_telepon' => $this->input->post('pengurus_telepon'),
            'pengurus_jabatan' => $this->input->post('pengurus_jabatan')
        ];

        if ($this->input->post('pengurus_id')) {
            $data['pengurus_id'] = $this->input->post('pengurus_id');
        }

        $result = $this->Pengurus_model->save_pengurus($data);

        if (isset($result['status']) && $result['status'] == 'error') {
            $this->session->set_flashdata('error', $result['message']);
            redirect('pengurus/form');
        } else {
            $this->session->set_flashdata('success', 'Data Pengurus berhasil disimpan!');
            redirect('pengurus');
        }
    }

    public function printPdf() {
        $this->load->helper('dompdf');
        $this->load->model('Pengurus_model');
    
        $pengurus_ids = $this->input->post('pengurus_ids');
        if (empty($pengurus_ids)) {
            $this->session->set_flashdata('failed', 'Tidak ada pengurus yang dipilih');
            redirect('pengurus');
        }
    
        $pengurus_ids = explode(",", $pengurus_ids);
        $data['pengurus'] = $this->Pengurus_model->get_active_pengurus_by_ids($pengurus_ids);
    
        if (empty($data['pengurus'])) {
            $this->session->set_flashdata('failed', 'Tidak ada pengurus aktif yang dipilih.');
            redirect('pengurus');
        }
    
        // Ambil data sekolah untuk header laporan
        $this->load->model('Setting_model');
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    
        // Load tampilan PDF dan konversi menjadi file
        $html = $this->load->view('pengurus/pengurus_pdf', $data, true);
        pdf_create($html, 'LAPORAN_PENGURUS_AKTIF_' . date('d_m_Y'), TRUE, 'A4', 'landscape');
    }
    
    

    public function send_multiple_wa() {
        $pengurus_ids = $this->input->post('pengurus'); // Ambil daftar ID pengurus yang dipilih
        $message = $this->input->post('message'); // Ambil pesan dari modal
    
        if (empty($pengurus_ids) || empty($message)) {
            echo json_encode(["status" => "error", "message" => "Pilih pengurus aktif dan isi pesan!"]);
            return;
        }
    
        // Load model untuk mendapatkan nomor WhatsApp pengurus AKTIF
        $this->load->model('Pengurus_model');
        $recipients = $this->Pengurus_model->get_active_pengurus_phones($pengurus_ids);
    
        if (empty($recipients)) {
            echo json_encode(["status" => "error", "message" => "Tidak ada pengurus aktif dengan nomor WA."]);
            return;
        }
    
        // Ambil data WhatsApp Gateway dari database
        $this->load->model('Setting_model');
        $api_url = $this->Setting_model->get_value(['id' => 8]); // setting_wa_gateway_url
        $api_token = $this->Setting_model->get_value(['id' => 9]); // setting_wa_api_key
    
        if (empty($api_url) || empty($api_token)) {
            log_message('error', "WhatsApp API Gateway URL atau API Key tidak ditemukan di database.");
            echo json_encode(["status" => "error", "message" => "Konfigurasi WhatsApp Gateway tidak ditemukan."]);
            return;
        }
    
        // Format data sesuai dokumentasi terbaru WhatsApp API Gateway
        $payload = ["data" => []];
    
        foreach ($recipients as $phone) {
            $payload["data"][] = [
                'phone' => $phone,
                'message' => $message,
            ];
        }
    
        $jsonData = json_encode($payload);
    
        // Kirim request ke API WhatsApp Gateway
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: $api_token",
            "Content-Type: application/json"
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    
        $result = curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $response = json_decode($result, true);
    
        if (curl_errno($curl)) {
            log_message('error', "Curl error: " . curl_error($curl));
        }
    
        curl_close($curl);
    
        // Jika HTTP Response tidak 200 atau respons API tidak sesuai
        if ($http_code != 200 || empty($response) || !isset($response['status'])) {
            log_message('error', "WhatsApp gagal dikirim. HTTP Code: $http_code, Response: " . json_encode($response));
            echo json_encode(["status" => "error", "message" => "Gagal mengirim pesan WhatsApp."]);
            return;
        }
    
        // Pastikan status dari API adalah `true`
        if ($response['status'] !== true) {
            log_message('error', "WhatsApp API response error: " . json_encode($response));
            echo json_encode(["status" => "error", "message" => "Gagal mengirim pesan WhatsApp."]);
            return;
        }
    
        // Jika berhasil, kembalikan pesan sukses
        echo json_encode(["status" => "success", "message" => "Pesan berhasil dikirim!"]);
    }
    
    

    public function delete($id) {
        $this->Pengurus_model->delete_pengurus($id);
        $this->session->set_flashdata('success', 'Data Pengurus berhasil dihapus!');
        redirect('pengurus');
    }
}
?>
