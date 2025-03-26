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
            'information/Information_model',
            'ltrx/Log_trx_model',
            'absen_jamaah/Absen_jamaah_model',
            'absen_mengaji/Absen_mengaji_model',
            'izin_pulang/Izin_pulang_model',
            'amalan/Amalan_model'
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

    public function dashboard()
    {
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



    public function information()
    {
        header('Content-Type: application/json');

        try {
            $student = $this->validate_token();

            $page = $this->input->get('page') ?: 1;
            $limit = $this->input->get('limit') ?: 10;
            $offset = ($page - 1) * $limit;

            // Perbaiki parameter yang dikirim ke model
            $params = [
                'information_publish' => 1,
                'order_by' => 'information_input_date', // HAPUS DESC DISINI
                'limit' => $limit,
                'offset' => $offset
            ];

            $total_records = $this->Information_model->count(['information_publish' => 1]);
            $informations = $this->Information_model->get($params);

            // Tambahkan pengecekan empty image
            foreach ($informations as &$info) {
                $info['formatted_date'] = date('d F Y', strtotime($info['information_input_date']));
                $info['information_desc'] = preg_replace('/\sxss=removed/', '', $info['information_desc']);

                if (!empty($info['information_img'])) {
                    $info['image_url'] = base_url("uploads/information/{$info['information_img']}");
                } else {
                    $info['image_url'] = null;
                }
            }

            $response = [
                'status' => true,
                'message' => 'Data informasi berhasil diambil',
                'data' => [
                    'total_records' => (int)$total_records,
                    'total_pages' => ceil($total_records / $limit),
                    'current_page' => (int)$page,
                    'informations' => $informations ?: []
                ]
            ];
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage(),
                'data' => null
            ];
        }

        echo json_encode($response);
        exit; // Tambahkan exit untuk menghindari header error
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
            $student = $this->validate_token();
            if (!$student) {
                throw new Exception('Token tidak valid atau siswa tidak ditemukan.');
            }

            // Ambil parameter filter
            $period_id = $this->input->get('period_id');
            $jenis_pelanggaran = $this->input->get('jenis_pelanggaran');

            // Load model tambahan
            $this->load->model('absen_jamaah/Absen_jamaah_model');
            $this->load->model('absen_mengaji/Absen_mengaji_model');

            // Ambil informasi kelas siswa
            $student_class = $this->Class_model->get(['student_id' => $student['student_id']]);
            $class_name = isset($student_class['class_name']) ? $student_class['class_name'] : 'Tidak Ada Data';

            // Ambil periode
            $periods = $period_id
                ? $this->Period_model->get(['period_id' => $period_id])
                : $this->Period_model->get();

            $response_data = [];

            foreach ($periods as $period) {
                $current_period_id = $period['period_id'];

                // 1. Data Pelanggaran Umum
                $pelanggaran_umum = $this->Pelanggaran_model->get_by_student_period(
                    $student['student_id'],
                    $current_period_id
                );

                // 2. Data Absen Jamaah
                $pelanggaran_jamaah = $this->Absen_jamaah_model->get_by_student(
                    $student['student_id'],
                    $current_period_id
                );

                // 3. Data Absen Mengaji (BARU)
                $pelanggaran_mengaji = $this->Absen_mengaji_model->get_by_student(
                    $student['student_id'],
                    $current_period_id
                );

                // Format data untuk response
                $formatted_umum = array_map(function ($item) {
                    return [
                        "jenis" => "umum",
                        "judul" => $item['pelanggaran'],
                        "deskripsi" => $item['tindakan'],
                        "tanggal" => $item['tanggal'],
                        "catatan" => $item['catatan'],
                        "poin" => $item['poin']
                    ];
                }, $pelanggaran_umum);

                $formatted_jamaah = array_map(function ($item) {
                    return [
                        "jenis" => "jamaah",
                        "judul" => "Ketidakhadiran Jamaah",
                        "periode_absen" => [
                            "mulai" => $item['tanggal_mulai'],
                            "selesai" => $item['tanggal_selesai']
                        ],
                        "jumlah_absen" => $item['jumlah_tidak_jamaah'],
                        "catatan" => $item['keterangan']
                    ];
                }, $pelanggaran_jamaah);

                // Format data mengaji (BARU)
                $formatted_mengaji = array_map(function ($item) {
                    return [
                        "jenis" => "mengaji",
                        "judul" => "Ketidakhadiran Mengaji",
                        "periode_absen" => [
                            "mulai" => $item['tanggal_mulai'],
                            "selesai" => $item['tanggal_selesai']
                        ],
                        "jumlah_absen" => $item['jumlah_absen'],
                        "catatan" => $item['keterangan']
                    ];
                }, $pelanggaran_mengaji);

                // Gabungkan semua data
                $combined_pelanggaran = array_merge(
                    $formatted_umum,
                    $formatted_jamaah,
                    $formatted_mengaji
                );

                // Filter berdasarkan jenis
                if ($jenis_pelanggaran) {
                    $combined_pelanggaran = array_filter($combined_pelanggaran, function ($item) use ($jenis_pelanggaran) {
                        return $item['jenis'] === $jenis_pelanggaran;
                    });
                }

                // Hitung statistik
                $statistik = [
                    'umum' => [
                        'total_pelanggaran' => count($pelanggaran_umum),
                        'total_poin' => array_sum(array_column($pelanggaran_umum, 'poin'))
                    ],
                    'jamaah' => [
                        'total_pelanggaran' => count($pelanggaran_jamaah),
                        'total_absen' => array_sum(array_column($pelanggaran_jamaah, 'jumlah_tidak_jamaah'))
                    ],
                    'mengaji' => [ // BARU
                        'total_pelanggaran' => count($pelanggaran_mengaji),
                        'total_absen' => array_sum(array_column($pelanggaran_mengaji, 'jumlah_absen'))
                    ]
                ];

                // Susun response
                $response_data[] = [
                    'period' => [
                        'id' => $period['period_id'],
                        'tahun_ajaran' => $period['period_start'] . '/' . $period['period_end'],
                        'status' => $period['period_status'] ? 'Aktif' : 'Tidak Aktif'
                    ],
                    'siswa' => [
                        'id' => $student['student_id'],
                        'nis' => $student['student_nis'],
                        'nama_lengkap' => $student['student_full_name'],
                        'kelas' => $class_name
                    ],
                    'statistik' => $statistik,
                    'detail_pelanggaran' => array_values($combined_pelanggaran)
                ];
            }

            echo json_encode([
                'status' => true,
                'message' => 'Data pelanggaran berhasil diambil.',
                'data' => $response_data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage()
            ]);
            http_response_code(500);
        }
    }


    public function get_izin_data()
    {
        header('Content-Type: application/json');

        try {
            $student = $this->validate_token();
            if (!$student) {
                throw new Exception('Invalid token or student not found.');
            }

            // Ambil data kelas siswa
            $student_class = $this->Class_model->get(['student_id' => $student['student_id']]);
            $class_name = isset($student_class['class_name']) ? $student_class['class_name'] : 'Tidak Ada Data';

            // Ambil semua periode akademik
            $periods = $this->Period_model->get();

            if (empty($periods)) {
                echo json_encode(["status" => false, "message" => "No periods found."]);
                return;
            }

            $response_data = [];

            foreach ($periods as $period) {
                $period_id = $period['period_id'];

                // Ambil data izin untuk periode ini
                $izin_records = $this->Izin_pulang_model->get_by_student_period(
                    $student['student_id'],
                    $period_id
                );

                // Hitung statistik
                $stats = [
                    'total_izin' => count($izin_records),
                    'total_hari' => $this->Izin_pulang_model->get_total_days_by_period($period_id, $student['student_id']),
                    'total_telat' => array_reduce($izin_records, function ($carry, $item) {
                        return $carry + ($item['status'] === 'Terlambat' ? 1 : 0);
                    }, 0)
                ];
                // TAMBAHKAN TOTAL TEPAT WAKTU
                $stats['total_tepat_waktu'] = $stats['total_izin'] - $stats['total_telat'];
                // Ambil data bulanan
                $monthly_data = $this->Izin_pulang_model->get_monthly_days_by_period(
                    $period_id,
                    $student['student_id']
                );

                // Format data bulanan
                $formatted_monthly = [];
                foreach ($monthly_data as $month) {
                    $formatted_monthly[] = [
                        'bulan' => date('F', mktime(0, 0, 0, $month['month'], 10)),
                        'total_hari' => $month['total_days']
                    ];
                }

                // Format data izin
                $formatted_izin = array_map(function ($izin) {
                    return [
                        'izin_id' => $izin['izin_id'],
                        'tanggal_mulai' => date('d F Y', strtotime($izin['tanggal'])),
                        'tanggal_akhir' => date('d F Y', strtotime($izin['tanggal_akhir'])),
                        'jumlah_hari' => $izin['jumlah_hari'],
                        'alasan' => $izin['alasan'],
                        'status' => $izin['status'],
                        'status_aktif' => (date('Y-m-d') >= $izin['tanggal'] && date('Y-m-d') <= $izin['tanggal_akhir'])
                            ? 'Aktif'
                            : 'Selesai'
                    ];
                }, $izin_records);

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
                        'class_name' => $class_name,
                    ],
                    'statistik' => $stats,
                    'rekap_bulanan' => $formatted_monthly,
                    'detail_izin' => $formatted_izin
                ];
            }

            echo json_encode([
                'status' => true,
                'message' => 'Data izin berhasil diambil',
                'data' => $response_data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
            http_response_code(500);
        }
    }

    public function get_amalan()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        try {
            $amalan = $this->Amalan_model->get_amalan();

            if (empty($amalan)) {
                throw new Exception('Belum ada data amalan.');
            }

            echo json_encode([
                'status' => true,
                'message' => 'Data amalan berhasil diambil',
                'data' => $amalan
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Get bab by amalan_id
     * Endpoint: /flutter_integration/get_bab?amalan_id={id}
     * Method: GET
     */
    public function get_bab()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        try {
            $amalan_id = $this->input->get('amalan_id');

            if (!$amalan_id) {
                throw new Exception('Parameter amalan_id diperlukan.');
            }

            $bab = $this->Amalan_model->get_bab($amalan_id);

            if (empty($bab)) {
                throw new Exception('Belum ada bab untuk amalan ini.');
            }

            echo json_encode([
                'status' => true,
                'message' => 'Data bab berhasil diambil',
                'data' => $bab
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }
    }

    /**
     * Get isi bab by bab_id
     * Endpoint: /flutter_integration/get_isi?bab_id={id}
     * Method: GET
     */
    public function get_isi()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        try {
            $bab_id = $this->input->get('bab_id');

            if (!$bab_id) {
                throw new Exception('Parameter bab_id diperlukan.');
            }

            $isi = $this->Amalan_model->get_isi($bab_id);

            if (empty($isi)) {
                throw new Exception('Belum ada konten untuk bab ini.');
            }

            // Tambahkan data bab untuk konteks
            $bab = $this->Amalan_model->get_single_bab($bab_id);

            echo json_encode([
                'status' => true,
                'message' => 'Isi bab berhasil diambil',
                'data' => [
                    'bab_detail' => $bab,
                    'isi_content' => $isi
                ]
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => false,
                'message' => $e->getMessage(),
                'data' => null
            ]);
        }
    }

    public function get_health_data()
    {
        header('Content-Type: application/json');

        try {
            $student = $this->validate_token();
            if (!$student) {
                throw new Exception('Invalid token or student not found.');
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

                // Ambil data kesehatan untuk periode ini
                $health_records = $this->Health_model->get([
                    'student_id' => $student['student_id'],
                    'period_id' => $period_id
                ]);

                // Hitung statistik
                $stats = [
                    'total_sakit' => 0,
                    'masih_sakit' => 0,
                    'sudah_sembuh' => 0,
                    'rata_lama_sakit' => 0
                ];

                $total_days = 0;
                foreach ($health_records as $record) {
                    $stats['total_sakit']++;

                    if ($record['status'] === 'Masih Sakit') {
                        $stats['masih_sakit']++;
                    } else {
                        $stats['sudah_sembuh']++;
                    }

                    // Hitung lama sakit
                    $start = new DateTime($record['tanggal']);
                    $end = $record['tanggal_sembuh'] ?
                        new DateTime($record['tanggal_sembuh']) :
                        new DateTime();
                    $total_days += $end->diff($start)->days;
                }

                // Hitung rata-rata
                if ($stats['total_sakit'] > 0) {
                    $stats['rata_lama_sakit'] = round($total_days / $stats['total_sakit'], 1);
                }

                // Format data kesehatan
                $formatted_records = array_map(function ($record) {
                    return [
                        'tanggal' => $record['tanggal'],
                        'tanggal_sembuh' => $record['tanggal_sembuh'],
                        'kondisi' => $record['kondisi_kesehatan'],
                        'tindakan' => $record['tindakan'],
                        'status' => $record['status'],
                        'catatan' => $record['catatan']
                    ];
                }, $health_records);

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
                        'class_name' => $class_name,
                    ],
                    'statistik' => $stats,
                    'riwayat_kesehatan' => $formatted_records
                ];
            }

            echo json_encode([
                'status' => true,
                'message' => 'Health data retrieved successfully.',
                'data' => $response_data
            ]);
        } catch (Exception $e) {
            echo json_encode([
                "status" => false,
                "message" => $e->getMessage(),
                "data" => null
            ]);
            http_response_code(500);
        }
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

    public function get_recent_transactions()
    {
        header('Content-Type: application/json');
        $student = $this->validate_token();

        try {
            // Ambil parameter dari request
            $limit = $this->input->get('limit') ? (int)$this->input->get('limit') : 10;
            $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
            $offset = ($page - 1) * $limit;

            // Parameter untuk model
            $params = [
                'student_id' => $student['student_id'],
                'order_by' => 'log_trx_input_date',
                'limit' => $limit,
                'offset' => $offset
            ];

            // Ambil data dari model
            $transactions = $this->Log_trx_model->get($params);
            $total_transactions = $this->Log_trx_model->count($params);

            // Format data response
            $formatted_transactions = [];
            $total_paid = 0;
            $total_bill = 0;

            foreach ($transactions as $transaction) {
                $is_monthly = !is_null($transaction['bulan_bulan_id']);
                $payment_type = $is_monthly ? 'BULANAN' : 'BEBAS';

                // Status transaksi
                $status = 'PENDING';
                $amount = 0;
                $receipt_number = 'N/A';

                if ($is_monthly) {
                    // Transaksi bulanan
                    $status = isset($transaction['bulan_status']) && $transaction['bulan_status'] ? 'DIBAYAR' : 'PENDING';
                    $amount = isset($transaction['bulan_bill']) ? (int)$transaction['bulan_bill'] : 0;
                    $receipt_number = isset($transaction['bulan_number_pay']) ? $transaction['bulan_number_pay'] : 'N/A';
                } else {
                    // Transaksi bebas
                    $total_tagihan_bebas = isset($transaction['bebas_bill']) ? (int)$transaction['bebas_bill'] : 0;
                    $total_terbayar = isset($transaction['bebas_pay_bill']) ? (int)$transaction['bebas_pay_bill'] : 0;

                    if ($total_terbayar >= $total_tagihan_bebas) {
                        $status = 'DIBAYAR';
                    } elseif ($total_terbayar > 0) {
                        $status = 'DIBAYAR';
                    } else {
                        $status = 'PENDING';
                    }

                    $amount = $total_tagihan_bebas;
                    $receipt_number = isset($transaction['bebas_pay_number']) ? $transaction['bebas_pay_number'] : 'N/A';
                }

                // Hitung total_bill
                if ($is_monthly) {
                    $total_bill += $amount;
                } else {
                    $total_bill += $amount;
                }

                // Hitung total_paid dengan logika yang benar
                if ($is_monthly) {
                    if ($status === 'DIBAYAR') {
                        $total_paid += $amount;
                    }
                } else {
                    $total_paid += $total_terbayar; // Ambil total yang sudah dibayar, bukan total tagihan
                }

                // Format transaksi
                $formatted = [
                    'transaction_id' => $transaction['log_trx_id'],
                    'payment_type' => $payment_type,
                    'payment_name' => $is_monthly
                        ? (isset($transaction['posmonth_name']) ? $transaction['posmonth_name'] : 'Pembayaran Bulanan')
                        : (isset($transaction['posbebas_name']) ? $transaction['posbebas_name'] : 'Pembayaran Bebas'),
                    'period' => $is_monthly
                        ? (isset($transaction['period_start_month']) ? $transaction['period_start_month'] : '-') . '/' . (isset($transaction['period_end_month']) ? $transaction['period_end_month'] : '-')
                        : (isset($transaction['period_start_bebas']) ? $transaction['period_start_bebas'] : '-') . '/' . (isset($transaction['period_end_bebas']) ? $transaction['period_end_bebas'] : '-'),
                    'amount' => $amount,
                    'transaction_date' => date('Y-m-d H:i:s', strtotime($transaction['log_trx_input_date'])),
                    'status' => $status,
                    'details' => [
                        'month' => $is_monthly ? (isset($transaction['month_name']) ? $transaction['month_name'] : null) : null,
                        'receipt_number' => $receipt_number,
                        'description' => $is_monthly
                            ? 'Pembayaran Bulanan'
                            : sprintf(
                                'Pembayaran Bebas (%s/%s)',
                                number_format($total_terbayar, 0, ',', '.'),
                                number_format($total_tagihan_bebas, 0, ',', '.')
                            )
                    ]
                ];

                $formatted_transactions[] = $formatted;
            }


            // Response structure
            $response = [
                'status' => true,
                'message' => 'Riwayat transaksi berhasil diambil',
                'data' => [
                    'meta' => [
                        'current_page' => $page,
                        'total_pages' => ceil($total_transactions / $limit),
                        'items_per_page' => $limit,
                        'total_items' => $total_transactions
                    ],
                    'summary' => [
                        'total_paid' => $total_paid,
                        'total_bill' => $total_bill,
                        'outstanding_balance' => max(0, $total_bill - $total_paid)


                    ],
                    'transactions' => $formatted_transactions
                ]
            ];
        } catch (Exception $e) {
            $response = [
                'status' => false,
                'message' => 'Gagal mengambil riwayat transaksi: ' . $e->getMessage(),
                'data' => null
            ];
        }

        echo json_encode($response);
        exit;
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
