# 📨 E-Surat - Enterprise Letter Management System

### *Modern Digital Correspondence Management for Schools & Institutions*

<p align="center">
  <b>Developed by Daffa Prayata</b>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white"/>
  <img src="https://img.shields.io/badge/ApexCharts-Visualization-00E396?style=for-the-badge"/>
</p>

---

## 🚀 Overview

**E-Surat v1** adalah platform manajemen korespondensi digital yang membantu instansi dalam mengelola surat masuk, surat keluar, dan disposisi secara terstruktur, cepat, dan efisien.

---

## 🖼️ Preview Aplikasi

### 💻 Dashboard (Desktop)

<p align="center">
  <img src="https://github.com/user-attachments/assets/dc331e39-6459-4b75-9803-5d3208cecfd5" width="85%"/>
</p>

<p align="center"><i>Dashboard utama dengan statistik & visualisasi data surat</i></p>

---

### 📱 Tampilan Mobile (Responsive)

<p align="center">
  <img src="https://github.com/user-attachments/assets/43c08837-ad66-451d-be3f-d1f326e67188" width="30%"/>
  <img src="https://github.com/user-attachments/assets/65549459-ae18-4ae6-8c4a-094aa302464d" width="30%"/>
  <img src="https://github.com/user-attachments/assets/364c0599-5661-432b-b328-8df9f046459e" width="30%"/>
</p>

<p align="center">
  <img src="https://github.com/user-attachments/assets/edbb228f-b0ee-42f0-9313-32640054de69" width="30%"/>
  <img src="https://github.com/user-attachments/assets/01fc27bc-4777-49f4-8d4a-8d744d0a5653" width="30%"/>
  <img src="https://github.com/user-attachments/assets/b6b407f8-5276-451b-97ce-183ac3aff3d4" width="30%"/>
</p>

<p align="center"><i>Fully responsive UI di berbagai ukuran layar</i></p>

---

### 🧾 Halaman & Fitur Sistem

<p align="center">
  <img src="https://github.com/user-attachments/assets/c716c8e5-0b02-4859-a653-2725b92b6160" width="45%"/>
  <img src="https://github.com/user-attachments/assets/def0fbad-2511-4a6e-9f96-4fd9f33f592b" width="45%"/>
</p>

<p align="center"><i>Manajemen surat masuk & keluar</i></p>

---

## ✨ Fitur Utama

### 📊 Dashboard Analytics
- Statistik surat real-time  
- Visualisasi interaktif (ApexCharts)  
- Insight data untuk monitoring  

### 📥 Mail Management
- CRUD surat masuk & keluar  
- Penomoran agenda otomatis  
- Upload & arsip dokumen  

### 🔗 Disposisi Digital
- Distribusi surat ke staff  
- Catatan disposisi terintegrasi  
- Tracking alur surat  

### 🔐 Authentication System
- Multi-role: Admin & Staff Dan Siswa  
- Proteksi akses data  
- Session management  

### 📅 Reporting System
- Filter berdasarkan tanggal  
- Rekap & export data  
- Laporan siap cetak  

---

## 🛠️ Tech Stack

- **Backend**: Laravel 10.x  
- **Database**: MySQL  
- **Frontend**: Blade + Bootstrap 5  
- **Charts**: ApexCharts  
- **Environment**: Linux  

---

## ⚡ Instalasi

```bash
# 1. Clone repository
git clone https://github.com/daffaprayata/surat-laravel.git
cd surat-laravel

# 2. Install dependencies
composer install

# 3. Setup environment
cp .env.example .env
php artisan key:generate

# 4. Setup database (edit .env terlebih dahulu)
php artisan migrate --seed

# 5. Link storage untuk upload file
php artisan storage:link

# 6. Jalankan server
php artisan serve
