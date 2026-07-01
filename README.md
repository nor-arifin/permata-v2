# PERMATA-V2

**Permata** (Pencatatan Electronic Rekam Medis & Tindakan Analis) adalah sistem manajemen laboratorium klinik berbasis web. Dibangun dengan Laravel 10 dan PHP 8.1.

## Fitur

- **Manajemen Pasien** — Registrasi, kunjungan, anamnesis, tracking layanan
- **Laboratorium** — Pemesanan tes, sampling, penerimaan, pengujian, validasi hasil, LOINC coding
- **Dokter** — Manajemen data dokter dan jadwal
- **Pembayaran** — Tracking pendapatan dan invoice
- **Laporan** — Generate PDF (DomPDF/FPDF), export/import Excel, QR code
- **Integrasi SatuSehat** — Pertukaran data FHIR dengan platform Kemenkes RI
- **API** — REST API dengan Laravel Sanctum untuk akses pasien dan data dokter

## Teknologi

- **Backend:** Laravel 10, PHP 8.1
- **Frontend:** Bootstrap (Stisla Template), Chart.js
- **Database:** MySQL 8.0
- **Cache/Session:** Redis
- **Queue:** Sync (default)

## Struktur Direktori

```
├── docker/                  # Docker setup (nginx, php, mysql, phpmyadmin, redis)
│   ├── Dockerfile
│   ├── nginx/default.conf
│   └── php/php.ini
├── docker-compose.yml       # Orkestrasi container
├── labklin/                 # Document root aplikasi
│   ├── index.php            # Entry point
│   ├── laravel/             # Framework Laravel
│   └── css, js, img/        # Assets
└── glkueonq_labklinapp.sql  # Database dump
```

## Instalasi (Docker Local)

```bash
# Clone repo
git clone https://github.com/nor-arifin/permata-v2.git
cd permata-v2

# Jalankan container
docker compose up -d

# Akses aplikasi
# App    → http://localhost:8980
# phpMyAdmin → http://localhost:8981
# MySQL  → localhost:8933
# Redis  → localhost:8963
```

## Environment

Copy `.env.example` ke `.env` dan sesuaikan konfigurasi database:

```bash
cp labklin/laravel/.env.example labklin/laravel/.env
```

## Lisensi

Hak cipta milik pengembang. Digunakan untuk keperluan internal faskes.
