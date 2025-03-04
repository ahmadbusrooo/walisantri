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
                $data['total_days'] = $this->Izin_pulang_model->get_total_days_by_period($selected_period);
        $data['monthly_days'] = $this->Izin_pulang_model->get_monthly_days_by_period($selected_period);
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
                'jumlah_hari' => $this->input->post('jumlah_hari', TRUE), // Tambahkan jumlah_hari
                'alasan' => $this->input->post('alasan', TRUE),
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
