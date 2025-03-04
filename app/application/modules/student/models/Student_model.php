<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Student_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Get From Databases
    function get($params = array()) {
        if (isset($params['id'])) {
            $this->db->where('student.student_id', $params['id']);
        }
        if (isset($params['student_id'])) {
            $this->db->where('student.student_id', $params['student_id']);
        }
        if (isset($params['multiple_id'])) {
            $this->db->where_in('student.student_id', $params['multiple_id']);
        }
        if (!empty($params['multiple_id'])) {
            $this->db->where_in('student.student_id', $params['multiple_id']);
        }
    
        if (isset($params['student_search'])) {
            $this->db->group_start();
            $this->db->like('student_nis', $params['student_search']);
            $this->db->or_like('student_full_name', $params['student_search']);
            $this->db->group_end();
        }
    
        if (isset($params['student_nis'])) {
            $this->db->where('student.student_nis', $params['student_nis']);
        }
    
        if (isset($params['nis'])) {
            $this->db->like('student_nis', $params['nis']);
        }
    
        if (isset($params['password'])) {
            $this->db->where('student_password', $params['password']);
        }
    
        if (isset($params['student_full_name'])) {
            $this->db->where('student.student_full_name', $params['student_full_name']);
        }
    
        if (isset($params['status'])) {
            $this->db->where('student.student_status', $params['status']);
        }
    
        if (isset($params['date'])) {
            $this->db->where('student_input_date', $params['date']);
        }
    
        if (isset($params['class_id'])) {
            $this->db->where('class_class_id', $params['class_id']);
        }
    
        if (isset($params['majors_id'])) {
            $this->db->where('majors_majors_id', $params['majors_id']);
        }
    
        if (isset($params['class_name'])) {
            $this->db->like('class_name', $params['class_name']);
        }
    
        if (isset($params['group'])) {
            $this->db->group_by('student.class_class_id');
        }
    
        if (isset($params['limit'])) {
            if (!isset($params['offset'])) {
                $params['offset'] = NULL;
            }
            $this->db->limit($params['limit'], $params['offset']);
        }
    
        if (isset($params['order_by'])) {
            $this->db->order_by($params['order_by'], 'desc');
        } else {
            $this->db->order_by('student_last_update', 'desc');
        }
    
        // 🔥 **Tambahkan `majors.komplek_id` di SELECT**
        $this->db->select('
            student.student_id, student_nis, student_nisn, student_password, student_gender, 
            student_phone, student_hobby, student_address, student_parent_phone, student_full_name, 
            student_born_place, student_born_date, student_img, student_status, student_name_of_mother, 
            student_name_of_father, student_input_date, student_last_update,
            class_class_id, class.class_name,
            majors_majors_id, majors.majors_name, majors_short_name, majors.komplek_id,
            komplek.komplek_name
        ');
    
        // 🔄 **Perbaiki urutan JOIN**
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left'); // 🚀 JOIN setelah majors
    
        $res = $this->db->get('student');
    
        if (isset($params['id']) || isset($params['student_nis'])) {
            return $res->row_array();
        } else {
            return $res->result_array();
        }
    }
    
    public function get_filtered_students($params = array()) {
        $this->db->select('
            student.student_id, student.student_nis, student.student_nisn, student.student_full_name, 
            student.student_gender, student.student_phone, student.student_hobby, student.student_address, 
            student.student_parent_phone, student.student_name_of_mother, student.student_name_of_father, 
            student.student_img, student.student_status, student.student_input_date, student.student_last_update,
            student.student_born_place, student.student_born_date,
            class.class_id, class.class_name,
            majors.majors_id, majors.majors_name,
            komplek.komplek_id, komplek.komplek_name
        ');
    
        $this->db->from('student');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
        $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left');
    
        // **Filter hanya santri yang aktif**
        if (!isset($params['student_status'])) {
            $this->db->where('student.student_status', 1);
        } else {
            $this->db->where('student.student_status', $params['student_status']);
        }
    
        // **Filter berdasarkan komplek**
        if (!empty($params['komplek_id'])) {
            $this->db->where('komplek.komplek_id', $params['komplek_id']);
        }
    
        // **Filter berdasarkan NIS atau Nama**
        if (!empty($params['student_search'])) {
            $this->db->group_start();
            $this->db->like('student.student_nis', $params['student_search']);
            $this->db->or_like('student.student_full_name', $params['student_search']);
            $this->db->group_end();
        }
    
        // **Filter berdasarkan Kelas**
        if (!empty($params['class_id'])) {
            $this->db->where('student.class_class_id', $params['class_id']);
        }
    
        // **Filter berdasarkan Kamar (Asrama)**
        if (!empty($params['majors_id'])) {
            $this->db->where('student.majors_majors_id', $params['majors_id']);
        }
    
        // **Urutkan berdasarkan terakhir diperbarui**
        $this->db->order_by('student.student_last_update', 'DESC');
    
        // **Pagination**
        if (isset($params['limit']) && isset($params['offset'])) {
            $this->db->limit($params['limit'], $params['offset']);
        } elseif (isset($params['limit'])) {
            $this->db->limit($params['limit']);
        }
    
        return $this->db->get()->result_array();
    }
    
    
    public function get_all_classes() {
        $this->db->select('class_id, class_name');
        return $this->db->get('class')->result_array();
    }
    
    public function get_all_majors() {
        $this->db->select('majors_id, majors_name');
        return $this->db->get('majors')->result_array();
    }
    

    // Mendapatkan semua santri
    public function get_all_santri() {
        $this->db->select('student_nis, student_full_name');
        $this->db->where('student_status', 1); // Mengambil hanya siswa aktif
        $this->db->order_by('student_full_name', 'asc');
        return $this->db->get('student')->result_array();
    }

    // Mendapatkan santri berdasarkan token
    public function get_by_token($token) {
        $this->db->select('*');
        $this->db->from('student');
        $this->db->where('token', $token);
        return $this->db->get()->row_array();
    }
    public function count_filtered_students($params = array()) {
        $this->db->from('student');
    
        if (!isset($params['student_status'])) {
            $this->db->where('student.student_status', 1); // Hanya santri aktif
        } else {
            $this->db->where('student.student_status', $params['student_status']);
        }
    
        if (!empty($params['student_search'])) {
            $this->db->group_start();
            $this->db->like('student.student_nis', $params['student_search']);
            $this->db->or_like('student.student_full_name', $params['student_search']);
            $this->db->group_end();
        }
    
        if (!empty($params['class_id'])) {
            $this->db->where('student.class_class_id', $params['class_id']);
        }
    
        if (!empty($params['majors_id'])) {
            $this->db->where('student.majors_majors_id', $params['majors_id']);
        }
    
        return $this->db->count_all_results();
    }
    
    // Mendapatkan data pelanggaran berdasarkan student_id
    public function get_by_student($student_id) {
        $this->db->where('student_id', $student_id);
        return $this->db->get('pelanggaran')->result_array();
    }

    // Mencari santri berdasarkan keyword
    public function search_santri($keyword) {
        $this->db->select('student_nis, student_full_name');
        $this->db->from('student');
        $this->db->where('student_status', 1); // Hanya ambil santri aktif
        $this->db->group_start(); // Mulai grup kondisi OR
        $this->db->like('student_full_name', $keyword);
        $this->db->or_like('student_nis', $keyword);
        $this->db->group_end(); // Tutup grup kondisi OR
        $this->db->order_by('student_full_name', 'asc');
        $this->db->limit(10); // Batasi hasil agar lebih ringan
        return $this->db->get()->result_array();
    }
    

    // Mendapatkan semua data santri
    public function get_all() {
        $this->db->select('*');
        return $this->db->get('student')->result_array();
    }

    // Mendapatkan data santri berdasarkan ID
    public function get_by_id($student_id) {
        $this->db->where('student_id', $student_id);
        return $this->db->get('student')->row_array();
    }

    // Mendapatkan data kelas
    public function get_class($params = array()) {
        $this->db->select('class_id, class_name');
        $this->db->from('class');
    
        // Jika ada ID kelas, filter berdasarkan ID
        if (isset($params['id']) && !empty($params['id'])) {
            $this->db->where('class_id', $params['id']);
            $query = $this->db->get();
            return $query->row_array(); // Mengembalikan satu baris data (associative array)
        }
    
        // Jika ada nama kelas, filter berdasarkan nama
        if (isset($params['class_name']) && !empty($params['class_name'])) {
            $this->db->where('class_name', $params['class_name']);
        }
    
        // Jika ada limit & offset
        if (isset($params['limit'])) {
            $this->db->limit($params['limit'], isset($params['offset']) ? $params['offset'] : NULL);
        }
    
        $query = $this->db->get();
        return $query->result_array(); // Mengembalikan banyak data (array of arrays)
    }
    

    public function get_parents_phones($student_ids)
    {
        $this->db->select('student_parent_phone');
        $this->db->where_in('student_id', $student_ids);
        $query = $this->db->get('student');
    
        $phones = [];
        foreach ($query->result() as $row) {
            if (!empty($row->student_parent_phone)) {
                $phones[] = preg_replace('/[^0-9]/', '', $row->student_parent_phone); // Hapus karakter selain angka
            }
        }
    
        return $phones;
    }
    


function get_majors($params = array())
{
    if (isset($params['id'])) {
        $this->db->where('majors.majors_id', $params['id']);
    }

    if (isset($params['majors_name'])) {
        $this->db->where('majors.majors_name', $params['majors_name']);
    }

    if (isset($params['majors_short_name'])) {
        $this->db->where('majors.majors_short_name', $params['majors_short_name']);
    }

    if (isset($params['komplek_id'])) {
        $this->db->where('majors.komplek_id', $params['komplek_id']);
    }

    if (isset($params['limit'])) {
        if (!isset($params['offset'])) {
            $params['offset'] = NULL;
        }
        $this->db->limit($params['limit'], $params['offset']);
    }

    if (isset($params['order_by'])) {
        $this->db->order_by($params['order_by'], 'desc');
    } else {
        $this->db->order_by('majors.majors_id', 'asc');
    }

    // Menambahkan relasi ke tabel komplek
    $this->db->select('majors.majors_id, majors.majors_name, majors.majors_short_name, majors.komplek_id');
    $this->db->select('komplek.komplek_name');
    $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left'); 

    $res = $this->db->get('majors');

    if (isset($params['id'])) {
        return $res->row_array();
    } else {
        return $res->result_array();
    }
}
public function get_kamar_by_komplek($komplek_id) {
    $this->db->select('majors.majors_id, majors.majors_name, komplek.komplek_name');
    $this->db->from('majors');
    $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left');
    $this->db->where('majors.komplek_id', $komplek_id);
    return $this->db->get()->result_array();
}


public function get_komplek($params = array()) {
    if (isset($params['id'])) {
        $this->db->where('komplek_id', $params['id']);
    }

    if (isset($params['komplek_name'])) {
        $this->db->where('komplek_name', $params['komplek_name']);
    }

    $this->db->order_by('komplek_name', 'asc');
    $this->db->select('komplek_id, komplek_name');
    $res = $this->db->get('komplek');

    if (isset($params['id'])) {
        return $res->row_array();
    } else {
        return $res->result_array();
    }
}


public function get_students_by_komplek() {
    $this->db->select('komplek.komplek_name, COUNT(student.student_id) as total_students');
    $this->db->from('student');
    $this->db->join('majors', 'majors.majors_id = student.majors_majors_id', 'left');
    $this->db->join('komplek', 'komplek.komplek_id = majors.komplek_id', 'left');
    $this->db->where('student.student_status', 1); // Hanya menghitung santri aktif
    $this->db->group_by('komplek.komplek_id');
    $this->db->order_by('total_students', 'DESC');

    return $this->db->get()->result_array();
}


public function get_santri_masuk_keluar($month, $year) {
    $this->db->select("
        COUNT(CASE WHEN MONTH(student_input_date) = $month AND YEAR(student_input_date) = $year THEN 1 END) AS total_masuk,
        COUNT(CASE WHEN student_status = 0 AND MONTH(student_last_update) = $month AND YEAR(student_last_update) = $year THEN 1 END) AS total_keluar
    ");
    return $this->db->get('student')->row_array();
}


    public function get_fcm_token($student_id) {
        $this->db->select('fcm_token');
        $this->db->from('student_tokens');
        $this->db->where('student_id', $student_id);
        $this->db->where('fcm_token IS NOT NULL', null, false);
        $this->db->order_by('created_at', 'DESC'); // Ambil token terbaru
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array()['fcm_token'];
        } else {
            return null;
        }
    }
    

    // Mendapatkan data santri berdasarkan NIS
    public function get_by_nis($nis) {
        $this->db->select('student_id, student_nis, student_full_name, class_name, student_name_of_mother, student_img, student_name_of_father, student_parent_phone');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->where('student_nis', $nis);
        $this->db->where('student_status', 1);
        return $this->db->get('student')->row_array();
    }

    // Mendapatkan NIS berdasarkan ID
    public function get_nis_by_id($student_id) {
        $this->db->where('student_id', $student_id);
        return $this->db->get('student')->row_array();
    }

    // Mendapatkan total poin pelanggaran
    public function get_total_points($student_id) {
        $this->db->select_sum('poin', 'total_points');
        $this->db->where('student_id', $student_id);
        $query = $this->db->get('pelanggaran');
        return isset($query->row()->total_points) ? $query->row()->total_points : 0;



    }

    public function get_total_points_by_period($student_id, $period_id)
{
    $this->db->select_sum('poin', 'total_points');
    $this->db->where('student_id', $student_id);
    $this->db->where('period_id', $period_id); // Pastikan kolom ini ada di tabel pelanggaran
    $query = $this->db->get('pelanggaran');

    return isset($query->row()->total_points) ? $query->row()->total_points : 0; // Jika tidak ada pelanggaran, kembalikan 0
}
    // Fungsi untuk mengelompokkan siswa berdasarkan kelasnya
    public function get_students_by_class() {
        $this->db->select('class.class_name, COUNT(student.student_id) as total_students');
        $this->db->from('student');
        $this->db->join('class', 'class.class_id = student.class_class_id', 'left');
        $this->db->where('student.student_status', 1); // Hanya menghitung siswa aktif
        $this->db->group_by('class.class_name');
        $this->db->order_by('total_students', 'DESC');

        return $this->db->get()->result_array();
    }


    function add($data = array()) {

        if (isset($data['student_id'])) {
            $this->db->set('student_id', $data['student_id']);
        }

        if (isset($data['student_nis'])) {
            $this->db->set('student_nis', $data['student_nis']);
        }

        if (isset($data['student_nisn'])) {
            $this->db->set('student_nisn', $data['student_nisn']);
        }

        if (isset($data['student_password'])) {
            $this->db->set('student_password', $data['student_password']);
        }

        if (isset($data['student_gender'])) {
            $this->db->set('student_gender', $data['student_gender']);
        }

        if (isset($data['student_phone'])) {
            $this->db->set('student_phone', $data['student_phone']);
        }

        if (isset($data['student_parent_phone'])) {
            $this->db->set('student_parent_phone', $data['student_parent_phone']);
        }

        if (isset($data['student_hobby'])) {
            $this->db->set('student_hobby', $data['student_hobby']);
        }

        if (isset($data['student_address'])) {
            $this->db->set('student_address', $data['student_address']);
        }

        if (isset($data['student_name_of_father'])) {
            $this->db->set('student_name_of_father', $data['student_name_of_father']);
        }

        if (isset($data['student_full_name'])) {
            $this->db->set('student_full_name', $data['student_full_name']);
        }

        if (isset($data['student_img'])) {
            $this->db->set('student_img', $data['student_img']);
        }

        if (isset($data['student_born_place'])) {
            $this->db->set('student_born_place', $data['student_born_place']);
        }

        if (isset($data['student_born_date'])) {
            $this->db->set('student_born_date', $data['student_born_date']);
        }

        if (isset($data['student_name_of_mother'])) {
            $this->db->set('student_name_of_mother', $data['student_name_of_mother']);
        }

        if (isset($data['class_class_id'])) {
            $this->db->set('class_class_id', $data['class_class_id']);
        }

        if (isset($data['majors_majors_id'])) {
            $this->db->set('majors_majors_id', $data['majors_majors_id']);
        }

        if (isset($data['student_status'])) {
            $this->db->set('student_status', $data['student_status']);
        }

        if (isset($data['student_input_date'])) {
            $this->db->set('student_input_date', $data['student_input_date']);
        }

        if (isset($data['student_last_update'])) {
            $this->db->set('student_last_update', $data['student_last_update']);
        }

        if (isset($data['student_id'])) {
            $this->db->where('student_id', $data['student_id']);
            $this->db->update('student');
            $id = $data['student_id'];
        } else {
            $this->db->insert('student');
            $id = $this->db->insert_id();
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function add_class($data = array()) {

        if (isset($data['class_id'])) {
            $this->db->set('class_id', $data['class_id']);
        }

        if (isset($data['class_name'])) {
            $this->db->set('class_name', $data['class_name']);
        }

        if (isset($data['class_id'])) {
            $this->db->where('class_id', $data['class_id']);
            $this->db->update('class');
            $id = $data['class_id'];
        } else {
            $this->db->insert('class');
            $id = $this->db->insert_id(); 
        }

        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }

    function add_majors($data = array()) {
        // Pastikan ID kamar ditangani saat update
        if (isset($data['majors_id'])) {
            $this->db->set('majors_id', $data['majors_id']);
        }
    
        // Simpan nama kamar
        if (isset($data['majors_name'])) {
            $this->db->set('majors_name', $data['majors_name']);
        }
    
        // Simpan singkatan kamar
        if (isset($data['majors_short_name'])) {
            $this->db->set('majors_short_name', $data['majors_short_name']);
        }
    
        // **Tambahkan penyimpanan komplek_id**
        if (isset($data['komplek_id'])) {
            $this->db->set('komplek_id', $data['komplek_id']);
        }
    
        if (isset($data['majors_id'])) {
            // Jika update data
            $this->db->where('majors_id', $data['majors_id']);
            $this->db->update('majors');
            $id = $data['majors_id'];
        } else {
            // Jika insert data baru
            $this->db->insert('majors');
            $id = $this->db->insert_id();
        }
    
        // // Debug query untuk memastikan `komplek_id` tersimpan
        // echo "<pre>";
        // print_r($data);
        // echo "Query: " . $this->db->last_query();
        // echo "</pre>";
        // // exit(); // Gunakan ini untuk debugging sementara
    
        $status = $this->db->affected_rows();
        return ($status == 0) ? FALSE : $id;
    }
    

    function delete($id) {
        $this->db->where('student_id', $id);
        $this->db->delete('student');
    }

    function delete_class($id) {
        $this->db->where('class_id', $id);
        $this->db->delete('class');
    }

    function delete_majors($id) {
        $this->db->where('majors_id', $id);
        $this->db->delete('majors');
    }


    public function update_majors($majors_id, $data)
{
    $this->db->where('majors_id', $majors_id);
    $this->db->update('majors', $data);
    return $this->db->affected_rows();
}


    public function is_exist($field, $value)
    {
        $this->db->where($field, $value);        

        return $this->db->count_all_results('student') > 0 ? TRUE : FALSE;
    }

    function change_password($id, $params) {
        $this->db->where('student_id', $id);
        $this->db->update('student', $params);
    }

}
