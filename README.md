# 📨 E-Surat - Enterprise Letter Management System

<p align="center">
  <a href="[https://github.com/daffaprayata](https://github.com/daffaprayata)" target="_blank">
  </a>
  <br>
  <b>Developed by Daffa Prayata</b>
</p>

<p align="center">
  <img src="[https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)" alt="Laravel">
  <img src="[https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)" alt="MySQL">
  <img src="[https://img.shields.io/badge/Linux_Mint-273c75?style=for-the-badge&logo=linux-mint&logoColor=white](https://img.shields.io/badge/Linux_Mint-273c75?style=for-the-badge&logo=linux-mint&logoColor=white)" alt="Linux Mint">
</p>

---

## 🚀 Overview
**E-Surat v1** adalah platform manajemen korespondensi digital yang dirancang untuk mengotomatisasi alur surat masuk, surat keluar, dan disposisi. Project ini berfokus pada efisiensi pengarsipan dokumen dan visualisasi data statistik untuk membantu pengambilan keputusan administratif di instansi pendidikan.

## ✨ Fitur Utama (Deep Dive)

*   **📊 Dynamic Analytics Dashboard**: Menampilkan widget statistik harian dan grafik tren surat mingguan menggunakan **ApexCharts** untuk monitoring data yang intuitif.
*   **📥 Centralized Mail Management**: Sistem CRUD (Create, Read, Update, Delete) yang solid untuk manajemen surat masuk dan keluar, lengkap dengan sistem penomoran agenda otomatis.
*   **🔗 Automated Disposition Flow**: Memungkinkan admin meneruskan surat ke staf terkait dengan catatan disposisi yang terintegrasi secara sistematis.
*   **🔐 Granular Access Control**: Implementasi Multi-user Auth (Admin & Staff) untuk memastikan integritas dan keamanan data sensitif.
*   **📅 Advanced Reporting**: Fitur filter cerdas berdasarkan rentang tanggal untuk mencetak laporan agenda surat dalam format yang siap pakai.
*   **🖼️ Digital Archive Gallery**: Ruang penyimpanan digital untuk lampiran surat, memudahkan verifikasi dokumen fisik tanpa harus mencari di gudang arsip.

## 🛠️ Tech Stack & Architecture

*   **Core Framework**: Laravel 10.x (PHP 8.1+).
*   **Database**: MySQL dengan optimasi Indexing pada tabel transaksi surat.
*   **UI Engine**: Blade Templating Engine + Sneat Admin Dashboard.
*   **Frontend Library**: ApexCharts (Visualisasi Data), Bootstrap 5 (Layouting).
*   **OS Environment**: Developed & Tested on Linux Mint

## 📂 Struktur Project (Penting)

```text
├── app/
│   ├── Http/Controllers/    # Logika bisnis (Surat, Disposisi, Dashboard)
│   └── Models/               # Struktur Database (Eloquent ORM)
├── database/
│   ├── migrations/           # Skema Tabel Database
│   └── seeders/              # Data Dummy & Default User
├── public/
│   └── storage/              # Penyimpanan File Scan Surat
├── resources/
│   └── views/                # Antarmuka UI (Blade)
└── routes/
    └── web.php               # Mapping URL Aplikasi
```

## ⚡ Panduan Instalasi

### **Menggunakan Makefile (Rekomendasi Linux)**
Cukup jalankan satu perintah di terminal 
```bash
make setup && make setup-db && make run
```

### **Instalasi Manual**
1.  **Dependencies**: `composer install`
2.  **Environment**: `cp .env.example .env` & `php artisan key:generate`
3.  **Database**: Sesuaikan `.env` lalu jalankan `php artisan migrate --seed`
4.  **Filesystem**: `php artisan storage:link`
5.  **Serve**: `php artisan serve`

## 🔑 Default Credentials
| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@admin.com` | `admin` |

---
