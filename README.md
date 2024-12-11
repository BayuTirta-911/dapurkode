# Nama Proyek: DapurKode, Platform Manajemen Layanan Berbasis Laravel

## Deskripsi
Proyek ini adalah platform manajemen layanan berbasis Laravel yang dirancang untuk memfasilitasi interaksi antara vendor, pengguna, installer, dan affiliator. Platform ini menyediakan fitur seperti pembuatan layanan, faktur, manajemen afiliasi, permintaan proyek, dan pelacakan saldo, menawarkan solusi menyeluruh untuk mengelola alur kerja terkait layanan.

---

## Fitur

### **Peran Pengguna**
- **Admin**: Mengelola pengguna, layanan, faktur, dan permintaan afiliasi.
- **Vendor**: Membuat, mengelola, dan melacak layanan.
- **Installer**: Mengajukan dan mengelola permintaan proyek.
- **Affiliator**: Mempromosikan layanan dan melacak penghasilan afiliasi.

### **Fungsi Utama**
- **Manajemen Layanan**:
  - Membuat dan mengelola layanan.
  - Mengelompokkan layanan berdasarkan kategori.
  - Menambahkan biaya tambahan untuk setiap layanan (biaya installer, biaya affiliator, dll).

- **Manajemen Faktur**:
  - Membuat faktur untuk layanan.
  - Menggunakan kode diskon dan melacak komisi afiliasi.

- **Manajemen Afiliasi**:
  - Melacak pembelian melalui tautan afiliasi.
  - Memperbarui saldo afiliasi dan memantau komisi.

- **Manajemen Installer**:
  - Mengajukan permintaan proyek untuk layanan.
  - Memperbarui kemajuan proyek dan melacak status.

- **Alat Admin**:
  - Menyetujui/menolak permintaan proyek.
  - Memperbarui biaya dan status layanan.
  - Mengelola akun pengguna dan permintaan afiliasi.

### **Fitur Tambahan**
- Pagination dan pencarian untuk tabel data.
- Login dan registrasi aman dengan fitur pengalihan halaman.
- Upload file dengan validasi (misalnya, pembatasan ukuran gambar).
- Antarmuka yang ramah pengguna dan modern.

---

## Panduan Instalasi

### **Persyaratan**
- PHP >= 8.0
- Composer
- Laravel Framework >= 10
- MySQL atau database kompatibel
- Node.js dan npm (untuk kompilasi aset)

### **Langkah-Langkah**

1. **Clone Repository**
   ```bash
   git clone https://github.com/BayuTirta-911/dapurkode.git
   cd dapurkode
   ```

2. **Install Dependensi**
   ```bash
   composer install
   npm install
   npm run build
   ```

3. **Atur Environment**
   - Salin file `.env.example` menjadi `.env`:
     ```bash
     cp .env.example .env
     ```
   - Perbarui kredensial database dan konfigurasi lainnya di file `.env`.

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Jalankan Migrasi dan Seeder**
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server Pengembangan**
   ```bash
   php artisan serve
   ```

7. **Akses Aplikasi**
   Buka browser dan navigasikan ke:
   ```
   http://127.0.0.1:8000
   ```

### **Langkah Opsional**
- **Buat Storage Link**:
  ```bash
  php artisan storage:link
  ```
- **Bersihkan Cache**:
  ```bash
  php artisan config:clear
  php artisan cache:clear
  ```

---