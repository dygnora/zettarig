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

```
zettarig
├─ .editorconfig
├─ .htaccess
├─ application
│  ├─ config
│  │  ├─ autoload.php
│  │  ├─ constants.php
│  │  ├─ doctypes.php
│  │  ├─ foreign_chars.php
│  │  ├─ hooks.php
│  │  ├─ index.html
│  │  ├─ memcached.php
│  │  ├─ migration.php
│  │  ├─ mimes.php
│  │  ├─ profiler.php
│  │  ├─ smileys.php
│  │  └─ user_agents.php
│  ├─ controllers
│  │  ├─ admin
│  │  │  ├─ Auth_admin.php
│  │  │  ├─ Brand_admin.php
│  │  │  ├─ Cod_admin.php
│  │  │  ├─ Customer_admin.php
│  │  │  ├─ Dashboard_admin.php
│  │  │  ├─ Kategori_admin.php
│  │  │  ├─ Laporan_admin.php
│  │  │  ├─ Laporan_pembelian_admin.php
│  │  │  ├─ Pembayaran_admin.php
│  │  │  ├─ Pembelian_supplier_admin.php
│  │  │  ├─ Penjualan_admin.php
│  │  │  ├─ Produk_admin.php
│  │  │  ├─ Search_admin.php
│  │  │  └─ Supplier_admin.php
│  │  ├─ index.html
│  │  ├─ web
│  │  │  ├─ About.php
│  │  │  ├─ Akun.php
│  │  │  ├─ Auth.php
│  │  │  ├─ Cart.php
│  │  │  ├─ Checkout.php
│  │  │  ├─ Home.php
│  │  │  ├─ Pembayaran.php
│  │  │  └─ Produk.php
│  │  └─ Welcome.php
│  ├─ core
│  │  ├─ index.html
│  │  └─ MY_Controller.php
│  ├─ helpers
│  │  ├─ index.html
│  │  ├─ menu_helper.php
│  │  └─ status_helper.php
│  ├─ hooks
│  │  └─ index.html
│  ├─ index.html
│  ├─ language
│  │  ├─ english
│  │  │  └─ index.html
│  │  └─ index.html
│  ├─ libraries
│  │  └─ index.html
│  ├─ models
│  │  ├─ Brand_model.php
│  │  ├─ Cod_model.php
│  │  ├─ Customer_model.php
│  │  ├─ Dashboard_model.php
│  │  ├─ Detail_pembelian_supplier_model.php
│  │  ├─ index.html
│  │  ├─ Kategori_model.php
│  │  ├─ Laporan_model.php
│  │  ├─ Laporan_pembelian_model.php
│  │  ├─ Pembayaran_model.php
│  │  ├─ Pembelian_supplier_model.php
│  │  ├─ Penjualan_model.php
│  │  ├─ Produk_model.php
│  │  ├─ Search_model.php
│  │  └─ Supplier_model.php
│  ├─ third_party
│  │  ├─ dompdf
│  └─ views
│     ├─ admin
│     │  ├─ auth
│     │  │  └─ login.php
│     │  ├─ brand
│     │  │  ├─ create.php
│     │  │  ├─ edit.php
│     │  │  └─ index.php
│     │  ├─ cod
│     │  │  ├─ detail.php
│     │  │  └─ index.php
│     │  ├─ customer
│     │  │  ├─ create.php
│     │  │  ├─ edit.php
│     │  │  └─ index.php
│     │  ├─ dashboard
│     │  │  └─ index.php
│     │  ├─ kategori
│     │  │  ├─ create.php
│     │  │  ├─ edit.php
│     │  │  └─ index.php
│     │  ├─ laporan
│     │  │  ├─ detail_user.php
│     │  │  ├─ export_pdf.php
│     │  │  ├─ export_pdf_user.php
│     │  │  └─ index.php
│     │  ├─ laporan_pembelian
│     │  │  ├─ detail.php
│     │  │  ├─ export_pdf.php
│     │  │  ├─ export_pdf_supplier.php
│     │  │  └─ index.php
│     │  ├─ layout
│     │  │  ├─ footer.php
│     │  │  ├─ header.php
│     │  │  ├─ navbar.php
│     │  │  ├─ sidebar.php
│     │  │  └─ template.php
│     │  ├─ pembayaran
│     │  │  ├─ detail.php
│     │  │  └─ index.php
│     │  ├─ pembelian_supplier
│     │  │  ├─ create.php
│     │  │  ├─ detail.php
│     │  │  └─ index.php
│     │  ├─ penjualan
│     │  │  ├─ detail.php
│     │  │  └─ index.php
│     │  ├─ produk
│     │  │  ├─ create.php
│     │  │  ├─ edit.php
│     │  │  └─ index.php
│     │  ├─ search
│     │  │  └─ index.php
│     │  └─ supplier
│     │     ├─ create.php
│     │     ├─ edit.php
│     │     └─ index.php
│     ├─ errors
│     │  ├─ cli
│     │  │  ├─ error_404.php
│     │  │  ├─ error_db.php
│     │  │  ├─ error_exception.php
│     │  │  ├─ error_general.php
│     │  │  ├─ error_php.php
│     │  │  └─ index.html
│     │  ├─ html
│     │  │  ├─ error_404.php
│     │  │  ├─ error_db.php
│     │  │  ├─ error_exception.php
│     │  │  ├─ error_general.php
│     │  │  ├─ error_php.php
│     │  │  └─ index.html
│     │  └─ index.html
│     ├─ index.html
│     ├─ web
│     │  ├─ about
│     │  │  └─ index.php
│     │  ├─ akun
│     │  │  ├─ index.php
│     │  │  ├─ pesanan.php
│     │  │  └─ pesanan_detail.php
│     │  ├─ auth
│     │  │  ├─ login.php
│     │  │  └─ register.php
│     │  ├─ cart
│     │  │  └─ index.php
│     │  ├─ checkout
│     │  │  └─ index.php
│     │  ├─ home
│     │  │  └─ index.php
│     │  ├─ layout
│     │  │  ├─ footer.php
│     │  │  ├─ header.php
│     │  │  ├─ navbar.php
│     │  │  └─ template.php
│     │  ├─ pembayaran
│     │  │  └─ upload.php
│     │  └─ produk
│     │     ├─ detail.php
│     │     └─ index.php
│     └─ welcome_message.php
├─ assets
│  ├─ adminlte
│  ├─ css
│  │  └─ web
│  │     ├─ pages
│  │     │  └─ home.css
│  │     └─ theme.css
│  └─ images
│     └─ logo.png
├─ composer.json
├─ index.php
├─ license.txt
├─ README.md
├─ readme.rst
└─ system
   ├─ .htaccess
   ├─ core
   │  ├─ Benchmark.php
   │  ├─ CodeIgniter.php
   │  ├─ Common.php
   │  ├─ compat
   │  │  ├─ hash.php
   │  │  ├─ index.html
   │  │  ├─ mbstring.php
   │  │  ├─ password.php
   │  │  └─ standard.php
   │  ├─ Config.php
   │  ├─ Controller.php
   │  ├─ Exceptions.php
   │  ├─ Hooks.php
   │  ├─ index.html
   │  ├─ Input.php
   │  ├─ Lang.php
   │  ├─ Loader.php
   │  ├─ Log.php
   │  ├─ Model.php
   │  ├─ Output.php
   │  ├─ Router.php
   │  ├─ Security.php
   │  ├─ URI.php
   │  └─ Utf8.php
   ├─ database
   │  ├─ DB.php
   │  ├─ DB_cache.php
   │  ├─ DB_driver.php
   │  ├─ DB_forge.php
   │  ├─ DB_query_builder.php
   │  ├─ DB_result.php
   │  ├─ DB_utility.php
   │  ├─ drivers
   │  │  ├─ cubrid
   │  │  │  ├─ cubrid_driver.php
   │  │  │  ├─ cubrid_forge.php
   │  │  │  ├─ cubrid_result.php
   │  │  │  ├─ cubrid_utility.php
   │  │  │  └─ index.html
   │  │  ├─ ibase
   │  │  │  ├─ ibase_driver.php
   │  │  │  ├─ ibase_forge.php
   │  │  │  ├─ ibase_result.php
   │  │  │  ├─ ibase_utility.php
   │  │  │  └─ index.html
   │  │  ├─ index.html
   │  │  ├─ mssql
   │  │  │  ├─ index.html
   │  │  │  ├─ mssql_driver.php
   │  │  │  ├─ mssql_forge.php
   │  │  │  ├─ mssql_result.php
   │  │  │  └─ mssql_utility.php
   │  │  ├─ mysql
   │  │  │  ├─ index.html
   │  │  │  ├─ mysql_driver.php
   │  │  │  ├─ mysql_forge.php
   │  │  │  ├─ mysql_result.php
   │  │  │  └─ mysql_utility.php
   │  │  ├─ mysqli
   │  │  │  ├─ index.html
   │  │  │  ├─ mysqli_driver.php
   │  │  │  ├─ mysqli_forge.php
   │  │  │  ├─ mysqli_result.php
   │  │  │  └─ mysqli_utility.php
   │  │  ├─ oci8
   │  │  │  ├─ index.html
   │  │  │  ├─ oci8_driver.php
   │  │  │  ├─ oci8_forge.php
   │  │  │  ├─ oci8_result.php
   │  │  │  └─ oci8_utility.php
   │  │  ├─ odbc
   │  │  │  ├─ index.html
   │  │  │  ├─ odbc_driver.php
   │  │  │  ├─ odbc_forge.php
   │  │  │  ├─ odbc_result.php
   │  │  │  └─ odbc_utility.php
   │  │  ├─ pdo
   │  │  │  ├─ index.html
   │  │  │  ├─ pdo_driver.php
   │  │  │  ├─ pdo_forge.php
   │  │  │  ├─ pdo_result.php
   │  │  │  ├─ pdo_utility.php
   │  │  │  └─ subdrivers
   │  │  │     ├─ index.html
   │  │  │     ├─ pdo_4d_driver.php
   │  │  │     ├─ pdo_4d_forge.php
   │  │  │     ├─ pdo_cubrid_driver.php
   │  │  │     ├─ pdo_cubrid_forge.php
   │  │  │     ├─ pdo_dblib_driver.php
   │  │  │     ├─ pdo_dblib_forge.php
   │  │  │     ├─ pdo_firebird_driver.php
   │  │  │     ├─ pdo_firebird_forge.php
   │  │  │     ├─ pdo_ibm_driver.php
   │  │  │     ├─ pdo_ibm_forge.php
   │  │  │     ├─ pdo_informix_driver.php
   │  │  │     ├─ pdo_informix_forge.php
   │  │  │     ├─ pdo_mysql_driver.php
   │  │  │     ├─ pdo_mysql_forge.php
   │  │  │     ├─ pdo_oci_driver.php
   │  │  │     ├─ pdo_oci_forge.php
   │  │  │     ├─ pdo_odbc_driver.php
   │  │  │     ├─ pdo_odbc_forge.php
   │  │  │     ├─ pdo_pgsql_driver.php
   │  │  │     ├─ pdo_pgsql_forge.php
   │  │  │     ├─ pdo_sqlite_driver.php
   │  │  │     ├─ pdo_sqlite_forge.php
   │  │  │     ├─ pdo_sqlsrv_driver.php
   │  │  │     └─ pdo_sqlsrv_forge.php
   │  │  ├─ postgre
   │  │  │  ├─ index.html
   │  │  │  ├─ postgre_driver.php
   │  │  │  ├─ postgre_forge.php
   │  │  │  ├─ postgre_result.php
   │  │  │  └─ postgre_utility.php
   │  │  ├─ sqlite
   │  │  │  ├─ index.html
   │  │  │  ├─ sqlite_driver.php
   │  │  │  ├─ sqlite_forge.php
   │  │  │  ├─ sqlite_result.php
   │  │  │  └─ sqlite_utility.php
   │  │  ├─ sqlite3
   │  │  │  ├─ index.html
   │  │  │  ├─ sqlite3_driver.php
   │  │  │  ├─ sqlite3_forge.php
   │  │  │  ├─ sqlite3_result.php
   │  │  │  └─ sqlite3_utility.php
   │  │  └─ sqlsrv
   │  │     ├─ index.html
   │  │     ├─ sqlsrv_driver.php
   │  │     ├─ sqlsrv_forge.php
   │  │     ├─ sqlsrv_result.php
   │  │     └─ sqlsrv_utility.php
   │  └─ index.html
   ├─ fonts
   │  ├─ index.html
   │  └─ texb.ttf
   ├─ helpers
   │  ├─ array_helper.php
   │  ├─ captcha_helper.php
   │  ├─ cookie_helper.php
   │  ├─ date_helper.php
   │  ├─ directory_helper.php
   │  ├─ download_helper.php
   │  ├─ email_helper.php
   │  ├─ file_helper.php
   │  ├─ form_helper.php
   │  ├─ html_helper.php
   │  ├─ index.html
   │  ├─ inflector_helper.php
   │  ├─ language_helper.php
   │  ├─ number_helper.php
   │  ├─ path_helper.php
   │  ├─ security_helper.php
   │  ├─ smiley_helper.php
   │  ├─ string_helper.php
   │  ├─ text_helper.php
   │  ├─ typography_helper.php
   │  ├─ url_helper.php
   │  └─ xml_helper.php
   ├─ index.html
   ├─ language
   │  ├─ english
   │  │  ├─ calendar_lang.php
   │  │  ├─ date_lang.php
   │  │  ├─ db_lang.php
   │  │  ├─ email_lang.php
   │  │  ├─ form_validation_lang.php
   │  │  ├─ ftp_lang.php
   │  │  ├─ imglib_lang.php
   │  │  ├─ index.html
   │  │  ├─ migration_lang.php
   │  │  ├─ number_lang.php
   │  │  ├─ pagination_lang.php
   │  │  ├─ profiler_lang.php
   │  │  ├─ unit_test_lang.php
   │  │  └─ upload_lang.php
   │  └─ index.html
   └─ libraries
      ├─ Cache
      │  ├─ Cache.php
      │  ├─ drivers
      │  │  ├─ Cache_apc.php
      │  │  ├─ Cache_dummy.php
      │  │  ├─ Cache_file.php
      │  │  ├─ Cache_memcached.php
      │  │  ├─ Cache_redis.php
      │  │  ├─ Cache_wincache.php
      │  │  └─ index.html
      │  └─ index.html
      ├─ Calendar.php
      ├─ Cart.php
      ├─ Driver.php
      ├─ Email.php
      ├─ Encrypt.php
      ├─ Encryption.php
      ├─ Form_validation.php
      ├─ Ftp.php
      ├─ Image_lib.php
      ├─ index.html
      ├─ Javascript
      │  ├─ index.html
      │  └─ Jquery.php
      ├─ Javascript.php
      ├─ Migration.php
      ├─ Pagination.php
      ├─ Parser.php
      ├─ Profiler.php
      ├─ Session
      │  ├─ CI_Session_driver_interface.php
      │  ├─ drivers
      │  │  ├─ index.html
      │  │  ├─ Session_database_driver.php
      │  │  ├─ Session_files_driver.php
      │  │  ├─ Session_memcached_driver.php
      │  │  └─ Session_redis_driver.php
      │  ├─ index.html
      │  ├─ OldSessionWrapper.php
      │  ├─ PHP8SessionWrapper.php
      │  ├─ Session.php
      │  ├─ SessionHandlerInterface.php
      │  ├─ SessionUpdateTimestampHandlerInterface.php
      │  └─ Session_driver.php
      ├─ Table.php
      ├─ Trackback.php
      ├─ Typography.php
      ├─ Unit_test.php
      ├─ Upload.php
      ├─ User_agent.php
      ├─ Xmlrpc.php
      ├─ Xmlrpcs.php
      └─ Zip.php

```
</details>

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