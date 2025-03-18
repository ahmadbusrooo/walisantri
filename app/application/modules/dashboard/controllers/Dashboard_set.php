<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_set extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('logged') == NULL) {
            header("Location:" . site_url('manage/auth/login') . "?location=" . urlencode($_SERVER['REQUEST_URI']));
        }
        $this->load->model(array('users/Users_model', 'holiday/Holiday_model'));
        $this->load->model(array(
            'student/Student_model', 
            'kredit/Kredit_model', 
            'debit/Debit_model', 
            'bulan/Bulan_model', 
            'setting/Setting_model', 
            'information/Information_model', 
            'bebas/Bebas_model', 
            'bebas/Bebas_pay_model',
            'class/Class_model',
            'ustadz/Ustadz_model',
            'pengurus/Pengurus_model',
            'nadzhaman/Nadzhaman_model',
            'izin_pulang/Izin_pulang_model',
            'pelanggaran/Pelanggaran_model'


        ));
        $this->load->library('user_agent');
    }

    public function index() {
        $id = $this->session->userdata('uid'); 
        $data['user'] = count($this->Users_model->get());
        $data['student'] = count($this->Student_model->get(array('status'=>1)));
        $data['kredit'] = $this->Kredit_model->get(array('date'=> date('Y-m-d')));
        $data['information'] = $this->Information_model->get(array('information_publish'=>1));
        $data['debit'] = $this->Debit_model->get(array('date'=> date('Y-m-d')));
        $data['bulan_day'] = $this->Bulan_model->get_total(array('status'=>1, 'date'=> date('Y-m-d')));
        $data['bebas_day'] = $this->Bebas_pay_model->get(array('date'=> date('Y-m-d')));
        $data['information'] = $this->Information_model->get(array('information_publish' => 1));
        $data['total_classes'] = count($this->Class_model->get_all());
        $data['total_majors'] = count($this->Student_model->get_all_majors());
        $data['total_ustadz'] = count($this->Ustadz_model->get_all_ustadz(array('status' => 1)));
        $data['total_active_pengurus'] = $this->Pengurus_model->get_total_active_pengurus();
        $student_id = $this->session->userdata('uid'); 
        $period_id = date('Y');

        // Ambil data hafalan santri per bulan
        $data['monthly_hafalan'] = $this->Nadzhaman_model->get_monthly_hafalan($student_id, $period_id);

        // Ambil santri dengan hafalan terbanyak
        $this->db->select('student.student_full_name, SUM(nadzhaman.jumlah_hafalan) as total_hafalan');
        $this->db->from('nadzhaman');
        $this->db->join('student', 'student.student_id = nadzhaman.student_id');
        $this->db->group_by('nadzhaman.student_id');
        $this->db->order_by('total_hafalan', 'DESC');
        $this->db->limit(5);
        $data['top_santri'] = $this->db->get()->result_array();

        // Ambil jumlah santri yang khatam dan belum khatam
        $data['total_santri'] = $this->db->count_all('student');
        $this->db->where('status', 'Khatam');
        $data['total_khatam'] = $this->db->count_all_results('nadzhaman');
        $data['total_belum_khatam'] = $data['total_santri'] - $data['total_khatam'];
if ($data['total_santri'] != 0) {
    $data['percent_khatam'] = ($data['total_khatam'] / $data['total_santri']) * 100;
} else {
    $data['percent_khatam'] = 0; // Jika tidak ada santri, persentase khatam 0
}

$data['percent_belum_khatam'] = 100 - $data['percent_khatam'];

        $month = $this->input->get('month') ? (int) $this->input->get('month') : date('m');
        $year = $this->input->get('year') ? (int) $this->input->get('year') : date('Y');
        
        
        $data['selected_month'] = $month;
        $data['selected_year'] = $year;
        $data['top_violators'] = $this->Pelanggaran_model->get_top_violators($month, $year);
        
        // Ambil data distribusi santri per komplek
$data['students_by_komplek'] = $this->Student_model->get_students_by_komplek();

$data['selected_month'] = $month;
$data['selected_year'] = $year;

// Ambil data masuk & keluar santri berdasarkan bulan dan tahun yang dipilih
$data['santri_masuk_keluar'] = $this->Student_model->get_santri_masuk_keluar($month, $year);


        $data['students_by_class'] = $this->Student_model->get_students_by_class();

        $data['total_kredit'] = 0;
        foreach ($data['kredit'] as $row) {
            $data['total_kredit'] += $row['kredit_value'];
        }

        $data['total_debit'] = 0;
        foreach ($data['debit'] as $row) {
            $data['total_debit'] += $row['debit_value'];
        }

        $data['total_bulan'] = 0;
        foreach ($data['bulan_day'] as $row) {
            $data['total_bulan'] += $row['bulan_bill'];
        }

        $data['total_bebas'] = 0;
        foreach ($data['bebas_day'] as $row) {
            $data['total_bebas'] += $row['bebas_pay_bill'];
        }

        $this->load->library('form_validation');
        if ($this->input->post('add', TRUE)) {
            $this->form_validation->set_rules('date', 'Tanggal', 'required');
            $this->form_validation->set_rules('info', 'Info', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($_POST AND $this->form_validation->run() == TRUE) {
                list($tahun, $bulan, $tanggal) = explode('-', $this->input->post('date', TRUE));

                $params['year'] = $tahun;
                $params['date'] = $this->input->post('date');
                $params['info'] = $this->input->post('info');

                $ret = $this->Holiday_model->add($params);

                $this->session->set_flashdata('success', 'Tambah Agenda berhasil');
                redirect('manage');
            }
        }elseif ($this->input->post('del', TRUE)) {
            $this->form_validation->set_rules('id', 'ID', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

            if ($_POST AND $this->form_validation->run() == TRUE) {
                $id = $this->input->post('id', TRUE);
                $this->Holiday_model->delete($id);

                $this->session->set_flashdata('success', 'Hapus Agenda berhasil');
                redirect('manage');
            }
        }
        $data['today_izin'] = $this->Izin_pulang_model->get_today_izin(10);
$current_period = date('Y'); // Sesuaikan dengan logika periode Anda
$data['top_izin'] = $this->Izin_pulang_model->get_top_izin($current_period, 10);
        $data['today_violations'] = $this->Pelanggaran_model->get_today_violations();
        $data['setting_logo'] = $this->Setting_model->get(array('id' => 6));
        $data['holiday'] = $this->Holiday_model->get();
        $data['title'] = 'Dashboard';
        $data['main'] = 'dashboard/dashboard';
        $this->load->view('manage/layout', $data);
    }



    
    public function get() {
        $events = $this->Holiday_model->get();
        foreach ($events as $i => $row) {
            $data[$i] = array(
                'id' => $row['id'],
                'title' => strip_tags($row['info']),
                'start' => $row['date'],
                'end' => $row['date'],
                'year' => $row['year'],
                    //'url' => event_url($row)
            );
        }
        echo json_encode($data, TRUE);
    }

}
