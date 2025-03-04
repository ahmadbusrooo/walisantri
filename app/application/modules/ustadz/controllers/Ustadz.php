<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ustadz extends MX_Controller {

    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            redirect('manage/auth/login');
        }

        $this->load->model('ustadz/Ustadz_model');
        $this->load->model('setting/Setting_model');
        $this->load->model('class/Class_model');
        $this->load->helper(array('form', 'url'));
    }

    // Menampilkan daftar ustadz dengan nama kelasnya
    public function index() {
        $data['ustadz'] = $this->Ustadz_model->get_all_ustadz();
        $data['title'] = 'Data Ustadz';
        $data['main'] = 'ustadz/ustadz_list';
        $this->load->view('manage/layout', $data);
    }
    public function printPdf() {
        $this->load->helper('dompdf');
        $this->load->model('Ustadz_model');
    
        $ustadz_ids = $this->input->post('ustadz_ids');
        if (empty($ustadz_ids)) {
            $this->session->set_flashdata('failed', 'Tidak ada ustadz yang dipilih');
            redirect('ustadz');
        }
    
        $ustadz_ids = explode(",", $ustadz_ids);
        $data['ustadz'] = $this->Ustadz_model->get_ustadz_by_ids($ustadz_ids);
    
        // Ambil data sekolah untuk header laporan
        $this->load->model('Setting_model');
        $data['setting_school'] = $this->Setting_model->get(array('id' => SCHOOL_NAME));
        $data['setting_address'] = $this->Setting_model->get(array('id' => SCHOOL_ADRESS));
        $data['setting_phone'] = $this->Setting_model->get(array('id' => SCHOOL_PHONE));
        $data['setting_district'] = $this->Setting_model->get(array('id' => SCHOOL_DISTRICT));
        $data['setting_city'] = $this->Setting_model->get(array('id' => SCHOOL_CITY));
    
        // Load tampilan PDF dan konversi menjadi file
        $html = $this->load->view('ustadz/ustadz_pdf', $data, true);
        pdf_create($html, 'LAPORAN_USTADZ_' . date('d_m_Y'), TRUE, 'A4', 'landscape');
    }
    
    
    public function send_multiple_wa()
    {
        $ustadz_ids = $this->input->post('ustadz'); // Ambil daftar ID ustadz yang dipilih
        $message = $this->input->post('message'); // Ambil pesan yang diketik di modal
    
        if (empty($ustadz_ids) || empty($message)) {
            echo json_encode(["status" => "error", "message" => "Data tidak lengkap."]);
            return;
        }
    
        // Load model untuk mendapatkan nomor WhatsApp ustadz
        $this->load->model('Ustadz_model');
        $recipients = $this->Ustadz_model->get_ustadz_phones($ustadz_ids);
    
        if (empty($recipients)) {
            echo json_encode(["status" => "error", "message" => "Tidak ada nomor WA yang ditemukan."]);
            return;
        }
    
        // API Wablas
        $token = "C5ZefdADVrejALPpeCn1rYPZ3OQaKuEszSQgXrpbQXPoKjt2sFzfXWT0jiSbs2Pg"; // Ganti dengan API Key Wablas Anda
        $secret_key = "tgw6gVhz"; // Ganti dengan Secret Key Wablas Anda
        $url = "https://tegal.wablas.com/api/v2/send-message";
    
        // Format data sesuai dokumentasi terbaru Wablas
        $payload = [
            "data" => []
        ];
    
        foreach ($recipients as $phone) {
            $payload["data"][] = [
                'phone' => $phone,
                'message' => $message,
            ];
        }
    
        // Kirim request ke API Wablas
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            "Authorization: $token.$secret_key",
            "Content-Type: application/json"
        ));
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    
        $result = curl_exec($curl);
        curl_close($curl);
    
        echo json_encode(["status" => "success", "message" => "Pesan berhasil dikirim!", "response" => json_decode($result)]);
    }
    
    // Form tambah/edit ustadz
    public function form($id = null) {
        $this->load->model('Class_model'); // Pastikan model class sudah diload
        $this->load->model('Ustadz_model'); // Model untuk ustadz
    
        $data['title'] = $id ? "Edit Ustadz" : "Tambah Ustadz";
        $data['classes'] = $this->Class_model->get_all_classes(); // Ambil daftar kelas
    
        if ($id) {
            $data['ustadz'] = $this->Ustadz_model->get_ustadz_by_id($id);
        }

        $data['main'] = 'ustadz/ustadz_form'; // Pastikan view form ustadz sesuai
        $this->load->view('manage/layout', $data);
    }

    // Simpan data ustadz
    // Simpan data ustadz
    public function save() {
        $data = [
            'ustadz_nama' => $this->input->post('ustadz_nama'),
            'ustadz_nik' => $this->input->post('ustadz_nik'),
            'ustadz_tgl_lahir' => $this->input->post('ustadz_tgl_lahir'),
            'ustadz_status' => $this->input->post('ustadz_status'),
            'ustadz_alamat' => $this->input->post('ustadz_alamat'),
            'ustadz_telepon' => $this->input->post('ustadz_telepon'),
            'class_id' => $this->input->post('class_id')
        ];

        if ($this->input->post('ustadz_id')) {
            $data['ustadz_id'] = $this->input->post('ustadz_id');
        }

        $result = $this->Ustadz_model->save_ustadz($data);

        if (isset($result['status']) && $result['status'] == 'error') {
            $this->session->set_flashdata('error', $result['message']);
            $this->session->set_flashdata('ustadz_data', $data); // Simpan data sementara agar tidak hilang
            redirect('ustadz/form');
        } else {
            $this->session->set_flashdata('success', 'Data Ustadz berhasil disimpan!');
            redirect('ustadz');
        }
    }

    // Hapus data ustadz
    public function delete($id) {
        $this->Ustadz_model->delete_ustadz($id);
        $this->session->set_flashdata('success', 'Data Ustadz berhasil dihapus!');
        redirect('ustadz');
    }

}
