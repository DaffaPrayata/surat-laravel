# 📨 E-Surat - Enterprise Letter Management System

<p align="center">
  <a href="[https://github.com/daffaprayata](https://github.com/daffaprayata)" target="_blank">
    <img src="[https://avatars.githubusercontent.com/u/87377917?s=200&v=4](https://avatars.githubusercontent.com/u/87377917?s=200&v=4)" width="120" style="border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" alt="Daffa Logo">
  </a>
  <br>
  <b>Developed by Muhammad Daffa Prayata</b>[cite: 1]
</p>

<p align="center">
  <img src="[https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)" alt="Laravel">
  <img src="[https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)" alt="MySQL">
  <img src="[https://img.shields.io/badge/Linux_Mint-273c75?style=for-the-badge&logo=linux-mint&logoColor=white](https://img.shields.io/badge/Linux_Mint-273c75?style=for-the-badge&logo=linux-mint&logoColor=white)" alt="Linux Mint">[cite: 1]
</p>

---

## 🚀 Overview
**E-Surat v1** adalah platform manajemen korespondensi digital yang dirancang untuk mengotomatisasi alur surat masuk, surat keluar, dan disposisi[cite: 1]. Project ini berfokus pada efisiensi pengarsipan dokumen dan visualisasi data statistik untuk membantu pengambilan keputusan administratif di instansi pendidikan[cite: 1].

## ✨ Fitur Utama (Deep Dive)

*   **📊 Dynamic Analytics Dashboard**: Menampilkan widget statistik harian dan grafik tren surat mingguan menggunakan **ApexCharts** untuk monitoring data yang intuitif[cite: 1].
*   **📥 Centralized Mail Management**: Sistem CRUD (Create, Read, Update, Delete) yang solid untuk manajemen surat masuk dan keluar, lengkap dengan sistem penomoran agenda otomatis[cite: 1].
*   **🔗 Automated Disposition Flow**: Memungkinkan admin meneruskan surat ke staf terkait dengan catatan disposisi yang terintegrasi secara sistematis[cite: 1].
*   **🔐 Granular Access Control**: Implementasi Multi-user Auth (Admin & Staff) untuk memastikan integritas dan keamanan data sensitif[cite: 1].
*   **📅 Advanced Reporting**: Fitur filter cerdas berdasarkan rentang tanggal untuk mencetak laporan agenda surat dalam format yang siap pakai[cite: 1].
*   **🖼️ Digital Archive Gallery**: Ruang penyimpanan digital untuk lampiran surat, memudahkan verifikasi dokumen fisik tanpa harus mencari di gudang arsip[cite: 1].

## 🛠️ Tech Stack & Architecture

*   **Core Framework**: Laravel 10.x (PHP 8.1+)[cite: 1].
*   **Database**: MySQL dengan optimasi Indexing pada tabel transaksi surat[cite: 1].
*   **UI Engine**: Blade Templating Engine + Sneat Admin Dashboard[cite: 1].
*   **Frontend Library**: ApexCharts (Visualisasi Data), Bootstrap 5 (Layouting)[cite: 1].
*   **OS Environment**: Developed & Tested on Linux Mint[cite: 1].

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
Cukup jalankan satu perintah di terminal Linux Mint lu[cite: 1]:
```bash
make setup && make setup-db && make run
```

### **Instalasi Manual**
1.  **Dependencies**: `composer install`[cite: 1]
2.  **Environment**: `cp .env.example .env` & `php artisan key:generate`[cite: 1]
3.  **Database**: Sesuaikan `.env` lalu jalankan `php artisan migrate --seed`[cite: 1]
4.  **Filesystem**: `php artisan storage:link`[cite: 1]
5.  **Serve**: `php artisan serve`[cite: 1]

## 🔑 Default Credentials
| Role | Email | Password |
| :--- | :--- | :--- |
| **Administrator** | `admin@admin.com` | `admin` |[cite: 1]

---

# surat-laravel
