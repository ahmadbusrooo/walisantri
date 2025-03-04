<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Flutter_Integration extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load semua model yang dibutuhkan
        $this->load->model([
            'student/Student_model',
            'class/Class_model',
            'pelanggaran/Pelanggaran_model',
            'health/Health_model',
            'nadzhaman/Nadzhaman_model',
            'kitab/Kitab_model',
            'payment/Payment_model',
            'period/Period_model',
            'pos/Pos_model',
            'bulan/Bulan_model',
            'bebas/Bebas_model',
            'bebas/Bebas_pay_model',
            'setting/Setting_model',
            'information/Information_model'
        ]);
        $this->load->model('KitabDikelas_model');


        $this->load->library('form_validation');
        $this->load->helper(['string', 'file']);
    }

    // Utility function to validate token
    private function validate_token()
    {
        $headers = apache_request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : (isset($headers['authorization']) ? $headers['authorization'] : null);
        $token = $authHeader ? str_replace('Bearer ', '', $authHeader) : null;
    
        if (!$token) {
            echo json_encode([
                "status" => false,
                "message" => "Token not found in header."
            ]);
            exit;
        }
    
        // Validasi token di tabel `student_tokens`
        $this->db->where('token', $token);
        $query = $this->db->get('student_tokens');
        $token_data = $query->row_array();
    
        if (empty($token_data)) {
            echo json_encode([
                "status" => false,
                "message" => "Invalid token."
            ]);
            exit;
        }
    
        // Ambil data siswa terkait token
        $this->db->where('student_id', $token_data['student_id']);
        $student = $this->db->get('student')->row_array();
    
        if (empty($student)) {
            echo json_encode([
                "status" => false,
                "message" => "Student not found."
            ]);
            exit;
        }
    
        return $student;
    }
    

    // API for profile details
    public function get_profile()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        $data = $this->Student_model->get(['id' => $student['student_id']]);

        if (!empty($data)) {
            echo json_encode([
                'status' => true,
                'data' => $data
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Profile not found.'
            ]);
        }
    }

    // API for editing profile
    public function edit_profile()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        $this->form_validation->set_rules('student_phone', 'Phone', 'trim|required');
        $this->form_validation->set_rules('student_address', 'Address', 'trim|required');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $params = [
            'student_id' => $student['student_id'],
            'student_phone' => $this->input->post('student_phone', true),
            'student_address' => $this->input->post('student_address', true),
            'student_last_update' => date('Y-m-d H:i:s')
        ];

        $update_status = $this->Student_model->add($params);

        if ($update_status) {
            echo json_encode([
                'status' => true,
                'message' => 'Profile updated successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to update profile.'
            ]);
        }
    }

    // API for changing password
    public function change_password()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[new_password]');

        if ($this->form_validation->run() == false) {
            echo json_encode([
                'status' => false,
                'message' => validation_errors()
            ]);
            return;
        }

        $current_password = $this->input->post('current_password', true);
        $new_password = $this->input->post('new_password', true);

        if (sha1($current_password) != $student['student_password']) {
            echo json_encode([
                'status' => false,
                'message' => 'Current password is incorrect.'
            ]);
            return;
        }

        $update_status = $this->Student_model->change_password($student['student_id'], ['student_password' => sha1($new_password)]);

        if ($update_status) {
            echo json_encode([
                'status' => true,
                'message' => 'Password changed successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to change password.'
            ]);
        }
    }

    // Fungsi login, logout, get_pelanggaran, get_health_data, get_nadzhaman_data, get_payout_data tetap sama seperti sebelumnya


    // Authentication API for login
    public function login()
    {
        header('Content-Type: application/json');
        $response = ['status' => false, 'message' => ''];
    
        // Validasi input
        $this->form_validation->set_rules('nis', 'NIS', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        $this->form_validation->set_rules('fcm_token', 'FCM Token', 'trim'); // Token FCM dari Flutter
    
        if ($this->form_validation->run() == FALSE) {
            $response['message'] = validation_errors();
            echo json_encode($response);
            return;
        }
    
        // Ambil data dari POST
        $nis = $this->input->post('nis', TRUE);
        $password = $this->input->post('password', TRUE);
        $fcm_token = $this->input->post('fcm_token', TRUE); // Ambil token FCM
    
        // Cek data siswa
        $student = $this->Student_model->get(['nis' => $nis, 'password' => sha1($password)]);
    
        if (!empty($student)) {
            // Login berhasil
            $this->session->set_userdata('logged_student', TRUE);
            $this->session->set_userdata('uid_student', $student[0]['student_id']);
            $this->session->set_userdata('unis_student', $student[0]['student_nis']);
            $this->session->set_userdata('ufullname_student', $student[0]['student_full_name']);
            $this->session->set_userdata('student_img', $student[0]['student_img']);
    
            // Informasi perangkat opsional
            $device_info = $this->input->post('device_info', TRUE) ?: 'Unknown Device';
    
            // Periksa apakah token sudah ada untuk perangkat ini
            $this->db->where('student_id', $student[0]['student_id']);
            $this->db->where('device_info', $device_info);
            $existing_token = $this->db->get('student_tokens')->row_array();
    
            if ($existing_token) {
                // Jika token sudah ada, gunakan token yang sama
                $token = $existing_token['token'];
    
                // Perbarui token FCM jika berubah
                if (!empty($fcm_token) && $existing_token['fcm_token'] !== $fcm_token) {
                    $this->db->where('student_id', $student[0]['student_id']);
                    $this->db->where('device_info', $device_info);
                    $this->db->update('student_tokens', ['fcm_token' => $fcm_token]);
                }
            } else {
                // Jika belum ada, buat token baru
                $token = random_string('alnum', 40);
                $this->db->insert('student_tokens', [
                    'student_id' => $student[0]['student_id'],
                    'token' => $token,
                    'device_info' => $device_info,
                    'fcm_token' => $fcm_token // Simpan FCM Token
                ]);
            }
    
            $response['status'] = true;
            $response['message'] = 'Login successful';
            $response['data'] = [
                'student_id' => $student[0]['student_id'],
                'nis' => $student[0]['student_nis'],
                'full_name' => $student[0]['student_full_name'],
                'student_img' => $student[0]['student_img'],
                'token' => $token, // Sertakan token di respons
            ];
        } else {
            // Login gagal
            $response['message'] = 'NIS atau Password tidak cocok.';
        }
    
        echo json_encode($response);
    }
    

    // Tambahkan fungsi lainnya tanpa perubahan logika


    public function fetch_student_data()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        $student_data = $this->Student_model->get(['student_id' => $student['student_id']]);
        if (!empty($student_data)) {
            echo json_encode([
                'status' => true,
                'data' => [
                    'student_id' => $student_data[0]['student_id'],
                    'nis' => $student_data[0]['student_nis'],
                    'full_name' => $student_data[0]['student_full_name'],
                    'student_img' => $student_data[0]['student_img'],
                ]
            ]);
        } else {
            echo json_encode(['status' => false, 'message' => 'Student not found']);
        }
    }

    public function dashboard() {
        header('Content-Type: application/json');
        $student = $this->validate_token();
    
        // Mengambil data kelas siswa
        $student_class = $this->Class_model->get(['student_id' => $student['student_id']]);
        $class_name = isset($student_class['class_name']) ? $student_class['class_name'] : 'Tidak Ada Data';
    
        $student_data = [
            'student_full_name' => $student['student_full_name'],
            'student_nis' => $student['student_nis'],
            'class_name' => $class_name,
            'student_img' => $student['student_img']
        ];
    
        // Mengambil periode aktif menggunakan Period_model
        $active_period = $this->Period_model->get(['status' => 1]); // Mengambil data dengan period_status = 1
    
        // Validasi data periode aktif
        $academic_year = 'Tidak Ada Data'; // Default jika data tidak ditemukan
        $period_id = null;
    
        if (!empty($active_period) && is_array($active_period)) {
            // Jika data periode ditemukan, ambil period_start, period_end, dan period_id
            $academic_year = $active_period[0]['period_start'] . '/' . $active_period[0]['period_end'];
            $period_id = $active_period[0]['period_id'];
        }
    
        // Fallback jika period_id tetap tidak ditemukan
        if (!$period_id) {
            $period_id = 1; // Menggunakan periode default
        }
    
        // Mengambil data tagihan bulanan
        $bulan = $this->Bulan_model->get([
            'status' => 0, // Tagihan yang belum dibayar
            'period_id' => $period_id, // Menggunakan period_id
            'student_id' => $student['student_id']
        ]);
    
        $total_bulan = array_sum(array_column($bulan, 'bulan_bill')); // Total tagihan bulanan
    
        // Mengambil data tagihan bebas
        $bebas = $this->Bebas_model->get([
            'period_id' => $period_id, // Menggunakan period_id
            'student_id' => $student['student_id']
        ]);
    
        $total_bebas = array_sum(array_column($bebas, 'bebas_bill')); // Total tagihan bebas
        $total_bebas_pay = array_sum(array_column($bebas, 'bebas_total_pay')); // Total pembayaran bebas
    
        // Menghitung total tagihan dengan memperhitungkan pembayaran
        $total_tagihan = ($total_bulan + $total_bebas) - $total_bebas_pay;
    
        // Mengambil data informasi yang dipublikasikan
        $information = $this->Information_model->get([
            'information_publish' => 1 // Hanya informasi yang dipublikasikan
        ]);
    
        // Menyiapkan respons JSON
        echo json_encode([
            'status' => true,
            'message' => 'Dashboard data retrieved successfully.',
            'data' => [
                'student_full_name' => $student_data['student_full_name'],
                'student_nis' => $student_data['student_nis'],
                'class_name' => $student_data['class_name'],
                'student_img' => $student_data['student_img'],
                'academic_year' => $academic_year, // Tambahkan tahun ajaran aktif
                'total_tagihan' => $total_tagihan,
                'information' => $information
            ]
        ]);
    }
    
    public function get_payment_history()
    {
        header('Content-Type: application/json');
        
        // Validasi token dan dapatkan data santri
        $student = $this->validate_token();
        if (!$student) {
            echo json_encode([
                "status" => false,
                "message" => "Token tidak valid atau siswa tidak ditemukan."
            ]);
            return;
        }
    
        // Ambil semua periode
        $periods = $this->Period_model->get();
        if (empty($periods)) {
            echo json_encode([
                "status" => false,
                "message" => "Tidak ada periode yang ditemukan."
            ]);
            return;
        }
    
        $response_data = [];
    
        foreach ($periods as $period) {
            $period_id = $period['period_id'];
    
            // Ambil data pembayaran bulanan
            $bulan_payments = $this->Bulan_model->get([
                'student_id' => $student['student_id'],
                'period_id' => $period_id
            ]) ?: [];
    
            // Ambil data pembayaran bebas
            $bebas_payments = $this->Bebas_model->get([
                'student_id' => $student['student_id'],
                'period_id' => $period_id
            ]) ?: [];
    
            // Total tagihan dan pembayaran
            $total_bulan = array_sum(array_column($bulan_payments, 'bulan_bill'));
            $total_paid_bulan = array_reduce($bulan_payments, function ($carry, $item) {
                return $carry + ($item['bulan_status'] == 1 ? $item['bulan_bill'] : 0);
            }, 0);
    
            $total_bebas = array_sum(array_column($bebas_payments, 'bebas_bill'));
            $total_paid_bebas = array_sum(array_column($bebas_payments, 'bebas_total_pay'));
    
            $total_tagihan_periode = $total_bulan + $total_bebas;
            $total_paid_periode = $total_paid_bulan + $total_paid_bebas;
    
            // Detail pembayaran bulanan
            $bulan_grouped = [];
            foreach ($bulan_payments as $payment) {
                $bulan_grouped[] = [
                    'bulan_id' => $payment['bulan_id'],
                    'month_name' => $payment['month_name'],
                    'bill' => $payment['bulan_bill'],
                    'status' => $payment['bulan_status'],
                    'date_pay' => $payment['bulan_date_pay'],
                    'last_update' => $payment['bulan_last_update'],
                    'pos_name' => $payment['pos_name']
                ];
            }
    
            // Detail pembayaran bebas
            $bebas_grouped = [];
            foreach ($bebas_payments as $payment) {
                $bebas_grouped[] = [
                    'bebas_id' => $payment['bebas_id'],
                    'bill' => $payment['bebas_bill'],
                    'total_pay' => $payment['bebas_total_pay'],
                    'last_update' => $payment['bebas_last_update'],
                    'pos_name' => $payment['pos_name']
                ];
            }
    
            // Tambahkan data periode ke respons
            $response_data[] = [
                'period' => [
                    'period_id' => $period['period_id'],
                    'period_start' => $period['period_start'],
                    'period_end' => $period['period_end'],
                    'status' => $period['period_status']
                ],
                'payments' => [
                    'bulan' => [
                        'details' => $bulan_grouped,
                        'total' => $total_bulan,
                        'total_paid' => $total_paid_bulan
                    ],
                    'bebas' => [
                        'details' => $bebas_grouped,
                        'total' => $total_bebas,
                        'total_paid' => $total_paid_bebas
                    ]
                ],
                'summary' => [
                    'total_tagihan' => $total_tagihan_periode,
                    'total_paid' => $total_paid_periode,
                    'remaining_payment' => $total_tagihan_periode - $total_paid_periode
                ]
            ];
        }
    
        // Kirim data sebagai JSON
        echo json_encode([
            'status' => true,
            'message' => 'Riwayat pembayaran berhasil diambil.',
            'data' => $response_data
        ]);
    }
    



    // Logout API
    public function logout()
    {
        header('Content-Type: application/json');
        $headers = apache_request_headers();
        $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;
        $token = $authHeader ? str_replace('Bearer ', '', $authHeader) : null;
    
        if ($token) {
            $this->db->where('token', $token);
            $this->db->delete('student_tokens');
            echo json_encode(['status' => true, 'message' => 'Logout successful.']);
        } else {
            echo json_encode(['status' => false, 'message' => 'Token not found.']);
        }
    }
    
    
    public function logout_all()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();
    
        $this->db->where('student_id', $student['student_id']);
        $this->db->delete('student_tokens');
    
        echo json_encode(['status' => true, 'message' => 'Logged out from all devices.']);
    }
    
    // Fungsi lainnya seperti get_pelanggaran, get_health_data, get_nadzhaman_data, dan get_payout_data tetap sama


    public function get_pelanggaran()
    {
        header('Content-Type: application/json');
    
        try {
            // Validasi token
            $student = $this->validate_token();
            if (!$student) {
                throw new Exception('Token tidak valid atau siswa tidak ditemukan.');
            }
    
            // Ambil informasi kelas siswa
            $student_class = $this->Class_model->get(['student_id' => $student['student_id']]);
            $class_name = isset($student_class['class_name']) ? $student_class['class_name'] : 'Tidak Ada Data';
    
            // Ambil semua periode
            $periods = $this->Period_model->get();
            if (empty($periods)) {
                echo json_encode([
                    "status" => false,
                    "message" => "Tidak ada periode yang ditemukan."
                ]);
                return;
            }
    
            $response_data = [];
    
            foreach ($periods as $period) {
                $period_id = $period['period_id'];
    
                // Ambil data pelanggaran berdasarkan periode
                $pelanggaran = $this->Pelanggaran_model->get_by_student_period($student['student_id'], $period_id);
                
                // Hitung total pelanggaran (jumlah poin) per periode
                $total_pelanggaran = $this->Pelanggaran_model->get_yearly_violations($student['student_id'], $period_id);
    
                // Format data pelanggaran
                $pelanggaran_grouped = [];
                foreach ($pelanggaran as $item) {
                    $pelanggaran_grouped[] = [
                        "title" => $item['pelanggaran'],
                        "description" => $item['tindakan'],
                        "date" => $item['tanggal'],
                        "notes" => $item['catatan'],
                        "points" => $item['poin']
                    ];
                }
    
                // Tambahkan data periode ke response
                $response_data[] = [
                    'period' => [
                        'period_id' => $period['period_id'],
                        'period_start' => $period['period_start'],
                        'period_end' => $period['period_end'],
                        'status' => $period['period_status']
                    ],
                    'student' => [
                        'student_id' => $student['student_id'],
                        'full_name' => $student['student_full_name'],
                        'class_name' => $class_name
                    ],
                    'total_pelanggaran' => $total_pelanggaran, // Total poin pelanggaran di periode ini
                    'pelanggaran' => $pelanggaran_grouped
                ];
            }
    
            // Kembalikan data dalam format JSON
            echo json_encode([
                'status' => true,
                'message' => 'Data pelanggaran berhasil diambil.',
                'data' => $response_data
            ]);
    
        } catch (Exception $e) {
            // Tangkap error dan log
            file_put_contents('debug_log.txt', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    
            // Kembalikan error ke client
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
            http_response_code(500);
        }
    }
    
    

    public function get_health_data()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        $kesehatan = $this->Health_model->get_by_student($student['student_id']);

        echo json_encode([
            "status" => true,
            "message" => "Health data retrieved successfully.",
            "data" => $kesehatan
        ]);
    }

    public function get_nadzhaman_data()
    {
        header('Content-Type: application/json');
    
        // Validasi token dan dapatkan data siswa
        $student = $this->validate_token();
    
        if (!$student) {
            echo json_encode(["status" => false, "message" => "Invalid token."]);
            return;
        }
    
        // Ambil data kelas siswa
        $student_class = $this->Class_model->get(['student_id' => $student['student_id']]);
        $class_name = isset($student_class['class_name']) ? $student_class['class_name'] : 'Tidak Ada Data';
    
        // Ambil semua periode
        $periods = $this->Period_model->get();
    
        if (empty($periods)) {
            echo json_encode(["status" => false, "message" => "No periods found."]);
            return;
        }
    
        $response_data = [];
    
        foreach ($periods as $period) {
            $period_id = $period['period_id'];
    
            // Ambil data nadzhaman siswa berdasarkan periode
            $nadzhaman = $this->Nadzhaman_model->get([
                'student_id' => $student['student_id'],
                'period_id' => $period_id
            ]);
    
            // Ambil daftar kitab yang diajarkan di kelas siswa pada periode ini
            $class_kitabs = $this->KitabDikelas_model->get_by_class($student_class['class_id'], $period_id);
    
            $kitab_list = [];
    
            foreach ($class_kitabs as $kitab) {
                // Ambil detail kitab
                $kitab_detail = $this->Kitab_model->get(['kitab_id' => $kitab['kitab_id']]);
    
                $kitab_list[] = [
                    'kitab_id' => $kitab['kitab_id'],
                    'nama_kitab' => isset($kitab_detail['nama_kitab']) ? $kitab_detail['nama_kitab'] : 'Tidak Diketahui',
                    'target_hafalan' => isset($kitab_detail['target']) ? $kitab_detail['target'] : 0
                ];
            }
    
            // Rekap jumlah hafalan per bulan
            $monthly_hafalan = $this->Nadzhaman_model->get_monthly_hafalan($student['student_id'], $period_id);
    
            $response_data[] = [
                'period' => [
                    'period_id' => $period_id,
                    'period_start' => $period['period_start'],
                    'period_end' => $period['period_end'],
                    'status' => $period['period_status']
                ],
                'student' => [
                    'student_id' => $student['student_id'],
                    'full_name' => $student['student_full_name'],
                    'class_name' => $class_name,
                ],
                'kitabs' => $kitab_list,
                'nadzhaman' => $nadzhaman,
                'monthly_hafalan' => $monthly_hafalan
            ];
        }
    
        // Susun respons JSON
        $response = [
            'status' => true,
            'message' => 'All Nadzhaman data retrieved successfully.',
            'data' => $response_data
        ];
    
        echo json_encode($response);
    }
    
    
    public function get_payout_data()
    {
        header('Content-Type: application/json');
        
        // Validasi token
        $student = $this->validate_token();
    
        // Ambil semua periode
        $periods = $this->Period_model->get(); // Ambil semua periode yang ada
        if (empty($periods)) {
            echo json_encode([
                "status" => false,
                "message" => "No periods found."
            ]);
            return;
        }
    
        $response_data = [];
        foreach ($periods as $period) {
            $period_id = $period['period_id'];
    
            // Ambil data pembayaran bulanan untuk periode ini
            $bulan_payments = $this->Bulan_model->get([
                'student_id' => $student['student_id'],
                'period_id' => $period_id
            ]) ?: [];
    
            // Ambil data pembayaran bebas untuk periode ini
            $bebas_payments = $this->Bebas_model->get([
                'student_id' => $student['student_id'],
                'period_id' => $period_id
            ]) ?: [];
    
            // Total tagihan dan pembayaran untuk periode ini
            $total_bulan = array_sum(array_column($bulan_payments, 'bulan_bill'));
            $total_paid_bulan = array_reduce($bulan_payments, function ($carry, $item) {
                return $carry + ($item['bulan_status'] == 1 ? $item['bulan_bill'] : 0);
            }, 0);
    
            $total_bebas = array_sum(array_column($bebas_payments, 'bebas_bill'));
            $total_paid_bebas = array_sum(array_column($bebas_payments, 'bebas_total_pay'));
    
            $total_tagihan_periode = $total_bulan + $total_bebas;
            $total_paid_periode = $total_paid_bulan + $total_paid_bebas;
    
            // Data pembayaran bulanan
            $bulan_grouped = [];
            foreach ($bulan_payments as $payment) {
                $bulan_grouped[] = [
                    'bulan_id' => $payment['bulan_id'],
                    'month_name' => $payment['month_name'],
                    'bill' => $payment['bulan_bill'],
                    'status' => $payment['bulan_status'],
                    'date_pay' => $payment['bulan_date_pay'],
                    'last_update' => $payment['bulan_last_update'],
                    'pos_name' => $payment['pos_name']
                ];
            }
    
            // Data pembayaran bebas
            $bebas_grouped = [];
            foreach ($bebas_payments as $payment) {
                $bebas_grouped[] = [
                    'bebas_id' => $payment['bebas_id'],
                    'bill' => $payment['bebas_bill'],
                    'total_pay' => $payment['bebas_total_pay'],
                    'last_update' => $payment['bebas_last_update'],
                    'pos_name' => $payment['pos_name']
                ];
            }
    
            // Tambahkan data periode ke respons
            $response_data[] = [
                'period' => [
                    'period_id' => $period['period_id'],
                    'period_start' => $period['period_start'],
                    'period_end' => $period['period_end'],
                    'status' => $period['period_status'], // 1 = aktif, 0 = tidak aktif
                ],
                'payments' => [
                    'bulan' => [
                        'details' => $bulan_grouped,
                        'total' => $total_bulan,
                        'total_paid' => $total_paid_bulan
                    ],
                    'bebas' => [
                        'details' => $bebas_grouped,
                        'total' => $total_bebas,
                        'total_paid' => $total_paid_bebas
                    ]
                ],
                'summary' => [
                    'total_tagihan' => $total_tagihan_periode,
                    'total_paid' => $total_paid_periode,
                    'remaining_payment' => $total_tagihan_periode - $total_paid_periode
                ]
            ];
        }
    
        // Respons JSON
        echo json_encode([
            'status' => true,
            'message' => 'All payment data with periods retrieved successfully.',
            'data' => $response_data
        ]);
    }
    
    public function create_transaction()
    {
        header('Content-Type: application/json');

        // Ambil data dari request POST
        $order_id = $this->input->post('order_id', true);
        $gross_amount = $this->input->post('gross_amount', true);
        $item_details = json_decode($this->input->post('item_details', true), true);
        $customer_details = json_decode($this->input->post('customer_details', true), true);

        // Validasi input
        if (empty($order_id) || empty($gross_amount) || empty($item_details) || empty($customer_details)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid input. Please provide all required fields.'
            ]);
            return;
        }

        // Konfigurasi transaksi untuk Midtrans
        $transaction = [
            'transaction_details' => [
                'order_id' => $order_id,
                'gross_amount' => $gross_amount,
            ],
            'item_details' => $item_details,
            'customer_details' => $customer_details,
        ];

        try {
            // Buat Snap Token
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            echo json_encode(['status' => true, 'snapToken' => $snapToken]);
        } catch (\Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        }
    }

    
    
    

}
