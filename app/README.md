# 🖥️ Backend Walisantri

**Backend Walisantri** adalah backend berbasis **PHP (CodeIgniter)** yang digunakan untuk mendukung aplikasi **App Walisantri**. Sistem ini berfungsi untuk mengelola data santri, wali santri, pembayaran, absensi, dan berbagai fitur akademik lainnya yang terintegrasi dengan aplikasi mobile berbasis **Flutter**.

---

## ✨ Fitur Utama

✅ **Autentikasi Pengguna** - Sistem login berbasis session untuk wali santri dan admin.  
✅ **Manajemen Data Santri** - CRUD data santri, wali santri, dan pengurus pondok.  
✅ **Pencatatan Pelanggaran & Prestasi** - Memantau pelanggaran dan prestasi santri.  
✅ **Sistem Absensi** - Terintegrasi dengan **Fingerspot Premiere Series** untuk pencatatan absensi santri.  
✅ **Notifikasi Real-time** - Menggunakan **Firebase Cloud Messaging (FCM)** untuk pemberitahuan penting.  
✅ **API untuk Aplikasi Mobile** - Menyediakan RESTful API untuk aplikasi **App Walisantri**.  
✅ **Manajemen Kamar & Komplek** - Sistem pengelompokan kamar berdasarkan komplek pondok.  
✅ **Sistem Payout & Tagihan** - Pengelolaan pembayaran dan tagihan santri (belum terintegrasi dengan payment gateway).  
✅ **Dashboard Admin** - Tampilan statistik dan laporan untuk monitoring data santri dan wali santri.  

---

## 🚀 Teknologi yang Digunakan

🔹 **PHP 5.6 (CodeIgniter 3)** - Framework utama backend.  
🔹 **MySQL** - Database untuk menyimpan data santri dan wali santri.  
🔹 **Firebase Cloud Messaging (FCM)** - Untuk mengirimkan notifikasi ke aplikasi mobile.  
🔹 **Fingerspot Premiere Series** - Untuk integrasi data absensi santri.  
🔹 **RESTful API** - Backend menyediakan API untuk aplikasi mobile.  
🔹 **jQuery & Bootstrap** - Untuk tampilan dashboard admin.  

---

## 📦 Instalasi dan Konfigurasi

### 1️⃣ Clone Repository
```sh
git clone https://github.com/ahmadbusrooo/backend_walisantri.git
cd backend_walisantri
```

### 2️⃣ Konfigurasi Database
1. Buat database di MySQL.  
2. Import file **database.sql** jika tersedia.  
3. Edit konfigurasi database di **`application/config/database.php`**:
```php
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
    'dsn'   => '',
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',
    'database' => 'nama_database',
    'dbdriver' => 'mysqli',
    'dbprefix' => '',
    'pconnect' => FALSE,
    'db_debug' => (ENVIRONMENT !== 'production'),
    'cache_on' => FALSE,
    'cachedir' => '',
    'char_set' => 'utf8',
    'dbcollat' => 'utf8_general_ci',
    'swap_pre' => '',
    'encrypt' => FALSE,
    'compress' => FALSE,
    'stricton' => FALSE,
    'failover' => array(),
    'save_queries' => TRUE
);
```

### 3️⃣ Konfigurasi FCM (Notifikasi Firebase)
1. Masukkan **FCM Server Key** di **`application/config/fcm.php`**.
2. Pastikan endpoint FCM tersedia di API backend.

### 4️⃣ Jalankan di Localhost
Jika menggunakan **XAMPP**, letakkan project di folder:
```sh
C:\xampp\htdocs\backend_walisantri
```
Kemudian akses di browser:
```sh
http://localhost/backend_walisantri/
```

---

## 📷 Tampilan Backend
> Segera ditambahkan (screenshots dashboard admin, halaman login, dll.)

---

## 📡 API Endpoints
Backend ini menyediakan **RESTful API** untuk aplikasi **App Walisantri**.
Beberapa contoh endpoint:

| Endpoint | Method | Deskripsi |
|----------|--------|------------|
| `/api/login` | `POST` | Login pengguna |
| `/api/santri` | `GET` | Mendapatkan daftar santri |
| `/api/santri/{id}` | `GET` | Detail santri berdasarkan ID |
| `/api/absensi` | `POST` | Menyimpan data absensi santri |
| `/api/pelanggaran` | `GET` | Daftar pelanggaran santri |

Dokumentasi lengkap API akan segera ditambahkan.

---

## 🤝 Kontribusi
Kami menerima kontribusi dari siapa saja yang ingin membantu pengembangan backend ini. Silakan fork repository ini dan buat pull request!

1️⃣ **Fork Repository**  
2️⃣ **Buat Branch Baru** (`git checkout -b feature-nama-fitur`)  
3️⃣ **Commit Perubahan** (`git commit -m 'Menambahkan fitur baru'`)  
4️⃣ **Push ke GitHub** (`git push origin feature-nama-fitur`)  
5️⃣ **Buat Pull Request** dari GitHub

---

## 🛠️ Pengembang
👨‍💻 **Ahmad Busro Mustofa** – *Lead Developer*  
📧 **Email:** busromuz200206@gmail.com  
🔗 **GitHub:** [@ahmadbusrooo](https://github.com/ahmadbusrooo)

Jika ada pertanyaan atau masukan, jangan ragu untuk menghubungi saya! 😊

---

## 📜 Lisensi
Aplikasi ini menggunakan lisensi **MIT License**. Silakan gunakan dan kembangkan dengan bebas, tetapi tetap sertakan atribusi kepada pengembang asli.

```plaintext
MIT License
Copyright (c) 2025 Ahmad Busro
```

---

🚀 **Terima kasih telah menggunakan Backend Walisantri!** Semoga membantu dalam mengelola informasi santri dengan lebih efisien. 🙏

