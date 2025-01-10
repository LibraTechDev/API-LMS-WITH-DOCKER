# API LMS UAS PEMROGRAMAN SISI SERVER
## Project Overview
Ini adalah API untuk sistem Learning Management System (LMS) yang digunakan untuk Ujian Akhir Semester (UAS) Pemrograman di sisi server. 

## Developer
Primavieri Rhesa Ardana (A11.2022.14557)

## Tool Testing API
Bisa menggunakan Postman , dan sejenisnya lalu akses api nya. Untuk bisa merequest Route API yang berada di dalam grup function auth:sanctum memerlukan authToken yang didapat dari register user. Lalu tambahkan authToken sebagai Authorization untuk key nya lalu Bearer | {authToken} sebagai value di headernya 
 
## Technology Stack
- Laravel - Framework PHP
- MySQL - Relational Database Management System

## List API 
- Register , Login , Logout (Membuat AuthToken) 1
- Category (Endpoint CRUD) 4
- Feedback (Endpoint CRUD) 4
- Announcement (Endpoint CRUD) 4
- Improvement Course Analytic 1
- Improvement Max Student Enrollment 1
- Include semua API yang sebelumnya sudah ada (CRUD Course, CourseMember, CourseContent, Comment) (Non Point)
- Include middleware untuk mengecek apakah request yang diterima server rolenya teacher atau bukan pada beberapa endpoint 

## Disclaimer
- Semua endpoint diasumsikan bahwa user telah melakukan login terlebih dahulu ke sistem kecuali untuk register,login,logout
- Data bisa didapat dengan melakukan seed terlebih dahulu jika ingin langsung testing get
- Model yang diremake dari project sebelumnya ada yang menggunakan perkiraan, seperi model user dikarenakan kurangnya dokumentasi
- Mohon maaf jika masih banyak kekurangan, dan mohon maaf jika saya jarang masuk kelas hehehehe 🙏

## Tutorial How To Clone
- Masuk ke folder yang anda ingin tempatkan

- Masukkan Command Berikut 
```shell
git clone https://github.com/LibraTechDev/API-LMS-SEDERHANA.git
```
- Ketikkan di Terminal
```shell
cp .env.example .env
```
- Ketikkan di Terminal 
```shell
php artisan key:generate
```
- Ketikkan 
```shell
composer install
```
- Ketikkan 
```shell
php artisan migrate --seed
```
- Lalu jalankan server
```shell
php artisan ser
```



