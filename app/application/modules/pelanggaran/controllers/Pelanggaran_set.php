<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggaran_set extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student/Student_model');
        $this->load->model('pelanggaran/Pelanggaran_model');
        $this->load->model('period/Period_model');
        $this->load->model('setting/Setting_model');

    }

    // Halaman utama pelanggaran dengan filter
    public function index()
    {
        $f = $this->input->get(NULL, TRUE);
        $active_period = $this->Period_model->get_active_period();
    
        $data['f'] = $f;
        $data['period'] = $this->Period_model->get();
        $data['santri'] = $this->Student_model->get();
    
        // Default nilai
        $data['santri_selected'] = [];
        $data['pelanggaran'] = [];
        $data['selected_period'] = NULL;
        $data['total_points'] = 0;
        $data['monthly_violations'] = [];
        $data['yearly_violations'] = [];
    
        if (isset($f['n']) && isset($f['r']) && !empty($f['n']) && !empty($f['r'])) {
            $data['santri_selected'] = $this->Student_model->get_by_nis($f['r']);
    
            // Pastikan data student_name_of_father dan student_parent_phone tersedia
            $data['santri_selected']['student_name_of_father'] = isset($data['santri_selected']['student_name_of_father']) ? $data['santri_selected']['student_name_of_father'] : 'Tidak Diketahui';
            $data['santri_selected']['student_parent_phone'] = isset($data['santri_selected']['student_parent_phone']) ? $data['santri_selected']['student_parent_phone'] : 'Tidak Tersedia';
    
            if (!empty($data['santri_selected']) && isset($data['santri_selected']['student_id'])) {
                $student_id = $data['santri_selected']['student_id'];
                $selected_period = $f['n'];
    
                $data['pelanggaran'] = $this->Pelanggaran_model->get_by_student_period($student_id, $selected_period);
                $data['selected_period'] = $selected_period;
    
                // Dapatkan total poin siswa berdasarkan periode yang dipilih
                $data['total_points'] = $this->Student_model->get_total_points_by_period($student_id, $selected_period);
    
                // Data pelanggaran bulanan dan tahunan
                $data['monthly_violations'] = $this->Pelanggaran_model->get_monthly_violations($student_id, $selected_period);
                $data['yearly_violations'] = $this->Pelanggaran_model->get_yearly_violations($student_id, $selected_period);
            }
        }
        $data['top_violators'] = [];
        // Jika tidak ada filter, tampilkan peringkat
        if (!isset($f['n']) && !isset($f['r'])) {
            $data['top_violators'] = $this->Pelanggaran_model->get_top_violators_active_period(10);
        }
        $data['active_period'] = $active_period;
        $data['title'] = 'Kelola Pelanggaran Santri';
        $data['main'] = 'pelanggaran/pelanggaran_filter';
        $this->load->view('manage/layout', $data);
    }
    

    // Tambah pelanggaran baru
    public function add()
    {
        if ($_POST) {
            $data = [
                'student_id' => $this->input->post('student_id', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'poin' => 1, // Default 1 (opsional, jika ingin double check)
                'pelanggaran' => $this->input->post('pelanggaran', TRUE),
                'tindakan' => $this->input->post('tindakan', TRUE),
                'catatan' => $this->input->post('catatan', TRUE),
            ];

            // Validasi input
            if (empty($data['period_id'])) {
                $this->session->set_flashdata('error', 'Tahun ajaran tidak valid.');
                redirect('manage/pelanggaran');
            }

            $student = $this->Student_model->get_by_id($data['student_id']);
            if ($student) {
                $data['class_id'] = $student['class_class_id'];
            } else {
                $this->session->set_flashdata('error', 'Santri tidak ditemukan.');
                redirect('manage/pelanggaran');
            }

            // Simpan data pelanggaran
            $this->Pelanggaran_model->add($data);
            $this->session->set_flashdata('success', 'Data pelanggaran berhasil ditambahkan.');
            redirect('manage/pelanggaran?n=' . $data['period_id'] . '&r=' . $student['student_nis']);
        }
    }

    // Pencarian santri dengan fitur autocomplete
    public function search_santri()
    {
        $keyword = $this->input->get('keyword');
        $santri = $this->Student_model->search_santri($keyword);

        $results = [];
        foreach ($santri as $row) {
            $results[] = [
                'id' => $row['student_nis'],
                'text' => $row['student_nis'] . ' - ' . $row['student_full_name']
            ];
        }

        echo json_encode($results);
    }

    // Kirim notifikasi WhatsApp
    public function send_whatsapp($id)
    {
        // Ambil data pelanggaran berdasarkan ID
        $dataPelanggaran = $this->Pelanggaran_model->get_by_id($id);

        // Periksa apakah data pelanggaran ditemukan
        if (!$dataPelanggaran) {
            $this->session->set_flashdata('error', 'Data pelanggaran tidak ditemukan.');
            redirect('manage/pelanggaran');
            return;
        }

        // Ambil data siswa berdasarkan student_id dari pelanggaran
        $dataSiswa = $this->Student_model->get_by_id($dataPelanggaran['student_id']);
        if (!$dataSiswa) {
            $this->session->set_flashdata('error', 'Data siswa tidak ditemukan.');
            redirect('manage/pelanggaran');
            return;
        }

        // Validasi nomor telepon wali
        $phone_number = preg_replace('/[^0-9]/', '', $dataSiswa['student_parent_phone']); // Hanya angka
        if (strpos($phone_number, '62') !== 0) {
            $phone_number = '62' . substr($phone_number, 1); // Ubah "08" menjadi "628"
        }

        if (empty($phone_number)) {
            $this->session->set_flashdata('error', 'Nomor WhatsApp wali tidak ditemukan.');
            redirect('manage/pelanggaran');
            return;
        }

        function format_tanggal_indonesia($tanggal) {
            $hari = array(
                'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
            );
            
            $bulan = array(
                1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            );
    
            $date = DateTime::createFromFormat('Y-m-d', $tanggal);
            $nama_hari = $hari[(int)$date->format('w')];
            $tanggal_format = $date->format('j') . ' ' . $bulan[(int)$date->format('n')] . ' ' . $date->format('Y');
            
            return $nama_hari . ', ' . $tanggal_format;
        }

        // Format pesan WhatsApp
        $tanggal_indonesia = format_tanggal_indonesia($dataPelanggaran['tanggal']);
    
        $message = "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
            . "Kepada Yth. Bapak/Ibu {$dataSiswa['student_name_of_father']},\n\n"
            . "Dengan hormat, kami sampaikan bahwa pada:\n"
            . "*Tanggal* : {$tanggal_indonesia}\n"
            . "*Nama Santri* : {$dataSiswa['student_full_name']}\n"
            . "*Pelanggaran* : {$dataPelanggaran['pelanggaran']}\n"
            . "*Tindakan* : {$dataPelanggaran['tindakan']}\n"
            . "*Catatan* : {$dataPelanggaran['catatan']}\n\n"
            . "Kami mengharapkan kerja sama Bapak/Ibu untuk memberikan pembinaan dan pengarahan kepada putra/putri Kamu Ya.\n\n"
            . "Atas perhatian dan kerja samanya, kami ucapkan terima kasih.\n\n"
            . "Wassalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
            . "_Salam Hormat,_\n_Tim Kedisiplinan Pondok Pesantren_";
    

        // **AMBIL API URL DAN TOKEN DARI DATABASE**
        $api_url = $this->Setting_model->get_value(['id' => 8]); // Ambil setting_wa_gateway_url
        $api_token = $this->Setting_model->get_value(['id' => 9]); // Ambil setting_wa_api_key

        // **Validasi apakah API URL dan Token ditemukan**
        if (empty($api_url) || empty($api_token)) {
            log_message('error', "WhatsApp API Gateway URL atau API Key tidak ditemukan di database.");
            $this->session->set_flashdata('error', 'Konfigurasi WhatsApp Gateway tidak ditemukan.');
            redirect('manage/pelanggaran');
            return;
        }

        // Data untuk API WhatsApp
        $postData = [
            "data" => [
                [
                    'phone' => $phone_number, // Nomor telepon wali
                    'message' => $message     // Pesan yang akan dikirim
                ]
            ]
        ];

        // Konversi data menjadi JSON
        $jsonData = json_encode($postData);

        // Kirim request ke API WhatsApp Gateway
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData); // Kirim data sebagai JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: $api_token",
            "Content-Type: application/json" // Header JSON
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); // Nonaktifkan sementara (debug)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // Nonaktifkan sementara (debug)
        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
        }
        curl_close($ch);

        // Debug respons API WhatsApp
        if (isset($error_msg)) {
            log_message('error', "Curl Error: $error_msg");
            $this->session->set_flashdata('error', "Curl Error: $error_msg");
            redirect('manage/pelanggaran');
            return;
        }

        $response = json_decode($result, true);

        // Periksa respons dari API WhatsApp
        if ($http_code == 200 && isset($response['status']) && $response['status'] == true) {
            $this->session->set_flashdata('success', 'Pesan WhatsApp berhasil dikirim ke wali siswa.');
        } else {
            $error_message = isset($response['message']) ? $response['message'] : 'Gagal mengirim pesan WhatsApp. Silakan coba lagi.';
            log_message('error', "WhatsApp API Error: $error_message");
            $this->session->set_flashdata('error', $error_message);
        }

        // === KIRIM NOTIFIKASI FCM ===
        // Ambil token FCM dari database
        $this->db->select('fcm_token');
        $this->db->from('student_tokens');
        $this->db->where('student_id', $dataSiswa['student_id']);
        $query = $this->db->get();
        $fcm_tokens = array_column($query->result_array(), 'fcm_token');

        if (!empty($fcm_tokens)) {
            $title = "Pemberitahuan Pelanggaran";
            $body = "Anak Anda, {$dataSiswa['student_full_name']}, telah melakukan pelanggaran:\n"
                . "📅 Tanggal: {$dataPelanggaran['tanggal']}\n"
                . "⚠️ Poin: {$dataPelanggaran['poin']}\n"
                . "🚨 Pelanggaran: {$dataPelanggaran['pelanggaran']}\n"
                . "📜 Tindakan: {$dataPelanggaran['tindakan']}\n"
                . "📝 Catatan: {$dataPelanggaran['catatan']}\n\n"
                . "Mohon perhatian dan kerjasamanya.";

            // Kirim dalam batch (maksimal 500 token per request)
            $batch_size = 500;
            $token_chunks = array_chunk($fcm_tokens, $batch_size);

            foreach ($token_chunks as $tokens) {
                $fcm_url = "https://notifikasi.ppalmaruf.com/send_fcm.php";
                $fcm_data = json_encode([
                    "fcm_tokens" => $tokens, // Mengirim dalam batch
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
            log_message('error', "Tidak ada token FCM ditemukan untuk student_id: {$dataSiswa['student_id']}");
        }

        redirect('manage/pelanggaran?n=' . $this->input->get('n') . '&r=' . $this->input->get('r'));
    }

    

    // Hapus pelanggaran
    public function delete($id)
    {
        $period_id = $this->input->get('n', TRUE);
        $student_id = $this->input->get('r', TRUE);

        $this->Pelanggaran_model->delete($id);
        $this->session->set_flashdata('success', 'Data pelanggaran berhasil dihapus.');
        redirect('manage/pelanggaran?n=' . $period_id . '&r=' . $student_id);
    }

    // Fungsi untuk melihat pelanggaran berdasarkan ID
    public function view($id)
    {
        $data['pelanggaran'] = $this->Pelanggaran_model->get_by_id($id);
        if (!$data['pelanggaran']) {
            $this->session->set_flashdata('error', 'Data pelanggaran tidak ditemukan.');
            redirect('manage/pelanggaran');
        }

        $data['title'] = 'Detail Pelanggaran';
        $data['main'] = 'pelanggaran/pelanggaran_view';
        $this->load->view('manage/layout', $data);
    }
}
