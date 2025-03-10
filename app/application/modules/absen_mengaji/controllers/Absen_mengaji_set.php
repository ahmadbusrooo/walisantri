<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen_mengaji_set extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('student/Student_model');
        $this->load->model('absen_mengaji/Absen_mengaji_model');
        $this->load->model('period/Period_model');
        $this->load->model('setting/Setting_model'); // Tambahkan ini
    }

    public function index() {
        $f = $this->input->get(NULL, TRUE);
        $active_period = $this->Period_model->get_active_period();
        $data = array(
            'period' => $this->Period_model->get(),
            'santri' => $this->Student_model->get(),
            'absen' => array(),
            'total_absen' => 0,
            'santri_selected' => array(),
            'f' => $f,
            'top_absent' => $this->Absen_mengaji_model->get_top_absent($active_period['period_id']), 
            'active_period' => $active_period
        );

        if (!empty($f['n']) && !empty($f['r'])) {
            $data['santri_selected'] = $this->Student_model->get_by_nis($f['r']);
            
            if (!empty($data['santri_selected'])) {
                $student_id = $data['santri_selected']['student_id'];
                $period_id = $f['n'];
                
                $data['absen'] = $this->Absen_mengaji_model->get_by_student($student_id, $period_id);
                $data['total_absen'] = $this->Absen_mengaji_model->get_total_absen($student_id, $period_id);
            }
        }

        $data['title'] = 'Pelanggaran Absen Mengaji';
        $data['main'] = 'absen_mengaji/absen_filter';
        $this->load->view('manage/layout', $data);
    }

    public function add() {
        if ($this->input->post()) {
            $data = array(
                'student_id' => $this->input->post('student_id'),
                'period_id' => $this->input->post('period_id'),
                'tanggal_mulai' => $this->input->post('tanggal_mulai'),
                'tanggal_selesai' => $this->input->post('tanggal_selesai'),
                'jumlah_absen' => $this->input->post('jumlah_absen'), // Ambil input manual
                'keterangan' => $this->input->post('keterangan')
            );
    
            // Validasi dasar
            if (empty($data['jumlah_absen']) || $data['jumlah_absen'] < 1) {
                $this->session->set_flashdata('error', 'Jumlah hari harus lebih dari 0');
                redirect($_SERVER['HTTP_REFERER']);
            }
    
            if (strtotime($data['tanggal_selesai']) < strtotime($data['tanggal_mulai'])) {
                $this->session->set_flashdata('error', 'Tanggal selesai tidak valid');
                redirect($_SERVER['HTTP_REFERER']);
            }
    
            // Proses penyimpanan
            if ($this->Absen_mengaji_model->add($data)) {
                $this->session->set_flashdata('success', 'Data berhasil disimpan');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan data');
            }
            
            redirect('manage/absen_mengaji?n='.$data['period_id'].'&r='.$this->input->post('student_nis'));
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
        public function send_whatsapp($id) {
            // Tambahkan array hari dan bulan Indonesia
            $hari = array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu');
            $bulan = array(
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
            );
        
            // Ambil data absen mengaji
            $absen = $this->Absen_mengaji_model->get_by_id($id);
            
            if (!$absen) {
                $this->session->set_flashdata('error', 'Data absen tidak ditemukan');
                redirect('manage/absen_mengaji');
            }
        
            // Ambil data santri
            $santri = $this->Student_model->get_by_id($absen['student_id']);
            if (!$santri) {
                $this->session->set_flashdata('error', 'Data santri tidak ditemukan');
                redirect('manage/absen_mengaji');
            }
        
            // Format tanggal mulai
            $tanggalMulai = new DateTime($absen['tanggal_mulai']);
            $tgl_mulai = $hari[$tanggalMulai->format('w')] . ', ' . 
                        $tanggalMulai->format('j') . ' ' . 
                        $bulan[$tanggalMulai->format('n')] . ' ' . 
                        $tanggalMulai->format('Y');
        
            // Format tanggal selesai
            $tanggalSelesai = new DateTime($absen['tanggal_selesai']);
            $tgl_selesai = $hari[$tanggalSelesai->format('w')] . ', ' . 
                          $tanggalSelesai->format('j') . ' ' . 
                          $bulan[$tanggalSelesai->format('n')] . ' ' . 
                          $tanggalSelesai->format('Y');
        
            // Format nomor telepon
            $phone = preg_replace('/[^0-9]/', '', $santri['student_parent_phone']);
            if (strpos($phone, '62') !== 0) {
                $phone = '62' . substr($phone, 1);
            }
        
            // Format pesan yang lebih sopan
            $message = "Assalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
                . "Yth. Bapak/Ibu Orang Tua/Wali dari Ananda *{$santri['student_full_name']}*,\n\n"
                . "Dengan hormat, kami ingin menyampaikan informasi mengenai ketidakhadiran Ananda dalam kegiatan mengaji:\n\n"
                . "*Periode :*\n"
                . "Mulai: {$tgl_mulai}\n"
                . "Selesai: {$tgl_selesai}\n"
                . "_Atau Dalam 2 Minggu Terakhir Ini_\n\n"
                . "*Detail Ketidakhadiran:*\n"
                . "Jumlah Tidak Hadir Mengaji : {$absen['jumlah_absen']} Kali\n"
                . "Keterangan: {$absen['keterangan']}\n\n"
                . "Kami mengharapkan peran serta Bapak/Ibu untuk memberikan motivasi dan pengawasan kepada Ananda agar dapat mengikuti kegiatan mengaji dengan lebih baik.\n\n"
                . "Atas perhatian dan kerjasamanya, kami ucapkan terima kasih.\n\n"
                . "Wassalamu'alaikum Warahmatullahi Wabarakatuh\n\n"
                . "Salam hormat,\n"
                . "Pengurus Bagian M3\n"
                . "Pondok Pesantren Al-Maruf";
        
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
                $this->session->set_flashdata('success', 'Notifikasi berhasil dikirim');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengirim notifikasi');
            }
            
            curl_close($ch);
            redirect('manage/absen_mengaji?n='.$this->input->get('n').'&r='.$this->input->get('r'));
        }

    public function delete($id) {
        $period_id = $this->input->get('n');
        $student_nis = $this->input->get('r');
        
        if ($this->Absen_mengaji_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data absen dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus data.');
        }
        redirect('manage/absen_mengaji?n='.$period_id.'&r='.$student_nis);
    }
}