# CONTEXT: SISTEM WEBSITE UMKM V2.0

## 1. RINGKASAN ARSITEKTUR & ATURAN UTAMA (CRITICAL RULES)
Sistem ini berfokus pada efisiensi operasional dengan mengalihkan transaksi ke WhatsApp. Harap patuhi aturan mutlak berikut dalam setiap pembuatan kode:
* **TIDAK ADA DASHBOARD KELOLA PESANAN:** Menu Kelola Pesanan resmi DIHAPUS dari Dashboard Admin maupun Dashboard UMKM[cite: 1]. Jangan buat tabel, *controller*, atau UI untuk *tracking* resi atau status pengiriman di dalam sistem.
* **Transaksi Beralih ke WhatsApp:** Alur transaksi beralih sepenuhnya via WhatsApp untuk efisiensi operasional[cite: 1]. 
* **Database Pesanan Hanya untuk Laporan:** Data pesanan direkam ke database saat *checkout* murni HANYA untuk keperluan fitur Laporan & Statistik (produk terlaris, performa toko)[cite: 1].
* **Registrasi Customer di Awal:** Customer wajib mengisi data profil lengkap (Nama, No. WhatsApp, Alamat Lengkap, Email, Password) pada saat pendaftaran akun awal[cite: 1].
* **Sistem Checkout Autofill:** Formulir pemesanan harus menarik data customer secara otomatis dari profil, namun customer tetap bisa mengeditnya secara temporer[cite: 1].

## 2. SPESIFIKASI AKTOR & HAK AKSES

### A. SISI ADMIN
Admin berfokus pada moderasi platform dan statistik makro, tanpa mengintervensi detail teknis pemesanan produk[cite: 1].
* **Dashboard:** Menampilkan metrik *real-time* (Total UMKM, Customer, Produk, Pesanan)[cite: 1].
* **Kelola UMKM:** Hak penuh melihat data, mengubah profil, serta memverifikasi berkas pendaftaran (menyetujui/menolak/menonaktifkan akun)[cite: 1]. UMKM yang ditolak akan mendapat notifikasi perbaikan data[cite: 1].
* **Kelola Kategori:** Tambah, Edit, Hapus kategori produk global[cite: 1].
* **Laporan (Statistik):** Analitik performa website (Produk Terlaris, UMKM Teraktif, Tren Pesanan)[cite: 1].

### B. SISI MITRA UMKM
Sisi UMKM dirancang ringkas untuk manajemen toko dan promosi produk[cite: 1].
* **Dashboard Toko:** Ringkasan total produk, pesanan dari web, estimasi terjual, dan rating[cite: 1].
* **Kelola Profil Toko:** Pembaruan nama, alamat pengiriman, WhatsApp, deskripsi, logo[cite: 1].
* **Kelola Produk (CRUD):** Nama Produk, Harga, Kategori, Deskripsi Detail, dan Foto[cite: 1].
* **Ulasan & Rating:** Ruang untuk memantau rating bintang dan testimoni pasca-pembelian[cite: 1].
* **Laporan Performa:** Analitik internal toko (Total pesanan, produk terlaris)[cite: 1].

### C. SISI CUSTOMER
* **Eksplorasi:** Bebas menjelajahi direktori UMKM, melihat katalog, menyortir kategori, mencari produk, dan melihat rating[cite: 1].
* **Alur Checkout Spesifik:**
    1. Customer mengatur kuantitas menggunakan tombol Plus (+) / Minus (-) di detail produk[cite: 1].
    2. Customer menekan "Pesan Sekarang"[cite: 1].
    3. Masuk ke form pemesanan dengan data yang sudah terisi otomatis (Autofill) dari profil (Nama, WA, Alamat, Jumlah)[cite: 1].
    4. Customer dapat mengisi "Catatan Tambahan" secara manual (opsional)[cite: 1].
    5. Klik "Kirim Pesanan" akan mengeksekusi dua aksi simultan: Menyimpan data ke Database DAN me-redirect API ke nomor WhatsApp UMKM tujuan[cite: 1].
    6. Muncul notifikasi "Pesanan Berhasil Dikirim ke WhatsApp Toko!"[cite: 1].
    7. Transaksi diselesaikan di WhatsApp. Customer nantinya dapat kembali ke web untuk memberi ulasan & rating[cite: 1].

---

## 3. PEMBAGIAN FASE PENGEMBANGAN (ROADMAP)
Pekerjaan *coding* dan desain mengikuti kerangka fase berikut untuk menjaga keteraturan *dependency* sistem:

### Fase 1: Penyelarasan & Analisis Kebutuhan
* Melakukan analisis kebutuhan, perancangan logika sistem, dan penyusunan dokumen pemodelan dasar seperti *Use Case Diagram* dan *Activity Diagram*[cite: 2].
* Menetapkan dan menyepakati alur sistem baru yang mencakup registrasi lengkap *customer*, tombol kuantitas (+/-), form autofill, dan penghapusan menu kelola order yang digantikan oleh *redirect* WhatsApp[cite: 2].

### Fase 2: Desain UI/UX, Perancangan Database & Setup Proyek
* Mendesain antarmuka (UI/UX) di Figma untuk halaman Customer (termasuk form checkout autofill), Dashboard Admin, dan Dashboard UMKM[cite: 2].
* Merancang skema sistem database secara final, membuat Entity Relationship Diagram (ERD), dan menyusun struktur tabel, termasuk tabel untuk data profil *customer*[cite: 2].
* Melakukan inisialisasi *project* baru menggunakan *framework* Laravel, setup *database* MySQL, dan setup *repository* di GitHub[cite: 2].
* Membuat *file Migration*, *Model* backend, dan mendeklarasikan relasi antar-tabel berdasarkan rancangan ERD final[cite: 2].

### Fase 3: Backend I (Slicing UI & Fitur Admin/UMKM)
* Mengimplementasikan fungsi Autentikasi/Login untuk Admin[cite: 2].
* Melakukan *slicing* UI dan integrasi Dashboard Admin, serta membuat fitur Kelola UMKM (verifikasi berkas, ubah profil, blokir akun), Kelola Kategori Produk, dan Laporan Analitik platform[cite: 2].
* Membuat sistem Registrasi dan Login untuk mitra UMKM[cite: 2].
* Melakukan *slicing* UI Dashboard UMKM, membuat fitur Kelola Profil Toko, dan mengkoding fitur Kelola Produk (CRUD lengkap dengan *upload* foto dan kategori)[cite: 2].

### Fase 4: Backend II (Fitur Customer & Integrasi WhatsApp)
* Membuat *form* Registrasi Customer (mewajibkan isi Nama, No. WA, Alamat di awal) beserta fungsi Login[cite: 2].
* Melakukan *slicing* halaman Beranda, Daftar Mitra UMKM, Informasi Toko, Detail Produk, serta mengimplementasikan interaksi JavaScript untuk tombol kuantitas (+/-)[cite: 2].
* Mengkoding logika *Autofill* pada Form Konfirmasi Pemesanan yang menarik data profil *customer* secara otomatis (kolom tetap bisa diedit) dan menyediakan kolom catatan tambahan[cite: 2].
* Mengkoding aksi ganda (simultan) pada tombol "Kirim Pesanan": menyimpan data pesanan ke database lokal MySQL, lalu secara otomatis melempar *link API redirect* berisi format teks pesanan ke WhatsApp UMKM tujuan[cite: 2].

### Fase 5: Rilis (Testing, Bug Fixing & Deployment)
* Mengimplementasikan dan mengintegrasikan komponen sistem Rating dan Ulasan pasca-transaksi[cite: 2].
* Melakukan pengujian sistem ujung-ke-ujung (*End-to-End Testing*) untuk *role* Admin, UMKM, dan Customer guna memastikan alur kerja stabil[cite: 2].
* Melacak dan memperbaiki eror program secara intensif (*Bug Fixing*)[cite: 2].
* Menyelesaikan proses *deployment* ke *server* publik (Go-Live) dan menyusun dokumentasi teknis sistem[cite: 2].