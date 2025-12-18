# Zettarig

Zettarig adalah aplikasi **manajemen penjualan dan inventori berbasis web** yang dibangun menggunakan **CodeIgniter 3**.  
Aplikasi ini ditujukan untuk **pengelolaan produk, supplier, penjualan, pembelian, pembayaran (transfer & COD), laporan, dan dashboard analitik** dalam satu sistem terintegrasi.

---

## ✨ Fitur Utama

### 🔐 Autentikasi & Keamanan
- Login admin dengan session
- Password menggunakan `password_hash`
- Proteksi halaman admin melalui `MY_Controller`

### 📦 Manajemen Data Master
- Produk (stok otomatis, harga modal & harga jual)
- Kategori produk
- Brand produk (dengan upload logo)
- Supplier
- Customer (aktif / nonaktif, izin COD)

### 🛒 Penjualan
- Penjualan produk
- Detail penjualan
- Status pesanan (baru, diproses, dikirim, selesai, dibatalkan)
- Stok berkurang otomatis saat penjualan

### 🏭 Pembelian Supplier
- Pembelian ke supplier
- Detail pembelian
- Stok bertambah otomatis dari pembelian
- Perhitungan total pembelian berdasarkan detail

### 💳 Pembayaran
- Transfer bank (upload bukti & verifikasi)
- COD + DP
  - Verifikasi DP
  - Pelunasan COD
  - Kontrol status pembayaran

### 📊 Dashboard & Laporan
- Dashboard statistik:
  - Total produk, customer, supplier
  - Produk stok menipis
- Grafik pendapatan vs pembelian (Chart.js)
- Laporan penjualan per user
- Laporan pembelian supplier
- Export laporan (PDF)

### 🎨 UI & UX
- AdminLTE 3
- Template terstruktur (header, navbar, sidebar, footer)
- Helper menu aktif & badge status
- Desain login modern (glassmorphism)

---

## 🧱 Tech Stack

- **Backend**: PHP 7.4+
- **Framework**: CodeIgniter 3
- **Database**: MySQL / MariaDB
- **Frontend**: AdminLTE 3, Bootstrap
- **Chart**: Chart.js
- **PDF**: Dompdf
- **Server lokal**: Laragon / XAMPP

---

## 📂 Struktur Folder & Arsitektur

Berikut adalah struktur direktori lengkap dari aplikasi Zettarig. Aplikasi ini mengikuti pola desain **MVC (Model-View-Controller)**.

<details>
<summary><b>Klik untuk melihat Struktur Folder Lengkap</b></summary>

```text
zettarig
├─ .editorconfig
├─ .htaccess
├─ application
│  ├─ config                # Konfigurasi (Database, Routes, Autoload)
│  ├─ controllers           # Logika Aplikasi (Admin Panel)
│  │  ├─ admin
│  │  │  ├─ Auth_admin.php
│  │  │  ├─ Brand_admin.php
│  │  │  ├─ Cod_admin.php
│  │  │  ├─ Customer_admin.php
│  │  │  ├─ Dashboard_admin.php
│  │  │  ├─ Kategori_admin.php
│  │  │  ├─ Laporan_admin.php
│  │  │  ├─ Pembayaran_admin.php
│  │  │  ├─ Pembelian_supplier_admin.php
│  │  │  ├─ Penjualan_admin.php
│  │  │  ├─ Produk_admin.php
│  │  │  └─ Supplier_admin.php
│  │  └─ Welcome.php
│  ├─ core                  # Core Extension (MY_Controller)
│  ├─ helpers               # Custom Helpers (Menu & Status)
│  ├─ models                # Database Logic
│  │  ├─ Brand_model.php
│  │  ├─ Cod_model.php
│  │  ├─ Customer_model.php
│  │  ├─ Dashboard_model.php
│  │  ├─ Detail_pembelian_supplier_model.php
│  │  ├─ Kategori_model.php
│  │  ├─ Laporan_model.php
│  │  ├─ Pembayaran_model.php
│  │  ├─ Pembelian_supplier_model.php
│  │  ├─ Penjualan_model.php
│  │  ├─ Produk_model.php
│  │  └─ Supplier_model.php
│  ├─ third_party           # Library Pihak Ketiga (DomPDF)
│  └─ views                 # Tampilan (HTML/PHP)
│     ├─ admin
│     │  ├─ auth            # Halaman Login
│     │  ├─ brand           # CRUD Brand
│     │  ├─ cod             # Manajemen COD
│     │  ├─ customer        # Data Pelanggan
│     │  ├─ dashboard       # Halaman Utama
│     │  ├─ kategori        # CRUD Kategori
│     │  ├─ laporan         # Laporan Penjualan
│     │  ├─ laporan_pembelian
│     │  ├─ layout          # Template (Header, Sidebar, Footer)
│     │  ├─ pembayaran      # Verifikasi Transfer
│     │  ├─ pembelian_supplier
│     │  ├─ penjualan       # Order Masuk
│     │  ├─ produk          # CRUD Produk
│     │  └─ supplier        # Data Supplier
│     └─ errors
├─ assets                   # Statis (CSS, JS, Images, AdminLTE)
├─ system                   # Core CodeIgniter Framework
│  ├─ core
│  ├─ database
│  ├─ helpers
│  └─ libraries
└─ index.php                # Entry Point

---

</details>
```
## 🧠 Arsitektur & Konsep Penting

### MY_Controller
- Proteksi halaman admin otomatis
- Global data (notifikasi dashboard)
- Semua controller admin mewarisi class ini

### Helper Kustom
- `active_menu()` → menu aktif sidebar
- `active_tree()` → submenu terbuka
- `badge_status_pesanan()` → badge status pesanan

### Manajemen Stok
- **Pembelian supplier → stok bertambah**
- **Penjualan → stok berkurang**
- Tidak ada input stok manual di transaksi

---

## 🗄️ Struktur Database (Inti)

Tabel utama:
- `admin`
- `produk`
- `kategori_produk`
- `brand`
- `supplier`
- `customer`
- `penjualan`
- `detail_penjualan`
- `pembelian_supplier`
- `detail_pembelian_supplier`
- `pembayaran_transfer`
- `pembayaran_cod`

Catatan:
- Harga produk menggunakan **`harga_jual`**
- Harga modal tersimpan di detail pembelian supplier
- Relasi menggunakan InnoDB & foreign key

---

## ⚙️ Instalasi Lokal

1. Clone repository
   ```bash
   git clone https://github.com/username/zettarig.git

## 🗄️ Skema Database (ERD)

Berikut adalah struktur relasi database aplikasi Zettarig:

```mermaid
erDiagram
    ADMIN {
        int id_admin PK
        string username
        string password_hash
        string nama_lengkap
        string email
        boolean status_aktif
        datetime last_login
        timestamp created_at
    }

    KATEGORI_PRODUK {
        int id_kategori PK
        string nama_kategori
        text deskripsi
        boolean status_aktif
        timestamp tanggal_dibuat
    }

    BRAND {
        int id_brand PK
        string nama_brand
        text deskripsi
        string logo
        boolean status_aktif
    }

    SUPPLIER {
        int id_supplier PK
        string nama_supplier
        string kontak
        text alamat
        boolean status_aktif
    }

    PRODUK {
        int id_produk PK
        string nama_produk
        int id_kategori FK
        int id_brand FK
        int id_supplier FK
        int harga_modal
        int harga_jual
        int stok
        boolean status_aktif
        string gambar_produk
    }

    CUSTOMER {
        int id_customer PK
        string nama
        string username
        string email
        string password_hash
        string no_hp
        text alamat
        boolean status_aktif
        boolean is_cod_allowed
        timestamp tanggal_bergabung
    }

    PENJUALAN {
        int id_penjualan PK
        int id_customer FK
        int total_harga
        enum status_pesanan
        timestamp tanggal_pesanan
    }

    DETAIL_PENJUALAN {
        int id_detail PK
        int id_penjualan FK
        int id_produk FK
        int jumlah
        int harga_satuan
        int subtotal
    }

    PEMBELIAN_SUPPLIER {
        int id_pembelian PK
        int id_supplier FK
        int total_harga
        timestamp tanggal_pembelian
    }

    DETAIL_PEMBELIAN_SUPPLIER {
        int id_detail PK
        int id_pembelian FK
        int id_produk FK
        int jumlah_beli
        int harga_modal_satuan
        int subtotal
    }

    PEMBAYARAN_TRANSFER {
        int id_pembayaran PK
        int id_penjualan FK
        int jumlah_dibayar
        string bukti_transfer
        enum status_verifikasi
        timestamp tanggal_upload
        timestamp tanggal_verifikasi
    }

    PEMBAYARAN_COD {
        int id_cod PK
        int id_penjualan FK
        int dp_wajib
        int dp_dibayar
        int sisa_pembayaran
        string bukti_dp
        enum status_dp
        enum status_pelunasan
    }

    %% RELATIONSHIPS
    KATEGORI_PRODUK ||--o{ PRODUK : memiliki
    BRAND ||--o{ PRODUK : memiliki
    SUPPLIER ||--o{ PRODUK : memasok

    SUPPLIER ||--o{ PEMBELIAN_SUPPLIER : melakukan
    PEMBELIAN_SUPPLIER ||--o{ DETAIL_PEMBELIAN_SUPPLIER : terdiri_dari
    PRODUK ||--o{ DETAIL_PEMBELIAN_SUPPLIER : dibeli

    CUSTOMER ||--o{ PENJUALAN : melakukan
    PENJUALAN ||--o{ DETAIL_PENJUALAN : terdiri_dari
    PRODUK ||--o{ DETAIL_PENJUALAN : dijual

    PENJUALAN ||--|| PEMBAYARAN_TRANSFER : dibayar_transfer
    PENJUALAN ||--|| PEMBAYARAN_COD : dibayar_cod