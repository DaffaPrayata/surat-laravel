# 📨 SIPEKA

### Sistem Pengarsipan Elektronik Sekolah

**Modern Digital Correspondence Management for Educational Institutions**

<p align="center">
  <b>Developed by Daffa Prayata</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-9.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white">
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white">
  <img src="https://img.shields.io/badge/ApexCharts-Analytics-00E396?style=for-the-badge">
</p>

---

## 🚀 Overview

**SIPEKA (Sistem Pengarsipan Elektronik Sekolah)** adalah aplikasi manajemen surat berbasis web yang dirancang untuk membantu sekolah dan institusi pendidikan dalam mengelola:

- Surat Masuk
- Surat Keluar
- Disposisi Surat
- Arsip Dokumen Digital
- Manajemen Pengguna

Seluruh proses administrasi surat dapat dilakukan secara digital, terstruktur, dan mudah dipantau melalui dashboard interaktif.

---

## ✨ Features

### 📊 Dashboard Analytics

- Statistik surat real-time
- Visualisasi data interaktif
- Monitoring aktivitas sistem
- Ringkasan surat masuk dan keluar

### 📥 Mail Management

- Kelola surat masuk
- Kelola surat keluar
- Upload lampiran dokumen
- Arsip digital terpusat
- Pencarian surat cepat

### 🔗 Digital Disposition

- Disposisi surat secara digital
- Tracking status surat
- Catatan tindak lanjut
- Riwayat disposisi

### 👥 User Management

- Administrator
- Guru
- Siswa
- Aktivasi dan nonaktif akun
- Reset password otomatis
- Pengaturan hak akses

### 📄 Reporting

- Filter data berdasarkan periode
- Rekap surat
- Export laporan
- Siap cetak

### 📱 Responsive Design

- Desktop
- Tablet
- Mobile Phone

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|------------|
| Backend | Laravel 9 |
| Frontend | Blade Template |
| CSS Framework | Bootstrap 5 |
| Database | MySQL |
| Charts | ApexCharts |
| Environment | Linux |

---

## 🔑 Default Account

### Administrator

```text
Email    : admin@admin.com
Password : password
```

---

## ⚡ Installation

### 1. Clone Repository

```bash
git clone https://github.com/DaffaPrayata/surat-laravel.git
cd surat-laravel
```

### 2. Install Dependency

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Konfigurasi Database

Edit file `.env`

```env
DB_DATABASE=surat
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrasi dan Seeder

```bash
php artisan migrate --seed
```

### 7. Buat Symbolic Link Storage

```bash
php artisan storage:link
```

### 8. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan pada:

```text
http://127.0.0.1:8000
```

---

## 📂 Modules

- Dashboard
- Surat Masuk
- Surat Keluar
- Disposisi
- Manajemen Pengguna
- Klasifikasi Surat
- Arsip Dokumen
- Laporan

---

## 🔒 Security Features

- Authentication Login
- Role Based Access Control (RBAC)
- CSRF Protection
- Password Hashing
- Session Management

---

## 📄 License

Project ini dibuat untuk kebutuhan pembelajaran, pengembangan, dan implementasi sistem administrasi surat digital pada institusi pendidikan.

---

<p align="center">
  <b>Daffa Prayata</b><br>
  Web Developer • Laravel Enthusiast <br><br>
  
  <a href="https://github.com/DaffaPrayata">GitHub</a> • 
  <a href="#">Portfolio</a>
</p>
