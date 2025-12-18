# ZETTARIG

Sistem Penjualan Part Komputer berbasis CodeIgniter 3.

## Teknologi
- CodeIgniter 3
- AdminLTE v3
- MySQL
- PHP 7.4

## Fitur
- CRUD Master Data
- Pembelian Supplier
- Penjualan & Pembayaran
- COD + DP
- Laporan PDF & Excel

## Instalasi
1. Clone repo
2. Import database
3. Konfigurasi database.php
4. Jalankan via Laragon



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
│  │  │  └─ Supplier_admin.php
│  │  ├─ index.html
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
│  │  └─ Supplier_model.php
│  ├─ third_party
│  │  ├─ dompdf
│  │  │  
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
│     │  │  └─ index.php
│     │  ├─ laporan_pembelian
│     │  │  ├─ detail.php
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
│     └─ welcome_message.php
├─ assets
│  └─ adminlte
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