# BE-Program Laravel

## Deskripsi Proyek

Proyek ini adalah backend untuk aplikasi [Nama Aplikasi], yang dibangun menggunakan framework **Laravel**. Backend ini menyediakan berbagai endpoint API untuk operasi-operasi seperti pendaftaran pengguna, login, manajemen produk, dan lainnya.

## Teknologi yang Digunakan

- **Framework**: Laravel
- **Bahasa Pemrograman**: PHP
- **Database**: [Misalnya MySQL, PostgreSQL, dll]
- **Autentikasi**: JWT (JSON Web Token) untuk autentikasi API
- **ORM**: Eloquent


## Setup dan Instalasi

### Prasyarat
Pastikan Anda memiliki perangkat lunak berikut yang sudah terinstal:
- [Git](https://git-scm.com/)
- [PHP](https://www.php.net/downloads.php) (PHP >= 8.0)
- [Composer](https://getcomposer.org/)
- [Database yang dibutuhkan](https://www.mysql.com/) (misalnya, MySQL atau PostgreSQL)

### Langkah-langkah Instalasi

1. **Clone Repository**:
   ```bash
   git clone https://github.com/naufal2376/be-program-laravel.git
   cd be-program-laravel

2. **Instalasi Dependensi**: Jalankan perintah berikut untuk menginstal dependensi dengan Composer:
   ```bash
   composer install

3. **Konfigurasi Lingkungan**: Salin file .env.example ke .env dan sesuaikan konfigurasi seperti URL database, JWT secret, dll:
   ```bash
   cp .env.example .env

4. **Buat Kunci Aplikasi**: Jalankan perintah berikut untuk menghasilkan kunci aplikasi Laravel:
   ```bash
   php artisan key:generate

5. **Migrasi Database**: Jalankan perintah berikut untuk membuat tabel di database menggunakan migrasi:
   ```bash
   php artisan migrate

6. **Menjalankan Aplikasi**: Jalankan aplikasi menggunakan perintah berikut:
   ```bash
   php artisan serve
