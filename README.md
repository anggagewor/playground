<p align="center">
  <img src="https://raw.githubusercontent.com/anggagewor/brostman-py/refs/heads/main/assets/logo.png" alt="Brostman Logo" width="200"/>
</p>

<h1 align="center">Playground</h1>

<p align="center">
  🚀 Laravel playground untuk eksperimen Clean Architecture + Modular Package Development
</p>

---

## 📦 Tentang Project

Repo ini adalah **playground** untuk belajar dan eksperimen arsitektur Laravel berbasis **Clean Architecture** dan **modular structure**.
Dilengkapi dengan package `anggagewor/foundation` yang berfungsi sebagai shared component dan scaffolding generator untuk module baru.

---

## 🛠 Instalasi

1. **Clone repository**

   ```bash
   git clone https://github.com/anggagewor/playground.git
   cd playground
   ```

2. **Install dependencies**

   ```bash
   composer install
   cp .env.example .env
   php artisan key:generate
   ```

3. **Jalankan migration (opsional)**

   ```bash
   php artisan migrate
   ```

---

## 🚀 Membuat Module Baru

Package `foundation` menyediakan command untuk generate module dengan struktur **Clean Architecture**.

```bash
php artisan make:module Blog
```

Struktur yang dihasilkan:

```
app/Modules/Blog
├── Application
│   └── UseCases
├── Domain
│   ├── Entities
│   └── Interfaces
├── Infrastructure
│   └── Services
├── Interface
│   └── Http
│       └── Controllers
├── Providers
│   └── ModuleServiceProvider.php
└── routes
    ├── web.php
    └── api.php
```

---

## ⚙ Auto Discovery Module

`FoundationServiceProvider` akan otomatis mendaftarkan semua `ModuleServiceProvider` yang ditemukan di folder `app/Modules`.

Contoh:

```php
App\Modules\Blog\Providers\ModuleServiceProvider
```

Akan otomatis ter-register tanpa perlu manual edit `config/app.php`.

---

## 📂 Struktur Package Foundation

```
packages/anggagewor/foundation
├── src
│   ├── Console/Commands/MakeModuleCommand.php
│   ├── Providers/FoundationServiceProvider.php
│   └── stubs/
├── composer.json
└── README.md
```

---

## 🧪 Mode Playground

Repo ini dibuat untuk bebas eksplorasi:

* Testing Clean Architecture
* Eksperimen package development
* Modular Laravel project

Jadi silakan **bakar-bakaran code** dan lihat hasilnya! 😎🔥

---

## 📜 Lisensi

MIT License © Angga Purnama
