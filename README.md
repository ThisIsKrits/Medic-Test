# 🩺 Medic-Test — Aplikasi Peresepan Obat Laravel

Aplikasi berbasis Laravel untuk peresepan dan penebusan obat oleh dokter dan apoteker. Dibuat sebagai mini project untuk tes teknikal dengan integrasi API eksternal.

---

## 🚀 Fitur Utama

### Role: Dokter
- Login
- Input data pemeriksaan pasien
- Input tanda vital: tinggi, berat, tekanan darah, suhu, detak jantung, napas, dll
- Upload berkas eksternal (opsional)
- Menuliskan resep obat (ambil dari API eksternal)
- Mengedit resep selama belum dilayani apoteker

### Role: Apoteker
- Login
- Melihat resep yang belum dilayani
- Memproses pembayaran resep
- Menghitung total dan mencetak resi PDF
- Menandai resep sudah selesai

---

## 🛠️ Cara Install & Jalankan Lokal

```bash
git clone https://github.com/ThisIsKrits/Medic-Test.git
cd Medic-Test

composer install
cp .env.example .env
php artisan key:generate

# Sesuaikan DB di .env
php artisan migrate --seed

php artisan serve
