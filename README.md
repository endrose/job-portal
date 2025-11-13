<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<img src="https://img.shields.io/badge/Laravel-10-red" alt="Laravel Version">
<img src="https://img.shields.io/badge/PHP-8.2-blue" alt="PHP Version">
<img src="https://img.shields.io/badge/Database-PostgreSQL-green" alt="Database">
</p>

## Project Overview

Project ini merupakan aplikasi internal berbasis **Laravel 10** dengan backend API untuk **Job & Application**.  
Proyek ini menggunakan:
- Laravel 10
- PHP 8.2+
- PostgreSQL
- Artisan commands untuk serve aplikasi & API

---

## Setup & Installation

1. Clone repository:
```bash
git clone <repository-url>
cd <project-folder>


## Install dependencies
```bash
composer install


## Env Konfiguasi
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_job_portal
DB_USERNAME=root
DB_PASSWORD=

## Migrate Database
```bash
php artisan migrate:fresh --seed


## Running Server & Konsumsi API
```bash
php artisan serve
php artisan serve --port=8001





