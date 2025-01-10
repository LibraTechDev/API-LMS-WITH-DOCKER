# UAS Pemrograman Sisi Server
## Project LMS API Laravel w/ Docker

## Fitur
- Register, Login, & Logout - Point 1
- Course Analytic - Point 1
- Limitation Maximum Student Enroll - Point 1
- Announcement - Point 4
- Feedback - Point 4
- Category - Point 4

## Technology Stack
- Laravel - Framework PHP
- MySQL - Relational Database Management System
- Nginx - Web server
- Docker - Container platform

## Prerequisite
Pada sistem operasi user telah terinstal `Docker Desktop` atau package `docker` & `docker-compose`

## Guide / Step-by-step
### 1. Clone Project
```shell
git clone https://github.com/FadhilFirmansyah/lms-api.git
```
Clonning project ke directory yang sedang anda akses saat ini
### 2. Change Directory
```shell
cd lms-api
```
Berpindah menuju directory / folder hasil dari project yang telah di clone
### 3. Install Project
#### 3.1. Linux & MacOS (UNIX)
```shell
./setup.sh
```
Melakukan setup installasi dari awal hingga akhir, scripting yang membantu dengan menghindari serimonial setup ;)
#### 3.2. Windows 
Sayangnya scripting `setup.sh` tidak bisa berjalan kecuali user menggunakan wsl dengan mounting yang sesuai maka bisa apabila menggunakan cara reguler pada Windows sayangnya tidak bisa, user harus melakukan kegiatan seremonial setup :(
##### 3.2.1. Compose Up
```shell
docker-compose up -d --build
```
Bertujuan untuk inisialisasi awal seperti pembuatan `Dockerfile` dan `docker-compose.yml` menjadi suatu container
##### 3.2.2. Change Modifier
```shell
docker-compose exec app chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
```
Direcotry `/storage` dan `/bootstrap/cache` akan memiliki semua akses (Write, Read, Execute)
##### 3.2.3. NPM Install
```shell
docker exec laravel_app npm i
```
Menginstall segala dependency untuk frontend yang bersumber dari `package.json`
##### 3.2.4. NPM Build
```shell
docker exec laravel_app npm run build
```
Perintah yang menjalankan skrip `build` yang terdefinisi di file `package.json` dalam container `laravel_app`
##### 3.2.5. Composer Scope Install
```shell
docker exec laravel_app composer install
```
Menginstal dependensi PHP yang terdaftar di file `composer.json` dalam container `laravel_app`
##### 3.2.6. Duplicate .ENV File
```shell
docker exec laravel_app cp .env.example .env
```
Menyalin file `.env.example` menjadi file `.env` di dalam container `laravel_app`, yang digunakan untuk konfigurasi aplikasi
##### 3.2.7. Activate .ENV File
```shell
docker exec laravel_app php artisan key:generate
```
Menghasilkan dan mengatur kunci aplikasi baru untuk Laravel di dalam container `laravel_app`, yang digunakan untuk keamanan aplikasi
##### 3.2.8. Formatting .ENV File
Ubah file `.env` yang terletak di `/lms-api`
```.env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=root
DB_PASSWORD=
```
Menjadi
```.env
DB_CONNECTION=mysql
DB_HOST=mysql_db
DB_PORT=3306
DB_DATABASE=lms_api
DB_USERNAME=root
DB_PASSWORD=root
```
##### 3.2.9. Database
```shell
docker exec laravel_app php artisan migrate --seed
```
Migrasi database untuk memperbarui struktur tabel di dalam container `laravel_app`

### How To Testing On Postman
- Pertama Bisa Meregister terlebih dahulu dengan mengakses localhost/api/register dengan mengisikan field **Username,Fullname,Email,Password** untuk mendapatkan authToken, atau bisa juga dengan melakukan login yaitu mengakses localhost/api/login untuk sama-sama mendapatkan authToken. **AuthToken di sini berguna sebagai authorization** untuk mengakses berbagai API Route yang berada dalam group function auth:sanctum karena diasumsikan untuk bisa mengakses fitur-fiturnya memerlukan login terlebih dahulu. **Kecuali 3 route yaitu login,register,logout**.
- Setiap ingin mengakses endpoint , cantumkan terlebih dahulu **AuthToken tersebut sebagai header Authorization sebagai keynya , lalu untuk valuenya diisi Bearer | {authToken}**
- Saya menyediakan dua akun untuk testing yaitu dengan role teacher dan student, bisa langsung login ke akun tersebut
```shell
'username' => 'Primavieri',
'fullname' => 'Primavieri Rhesa',
'email' => 'primavieri@gmail.com',
'password' => '12345678',
'role' => 'teacher' //untuk role teacher
```

```shell
'username' => 'Aggus',
'fullname' => 'Agus',
'email' => 'agus@gmail.com',
'password' => '12345678',
'role' => 'student' //untuk role student
```


## Arsitektur Aplikasi
- **docker-compose.yml** - Konfigurasi yang digunakan oleh Docker Compose untuk mendefinisikan dan menjalankan multi-container Docker aplikasi, termasuk pengaturan layanan, jaringan, volume, dan penghubung antar container
- **Dockerfile** - File teks yang berisi serangkaian instruksi untuk membangun image Docker, termasuk pengaturan sistem, instalasi aplikasi, dan konfigurasi yang diperlukan
- **lms-api** - Source code project endpoint API LMS 
- **nginx.conf** - File konfigurasi utama Nginx yang mengatur pengaturan server, rute trafik, dan interaksi dengan aplikasi 
- **setup.sh** - Script installasi setup untuk membuat container, frontend, backend, dan database
