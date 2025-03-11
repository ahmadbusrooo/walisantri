<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Izin_pulang_set extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('student/Student_model');
        $this->load->model('izin_pulang/Izin_pulang_model');
        $this->load->model('period/Period_model');
    }

    // Halaman utama izin pulang dengan filter
    public function index()
    {
        $f = $this->input->get(NULL, TRUE);

        $data['f'] = $f;
        $data['period'] = $this->Period_model->get();
        $data['santri'] = $this->Student_model->get();

        // Default nilai
        $data['santri_selected'] = [];
        $data['izin_pulang'] = [];
        $data['selected_period'] = NULL;
        $data['total_days'] = 0;
        $data['monthly_days'] = [];

        if (isset($f['n']) && isset($f['r']) && !empty($f['n']) && !empty($f['r'])) {
            $data['santri_selected'] = $this->Student_model->get_by_nis($f['r']);

            if (!empty($data['santri_selected']) && isset($data['santri_selected']['student_id'])) {
                $student_id = $data['santri_selected']['student_id'];
                $selected_period = $f['n'];

                $data['izin_pulang'] = $this->Izin_pulang_model->get_by_student_period($student_id, $selected_period);
                $data['selected_period'] = $selected_period;
                $data['total_days'] = $this->Izin_pulang_model->get_total_days_by_period(
                    $selected_period, 
                    $student_id // ✅ Tambahkan student_id
                );
                
                $data['monthly_days'] = $this->Izin_pulang_model->get_monthly_days_by_period(
                    $selected_period, 
                    $student_id // ✅ Tambahkan student_id
                );
            }
        }
        
        
        $data['title'] = 'Riwayat Izin Pulang Santri';
        $data['main'] = 'izin_pulang/izin_pulang_filter';
        $this->load->view('manage/layout', $data);
    }

    // Tambah izin pulang baru
    public function add()
    {
        if ($_POST) {
            $data = [
                'student_id' => $this->input->post('student_id', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'tanggal_akhir' => $this->input->post('tanggal_akhir', TRUE),
                'jumlah_hari' => $this->input->post('jumlah_hari', TRUE),
                'alasan' => $this->input->post('alasan', TRUE),
                'status' => 'Tepat waktu' // Default status
            ];
    
            // Validasi input
            if (empty($data['period_id'])) {
                $this->session->set_flashdata('error', 'Tahun ajaran tidak valid.');
                redirect('manage/izin_pulang');
            }
    
            $student = $this->Student_model->get_by_id($data['student_id']);
            if (!$student) {
                $this->session->set_flashdata('error', 'Santri tidak ditemukan.');
                redirect('manage/izin_pulang');
            }
    
            // Simpan data izin pulang
            $this->Izin_pulang_model->add($data);
            $this->session->set_flashdata('success', 'Data izin pulang berhasil ditambahkan.');
            redirect('manage/izin_pulang?n=' . $data['period_id'] . '&r=' . $student['student_nis']);
        }
    }

    public function update_status()
    {
        $izin_id = $this->input->post('izin_id');
        $status = $this->input->post('status');
        
        if($this->Izin_pulang_model->update_status($izin_id, $status)) {
            $response = ['status' => 'success'];
        } else {
            $response = ['status' => 'error'];
        }
        
        echo json_encode($response);
    }
public function send_whatsapp($id) {
    // Array hari dan bulan Indonesia
    $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
    $bulan = array(
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    );

    // Ambil data izin pulang
    $izin = $this->Izin_pulang_model->get_by_id($id);
    
    if (!$izin) {
        $this->session->set_flashdata('error', 'Data izin tidak ditemukan');
        redirect('manage/izin_pulang');
    }
    $period_id = $this->input->get('n', TRUE);
    $student_nis = $this->input->get('r', TRUE);
    // Ambil data santri
    $santri = $this->Student_model->get_by_id($izin['student_id']);
    if (!$santri) {
        $this->session->set_flashdata('error', 'Data santri tidak ditemukan');
        redirect('manage/izin_pulang');
    }

    // Format tanggal
    $tanggalAkhir = new DateTime($izin['tanggal_akhir']);
    $tgl_harus_kembali = $hari[$tanggalAkhir->format('w')] . ', ' . 
                        $tanggalAkhir->format('j') . ' ' . 
                        $bulan[$tanggalAkhir->format('n')] . ' ' . 
                        $tanggalAkhir->format('Y');

    // Format nomor telepon
    $phone = preg_replace('/[^0-9]/', '', $santri['student_parent_phone']);
    if (strpos($phone, '62') !== 0) {
        $phone = '62' . substr($phone, 1);
    }

    // Format pesan
    $message = "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
        . "Yth. Bapak/Ibu Orang Tua/Wali dari Ananda *{$santri['student_full_name']}*,\n\n"
        . "Kami ingin memberitahukan bahwa Ananda tercatat *terlambat kembali* ke pondok setelah izin pulang.\n\n"
        . "*Detail Izin Pulang:*\n"
        . "Tanggal Izin : {$tgl_harus_kembali}\n"
        . "Status : Terlambat Kembali\n\n"
        . "Dimohon untuk segera mengkonfirmasi ke pihak pondok terkait keterlambatan ini.\n\n"
        . "Terima kasih atas perhatiannya.\n\n"
        . "Wassalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
        . "Salam hormat,\n"
        . "Pengurus Pondok Pesantren Al-Maruf";

    // Ambil konfigurasi WA Gateway
    $this->load->model('setting/Setting_model');
    $api_url = $this->Setting_model->get_value(['id' => 8]);
    $api_token = $this->Setting_model->get_value(['id' => 9]);

    // Kirim ke API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: $api_token",
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        "data" => [[
            "phone" => $phone,
            "message" => $message
        ]]
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    if (curl_errno($ch)) {
        $this->session->set_flashdata('error', 'Error: ' . curl_error($ch));
    } elseif ($http_code == 200) {
        $this->session->set_flashdata('success', 'Notifikasi WA berhasil dikirim');
    } else {
        $this->session->set_flashdata('error', 'Gagal mengirim notifikasi');
    }
    
    curl_close($ch);
    redirect('manage/izin_pulang?n='.$period_id.'&r='.$student_nis); // Perbaikan di sini
}
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
    
    // Hapus izin pulang
    public function delete($id)
    {
        $period_id = $this->input->get('n', TRUE);
        $student_id = $this->input->get('r', TRUE);
    
        // Ganti izin_pulang_id dengan izin_id
        $this->Izin_pulang_model->delete($id);
    
        $this->session->set_flashdata('success', 'Data izin pulang berhasil dihapus.');
        redirect('manage/izin_pulang?n=' . $period_id . '&r=' . $student_id);
    }
    
}
