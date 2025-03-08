<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Nadzhaman extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('uroleid') != SUPERUSER) {
            redirect('manage/dashboard');
        }
        $this->load->model([
            'nadzhaman/Nadzhaman_model', 
            'student/Student_model', 
            'kitab/Kitab_model', 
            'period/Period_model', 
            'KitabDikelas_model' // Pastikan model ini ada
        ]);
    }

    public function manage_kitab_class()
    {
        $data['title'] = 'Seting Kitab per Kelas';
        $data['classes'] = $this->Student_model->get_class();
        $data['periods'] = $this->Period_model->get();
        $data['kitabs'] = $this->Kitab_model->get();
    
        // Tangkap input dari form
        $class_id = $this->input->post('class_id');
        $period_id = $this->input->post('period_id');
        $kitab_ids = $this->input->post('kitab_ids');
    
        // Jika tidak ada input `period_id`, set ke tahun aktif
        if (empty($period_id)) {
            $active_period = $this->Period_model->get(['status' => 1]); // Pastikan kolom 'status' menandakan tahun aktif
            if (!empty($active_period)) {
                $period_id = $active_period[0]['period_id'];
            }
        }
    
        
            if ($_POST) {
                $duplicate_kitab = [];
                $existing_kitab_ids = []; // Simpan kitab yang sudah ada
        
                // Ambil kitab yang sudah terdaftar di kelas ini
                $existing_entries = $this->KitabDikelas_model->get([
                    'class_id' => $class_id,
                    'period_id' => $period_id
                ]);
        
                foreach ($existing_entries as $entry) {
                    $existing_kitab_ids[] = $entry['kitab_id'];
                }
        
                // Cek duplikasi di input dan database
                foreach ($kitab_ids as $kitab_id) {
                    // Jika kitab sudah ada di database
                    if (in_array($kitab_id, $existing_kitab_ids)) { // <-- PERBAIKI TYPO DI SINI
                        $kitab_info = $this->Kitab_model->get(['kitab_id' => $kitab_id]);
                        $duplicate_kitab[] = $kitab_info['nama_kitab'];
                    }
                }
        
                // Jika ada duplikasi
                if (!empty($duplicate_kitab)) {
                    $message = 'Kitab berikut sudah terdaftar: ' . implode(', ', $duplicate_kitab);
                    $this->session->set_flashdata('error', $message);
                    redirect('nadzhaman/manage_kitab_class');
                }
        
                // Hapus semua data lama (opsional)
                $this->KitabDikelas_model->delete_by_class($class_id, $period_id);
        
                // Tambahkan data baru
                foreach ($kitab_ids as $kitab_id) {
                    $this->KitabDikelas_model->add([
                        'class_id' => $class_id,
                        'kitab_id' => $kitab_id,
                        'period_id' => $period_id,
                    ]);
                }
        
                $this->session->set_flashdata('success', 'Kitab berhasil diperbarui untuk kelas.');
                redirect('nadzhaman/manage_kitab_class');
            }
        

    
        // Kirim data terpilih ke view untuk diingat
        $data['selected_class'] = $class_id;
        $data['selected_period'] = $period_id;
    
        $data['main'] = 'nadzhaman/manage_kitab_class';
        $this->load->view('manage/layout', $data);
    }
    
    
    

    public function filter_nadzhaman()
    {
        $class_id = $this->input->get('class_id', TRUE);
        $period_id = $this->input->get('period_id', TRUE);
    
        $data['title'] = 'Tambah Data Nadzhaman';
    
        // Mendapatkan data kelas
        $data['classes'] = $this->Student_model->get_class();
    
        // Mendapatkan data periode
        $data['periods'] = $this->Period_model->get();
    
        // Jika tidak ada period_id yang diisi, pilih tahun ajaran yang aktif
        if (empty($period_id)) {
            $active_period = $this->Period_model->get(['status' => 1]);
            if (!empty($active_period)) {
                $period_id = $active_period[0]['period_id'];
            }
        }
    
        // Mendapatkan data kitab berdasarkan kelas dan periode
        $data['kitabs'] = $this->KitabDikelas_model->get_by_class($class_id, $period_id);
    
        // Tambahkan target hafalan ke setiap kitab
        foreach ($data['kitabs'] as &$kitab) {
            $kitab_detail = $this->Kitab_model->get(['kitab_id' => $kitab['kitab_id']]);
            $kitab['target_hafalan'] = isset($kitab_detail['target']) ? $kitab_detail['target'] : 0;
        }
    
        // Santri per kelas (hanya siswa dengan status aktif)
        $data['santri'] = $this->Student_model->get([
            'class_id' => $class_id,
            'status' => 1 // Hanya siswa aktif
        ]);
    
        // Ambil data hafalan per siswa
        $data['nadzhaman'] = [];
        if (!empty($data['santri'])) {
            foreach ($data['santri'] as $santri) {
                $nadzhaman = $this->Nadzhaman_model->get([
                    'student_id' => $santri['student_id'],
                    'period_id' => $period_id
                ]);
    
                $data['nadzhaman'][] = [
                    'student_full_name' => $santri['student_full_name'],
                    'tanggal' => isset($nadzhaman[0]['tanggal']) ? $nadzhaman[0]['tanggal'] : '-',
                    'nama_kitab' => isset($nadzhaman[0]['nama_kitab']) ? $nadzhaman[0]['nama_kitab'] : '-',
                    'jumlah_hafalan' => isset($nadzhaman[0]['jumlah_hafalan']) ? $nadzhaman[0]['jumlah_hafalan'] : '-',
                    'keterangan' => isset($nadzhaman[0]['keterangan']) ? $nadzhaman[0]['keterangan'] : '-',
                    'status' => isset($nadzhaman[0]['status']) ? $nadzhaman[0]['status'] : '-'
                ];
            }
        }
    
        // Pastikan ada filter kelas dan periode yang diisi
        if (empty($class_id) || empty($period_id)) {
            $data['kitabs'] = [];
        }
    
        // Kirim class_id dan period_id yang terpilih ke view
        $data['selected_class'] = $class_id;
        $data['selected_period'] = $period_id;
    
        // Menentukan file utama untuk view
        $data['main'] = 'nadzhaman/nadzhaman_filter';
        $this->load->view('manage/layout', $data);
    }
    
    
    
    public function bulk_add()
    {
        $class_id = $this->input->post('class_id');
        $period_id = $this->input->post('period_id');
        $students = $this->input->post('students');
    
        // Ambil data kitab dari kelas
        $kitabs = $this->KitabDikelas_model->get_by_class($class_id, $period_id);
        if (empty($kitabs)) {
            $this->session->set_flashdata('error', 'Tidak ada kitab yang terdaftar untuk kelas ini.');
            redirect('nadzhaman/filter_nadzhaman?class_id=' . $class_id . '&period_id=' . $period_id);
        }
    
        // Ambil kitab pertama (asumsi satu kitab per kelas)
        $kitab_id = $kitabs[0]['kitab_id'];
    
        foreach ($students as $student) {
            $data = [
                'student_id' => $student['student_id'],
                'kitab_id' => $kitab_id,
                'tanggal' => $student['tanggal'],
                'jumlah_hafalan' => $student['jumlah_hafalan'],
                'keterangan' => $student['keterangan'],
                'period_id' => $period_id,
            ];
            $this->Nadzhaman_model->add($data);
    
            // Perbarui status setelah penambahan data
            $this->Nadzhaman_model->update_status($student['student_id'], $kitab_id, $period_id);
        }
    
        $this->session->set_flashdata('success', 'Data Nadzhaman berhasil ditambahkan.');
        redirect('nadzhaman/filter_nadzhaman?class_id=' . $class_id . '&period_id=' . $period_id);
    }
    
    



    public function add()
    {
        if ($_POST) {
            $data = [
                'student_id' => $this->input->post('student_id', TRUE),
                'kitab_id' => $this->input->post('kitab_id', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'jumlah_hafalan' => $this->input->post('jumlah_hafalan', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'period_id' => $this->input->post('period_id', TRUE),
            ];

            $this->Nadzhaman_model->add($data);

            // Periksa apakah target kitab tercapai
            $this->Nadzhaman_model->check_target($data['student_id'], $data['kitab_id']);

            $this->session->set_flashdata('success', 'Data Nadzhaman berhasil ditambahkan.');
            redirect('nadzhaman/nadzhaman?class_id=' . $this->input->post('class_id') . '&period_id=' . $data['period_id']);
        }
    }

    public function index()
    {
        $filter = $this->input->get(NULL, TRUE);

        $data['f'] = $filter;
        $data['period'] = $this->Period_model->get();
        $data['santri'] = $this->Student_model->get();
        $data['kitab'] = $this->Kitab_model->get();

        $data['santri_selected'] = [];
        $data['nadzhaman'] = [];
        $data['selected_period'] = NULL;
        $data['total_hafalan'] = 0;
        $data['monthly_hafalan'] = [];
        $data['yearly_hafalan'] = [];

        if (isset($filter['n']) && isset($filter['r']) && !empty($filter['n']) && !empty($filter['r'])) {
            $data['santri_selected'] = $this->Student_model->get_by_nis($filter['r']);
            $student_id = $data['santri_selected']['student_id'];
            $selected_period = $filter['n'];

            $data['nadzhaman'] = $this->Nadzhaman_model->get([
                'student_id' => $student_id,
                'period_id' => $selected_period
            ]);

            $data['selected_period'] = $selected_period;

            // Hitung total hafalan
            $data['total_hafalan'] = $this->Nadzhaman_model->get_total_hafalan_by_period($student_id, $selected_period);

            // Rekap hafalan bulanan
            $data['monthly_hafalan'] = $this->Nadzhaman_model->get_monthly_hafalan($student_id, $selected_period);

            // Rekap hafalan tahunan
            $data['yearly_hafalan'] = $this->Nadzhaman_model->get_yearly_hafalan($student_id);
        }

        $data['title'] = 'Data Hafalan Santri';
        $data['main'] = 'nadzhaman/nadzhaman_list';
        $this->load->view('manage/layout', $data);
    }

    public function delete($id = null)
{
    if (!isset($id)) {
        show_404();
    }

    // Ambil data sebelum dihapus
    $nadzhaman = $this->Nadzhaman_model->get(['nadzhaman_id' => $id]);
    if (!$nadzhaman) {
        $this->session->set_flashdata('error', 'Data tidak ditemukan.');
        redirect('nadzhaman');
    }

    // Hapus data
    $this->Nadzhaman_model->delete($id);

    // Perbarui status setelah penghapusan
    $this->Nadzhaman_model->update_status($nadzhaman['student_id'], $nadzhaman['kitab_id'], $nadzhaman['period_id']);

    $this->session->set_flashdata('success', 'Data Nadzhaman berhasil dihapus.');
    redirect('nadzhaman');
}

}
