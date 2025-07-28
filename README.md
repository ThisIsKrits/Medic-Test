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

---

🔐 Akun Login (Seeder Default)

| Role     | Email                                               | Password |
| -------- | --------------------------------------------------- | -------- |
| Dokter   | [dokter@example.com](mailto:dokter@example.com)     | password |
| Apoteker | [apoteker@example.com](mailto:apoteker@example.com) | password |
| superadmin | [superadmin@example.com](mailto:superadmin@example.com) | password |
| admin | [admin@example.com](mailto:admin@example.com) | password |

---

🗄️ Struktur Database Utama
users – data user (dokter dan apoteker), menggunakan Spatie Roles

patients – data pasien

medicine – data obat diambil dari api

checkups – data pemeriksaan + tanda vital

prescriptions – data resep obat, PDF resi

prescription_items – item dalam resep (obat, jumlah, harga)

log – data log aktivitas

---

🧾 Validasi & Hak Akses
Dokter hanya dapat mengubah resep sebelum dilayani

Apoteker hanya bisa melihat dan memproses resep yang belum selesai

Validasi backend menggunakan Laravel Form Request

Navigasi dinamis berdasarkan role use

---

🧑‍💻 Developer
Proyek ini dibuat untuk keperluan tes teknikal.
© 2025 – Developed by ThisIsKrits
