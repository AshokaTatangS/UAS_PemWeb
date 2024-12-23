# UAS Pemrograman Web RB | Ashoka Tatang Solihin_122140051

## Poin penilaian
- Client-side Programming
- Server-side Programming
- Database Management
- State Management

## Bagian 1: Client-side Programming
Gambar di bawah ini adalah tampilan login dan register:

gambar register

<img src="https://github.com/user-attachments/assets/982fd92b-235e-4d89-ad2b-3eaff4bc157e" alt="Register Page" width="400">

gambar login

<img src="https://github.com/user-attachments/assets/7acba899-7156-4ac6-a168-7cbe91545431" alt="Register Page" width="300">

Gambar di bawah ini adalah tampilan ketika pengguna tidak mengisi kotaknya, maka script dari javascript akan dijalankan untuk memberitahukan pengguna untuk mengisikan kolomnya:

<img src="https://github.com/user-attachments/assets/bea0dc40-e4d1-4a73-9827-3a6641f8c0a8" alt="Login Page" width="300">


## Bagian 2: Server-side Programming
Gambar di bawah ini merupakan tampilan untuk tabel yang dapat digunakan untuk mengolah data:

<img src="https://github.com/user-attachments/assets/43bb13c3-3682-4990-87b3-6a9d47befa6f" alt="Pengolahan Data" width="600">

Gambar di bawah ini merupakan tampilan code yang sudah berorientasi objek:

<img src="https://github.com/user-attachments/assets/831119ca-4a35-458a-ae9f-2e4550ab8858" alt="OOP" width="300">



## Bagian 3: Database Management
Gambar di bawah ini merupakan database yang sudah dibuat:

<img src="https://github.com/user-attachments/assets/a311c3fd-7094-4480-9b37-0136d725d3b1" alt="Database" width="400">

Kemudian menghubungkan code php ke database:

<img src="https://github.com/user-attachments/assets/b10556de-0dba-4897-a5d7-dfb314899f09" alt="Koneksi Database" width="500">

Lalu data yang sudah ada dapat dimanipulasi kembali (melakukan update dan delete):

<img src="https://github.com/user-attachments/assets/43bb13c3-3682-4990-87b3-6a9d47befa6f" alt="Pengolahan Data" width="600">


## Bagian 4: State Management

Pengelolaan state dengan cookie:

di bawah ini adalah saat menyimpan cookie ketika pengguna login:

<img src="https://github.com/user-attachments/assets/48316932-3ef4-4f8c-90b5-7d8306303960" alt="cookie" width="600">

di bawah ini adalah saat menghapus cooke ketika pengguna logout:

<img src="https://github.com/user-attachments/assets/e34bed31-41ee-4878-8dfd-3791ef03c784" alt="cookie" width="600">

lalu terdapat pengolaan session:

<img src="https://github.com/user-attachments/assets/9e64ccfe-4702-42dd-bfb1-1a9de5aed254" alt="Session Management" width="300">

<img src="https://github.com/user-attachments/assets/fe57d9f7-5eb2-4d01-bee3-cf69e2c897d3" alt="Session Management" width="300">



## Bonus: Hosting Aplikasi
### Apa langkah-langkah yang Anda lakukan untuk meng-host aplikasi web Anda?
1. Registrasi Akun

  Daftar akun di InfinityFree menggunakan email yang valid.


2. Pembuatan Domain

  Pilih domain gratis yang disediakan oleh InfinityFree (misalnya, example.epizy.com) atau gunakan domain Anda sendiri.


3. Upload File ke Server

  Akses File Manager atau gunakan FTP Client (seperti FileZilla) untuk mengunggah file aplikasi web ke direktori htdocs.

4. Konfigurasi Database

  Buat database MySQL melalui cPanel InfinityFree di bagian MySQL Databases.

  Perbarui file konfigurasi aplikasi (misalnya, connect.php) dengan kredensial database yang telah dibuat.

5. Tes Aplikasi

  Akses domain yang telah dibuat untuk memastikan aplikasi berjalan sesuai harapan.

### Penyedia hosting web yang paling cocok untuk aplikasi web Anda
Saya memilih InfinityFree sebagai penyedia hosting karena:

1. Gratis Selamanya

  Cocok untuk proyek kecil atau portofolio tanpa biaya tambahan.

2. Fitur Hosting Gratis

  Mendukung PHP, MySQL, dan memiliki penyimpanan yang cukup besar (hingga 5GB).

3. Tanpa Iklan

  Tidak ada iklan yang mengganggu di situs yang di-host.

4. Subdomain Gratis

  Tersedia subdomain gratis seperti .epizy.com atau .rf.gd.

Namun, jika aplikasi membutuhkan fitur lebih lengkap seperti sertifikat SSL premium, performa tinggi, atau dukungan pelanggan, hosting berbayar seperti Hostinger atau Bluehost bisa dipertimbangkan.

### Bagaimana Anda memastikan keamanan aplikasi web yang Anda host?
1. SSL/TLS

Aktifkan Free SSL Certificate yang disediakan oleh InfinityFree untuk mengenkripsi data antara server dan klien.

2. Validasi Input

Pastikan semua input dari pengguna divalidasi untuk mencegah serangan seperti SQL Injection dan XSS (Cross-Site Scripting).

3. Perbarui Skrip dan Library

Pastikan semua skrip dan library yang digunakan dalam aplikasi selalu diperbarui untuk menutup celah keamanan.

4. Gunakan Password Kuat

Terapkan password yang kuat untuk akun hosting, database, dan aplikasi.

###  Jelaskan konfigurasi server yang Anda terapkan untuk mendukung aplikasi web Anda.
1. PHP Version

Pastikan server mendukung versi PHP yang sesuai dengan aplikasi. InfinityFree mendukung hingga PHP 7.4.

2. Konfigurasi MySQL

Gunakan database MySQL yang dibuat di cPanel InfinityFree.
Periksa koneksi database dengan kredensial yang benar (hostname, username, password, dan nama database).

3. File Directory

Semua file aplikasi web harus ditempatkan di direktori htdocs.
