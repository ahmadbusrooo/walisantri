<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Health extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('uroleid') != SUPERUSER){
            redirect('student/auth/login?location=' . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(['health/Health_model', 'student/Student_model', 'period/Period_model']);
    }

    public function index()
    {
        $filter = $this->input->get(NULL, TRUE);
    
        $data['f'] = $filter;
        $data['period'] = $this->Period_model->get(); // Ambil semua periode
        $data['santri'] = $this->Student_model->get(); // Ambil semua data siswa
    
        if (isset($filter['n']) && isset($filter['r']) && !empty($filter['n']) && !empty($filter['r'])) {
            $data['santri_selected'] = $this->Student_model->get_by_nis($filter['r']);
            if ($data['santri_selected']) {
                // Tambahkan filter period_id
                $data['kesehatan'] = $this->Health_model->get([
                    'student_id' => $data['santri_selected']['student_id'],
                    'period_id' => $filter['n'], // Filter berdasarkan periode
                ]);
                $data['selected_period'] = $filter['n'];
            } else {
                $data['santri_selected'] = [];
                $data['kesehatan'] = [];
                $data['selected_period'] = NULL;
            }
        } else {
            $data['santri_selected'] = [];
            $data['kesehatan'] = [];
            $data['selected_period'] = NULL;
        }
    
        $data['title'] = 'Data Kesehatan Santri';
        $data['main'] = 'health/health_list'; // View yang ditampilkan
        $this->load->view('manage/layout', $data);
    }
    
    public function add()
    {
        if ($_POST) {
            $data = [
                'student_id' => $this->input->post('student_id', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'kondisi_kesehatan' => $this->input->post('kondisi_kesehatan', TRUE),
                'tindakan' => $this->input->post('tindakan', TRUE),
                'catatan' => $this->input->post('catatan', TRUE),
            ];
    
            $this->Health_model->add($data);
            $this->session->set_flashdata('success', 'Data kesehatan berhasil ditambahkan.');
            redirect('health?n=' . $data['period_id'] . '&r=' . $this->input->post('nis', TRUE));
        }
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


    public function delete($id = null)
    {
        if (!isset($id)) {
            show_404();
        }

        // Ambil data kesehatan berdasarkan ID
        $health_record = $this->Health_model->get(['health_record_id' => $id]);
        if (!$health_record) {
            $this->session->set_flashdata('error', 'Data kesehatan tidak ditemukan.');
            redirect('health');
        }

        $student_id = $health_record['student_id']; // Ambil student_id dari data kesehatan
        $period_id = $health_record['period_id'];  // Ambil period_id dari data kesehatan

        // Hapus data kesehatan
        if ($this->Health_model->delete($id)) {
            $this->session->set_flashdata('success', 'Data kesehatan berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Terjadi kesalahan saat menghapus data kesehatan.');
        }

        // Ambil NIS berdasarkan student_id
        $student = $this->Student_model->get(['student_id' => $student_id]);
        $nis = isset($student['student_nis']) ? $student['student_nis'] : '';

        // Redirect dengan parameter filter agar data siswa tetap terpilih
        redirect('health?n=' . $period_id . '&r=' . $nis);
    }
}
