#!/bin/bash

ENV_FILE="./lms-api/.env"
OS_TYPE=$(uname)

# Membangun ulang container Docker dan menjalankannya di background
echo "Membangun dan menjalankan container......"
docker-compose up -d --build > /dev/null 2>&1
docker-compose down > /dev/null 2>&1
docker-compose up -d > /dev/null 2>&1

# Memberikan izin pada direktori storage dan cache Laravel untuk menghindari masalah izin
echo "Memberikan izin pada direktori storage dan cache......"
docker-compose exec app chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

echo "Menjalankan installasi frontend (in case)......"
docker exec laravel_app npm i > /dev/null 2>&1
docker exec laravel_app npm run build > /dev/null 2>&1

# Menginstal dependensi PHP dengan Composer
echo "Menginstal dependensi backend......"
docker exec laravel_app composer install > /dev/null 2>&1

# Menyalin file .env.example menjadi .env
echo "Configurasi .env untuk backend......"
docker exec laravel_app cp .env.example .env

# Menghasilkan kunci aplikasi Laravel
echo "Menghasilkan kunci aplikasi backend......"
docker exec laravel_app php artisan key:generate > /dev/null 2>&1

# Penyesuaian pada file .env
echo "Konfigurasi .env untuk container......"
if [ "$OS_TYPE" == "Darwin" ]; then
  # macOS
  sed -i '' 's/^DB_HOST=.*$/DB_HOST=mysql_db/' $ENV_FILE
  sed -i '' 's/^DB_PASSWORD=.*$/DB_PASSWORD=root/' $ENV_FILE
else
  # Linux
  sed -i 's/^DB_HOST=.*$/DB_HOST=mysql_db/' $ENV_FILE
  sed -i 's/^DB_PASSWORD=.*$/DB_PASSWORD=root/' $ENV_FILE
fi

# Pembuatan Database untuk aplikasi inventory
echo "Pembuatan database untuk aplikasi......"
docker exec laravel_app php artisan migrate > /dev/null 2>&1

echo
echo

echo "SETUP TELAH SELESAI"
docker ps 

echo
echo

echo "Silahkan untuk dapat mengakses Endpoint API LMS - http://127.0.0.1:80"