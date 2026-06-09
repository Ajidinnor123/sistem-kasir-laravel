# 🚀 Installation & Setup Guide

Panduan lengkap instalasi dan setup Sistem Kasir Laravel 10.

## 📋 Prerequisites

Pastikan Anda sudah memiliki:

- **PHP 8.1+** - [Download PHP](https://www.php.net/downloads)
- **Composer** - [Download Composer](https://getcomposer.org/download/)
- **MySQL 8.0+** - [Download MySQL](https://www.mysql.com/downloads/)
- **Node.js & NPM** - [Download Node.js](https://nodejs.org/)
- **Git** - [Download Git](https://git-scm.com/downloads)

Verifikasi instalasi:
```bash
php -v
composer -v
mysql --version
node -v
npm -v
git --version
```

---

## 🔧 Step-by-Step Installation

### 1️⃣ Clone Repository

```bash
git clone https://github.com/Ajidinnor123/sistem-kasir-laravel.git
cd sistem-kasir-laravel
```

### 2️⃣ Install PHP Dependencies

```bash
composer install
```

Jika ada error, coba:
```bash
composer install --no-interaction --prefer-dist --optimize-autoloader
```

### 3️⃣ Install JavaScript Dependencies

```bash
npm install
```

### 4️⃣ Setup Environment File

```bash
cp .env.example .env
```

Atau di Windows:
```bash
copy .env.example .env
```

### 5️⃣ Generate Application Key

```bash
php artisan key:generate
```

### 6️⃣ Setup Database

#### A. Create Database
Buka MySQL dan buat database:

```sql
CREATE DATABASE sistem_kasir CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### B. Configure .env

Edit file `.env` dan atur database configuration:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_kasir
DB_USERNAME=root
DB_PASSWORD=your_password
```

#### C. Run Migrations

```bash
php artisan migrate
```

Jika ada error dan ingin reset:
```bash
php artisan migrate:refresh
```

### 7️⃣ Run Database Seeders

```bash
php artisan db:seed
```

Atau dengan seeders spesifik:
```bash
php artisan db:seed --class=DatabaseSeeder
```

### 8️⃣ Setup WhatsApp Configuration

Edit file `.env` dan tambahkan WhatsApp Business API credentials:

```env
WHATSAPP_BUSINESS_ACCOUNT_ID=your_account_id
WHATSAPP_BUSINESS_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_BUSINESS_ACCESS_TOKEN=your_access_token
WHATSAPP_WEBHOOK_VERIFY_TOKEN=your_verify_token
```

**Cara mendapatkan credentials:**

1. Buka [Meta Business Manager](https://business.facebook.com/)
2. Pilih WhatsApp Business Account
3. Pergi ke Settings → Account Information
4. Copy Account ID dan Phone Number ID
5. Generate Access Token di App Settings

### 9️⃣ Build Frontend Assets

**Development:**
```bash
npm run dev
```

**Production:**
```bash
npm run build
```

### 🔟 Start Development Server

```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

**Catatan:** Buka terminal lain untuk npm watcher:
```bash
npm run dev
```

---

## 🔐 Default Login Credentials

Setelah seeder berjalan, gunakan akun berikut:

| Role | Email | Password |
|------|-------|----------|
| 👨‍💼 Admin | admin@kasir.com | password |
| 📊 Manajer | manajer@kasir.com | password |
| 🛒 Kasir | kasir@kasir.com | password |

⚠️ **Penting:** Ubah password setelah login pertama!

---

## 📁 Post-Installation Setup

### 1. Setup Storage Symlink

```bash
php artisan storage:link
```

Ini memungkinkan upload file (gambar produk, struk PDF, dll).

### 2. Setup File Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
chmod -R 755 public/uploads
```

### 3. Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### 4. Optimize for Production (Optional)

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

---

## 🧪 Testing

### Run All Tests

```bash
php artisan test
```

### Run Specific Test

```bash
php artisan test tests/Feature/TransactionTest.php
```

### Run with Coverage

```bash
php artisan test --coverage
```

---

## 📖 Project Structure Quick Reference

```
app/
├── Http/Controllers/          ← API & Web Controllers
├── Models/                    ← Database Models
├── Services/                  ← Business Logic
├── Exceptions/                ← Custom Exceptions
└── Events/                    ← Event Classes

database/
├── migrations/                ← Database Schemas
├── seeders/                   ← Dummy Data
└── factories/                 ← Model Factories

resources/
├── views/                     ← Blade Templates
├── css/                       ← Stylesheets
└── js/                        ← JavaScript

routes/
├── web.php                    ← Web Routes
└── api.php                    ← API Routes
```

---

## 🚀 Running Common Commands

### Database Management

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset all migrations
php artisan migrate:refresh

# Reset with seeders
php artisan migrate:refresh --seed

# View migration status
php artisan migrate:status
```

### Cache Management

```bash
# Clear all cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear view cache
php artisan view:clear

# Clear everything
php artisan optimize:clear
```

### Artisan Commands

```bash
# List all commands
php artisan list

# Create new controller
php artisan make:controller ControllerName

# Create new model
php artisan make:model ModelName

# Create migration
php artisan make:migration create_table_name

# Create seeder
php artisan make:seeder SeederName

# Create job
php artisan make:job JobName
```

---

## 🐛 Troubleshooting

### Problem: "No application encryption key has been specified"

**Solution:**
```bash
php artisan key:generate
```

### Problem: "Specified key was too long; max key length is 767 bytes"

**Solution:** Edit `config/database.php` dan ubah charset:
```php
'charset' => 'utf8',
'collation' => 'utf8_unicode_ci',
```

Atau jalankan:
```bash
php artisan migrate:refresh
```

### Problem: "SQLSTATE[HY000] [2002] Connection refused"

**Solution:** Pastikan MySQL berjalan dan .env benar:
```bash
# Cek MySQL status
sudo systemctl status mysql

# Start MySQL (Linux)
sudo systemctl start mysql

# Start MySQL (Mac)
brew services start mysql
```

### Problem: "Class not found" atau "Undefined variable"

**Solution:**
```bash
composer dump-autoload
php artisan cache:clear
```

### Problem: Node modules tidak install

**Solution:**
```bash
rm -rf node_modules package-lock.json
npm install
```

---

## 🌐 Environment-Specific Setup

### Local Development

```env
APP_ENV=local
APP_DEBUG=true
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### Staging

```env
APP_ENV=staging
APP_DEBUG=true
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

### Production

```env
APP_ENV=production
APP_DEBUG=false
CACHE_DRIVER=redis
QUEUE_CONNECTION=redis
```

Run: `php artisan optimize`

---

## 📊 Database Backup

### Backup Database

```bash
mysqldump -u root -p sistem_kasir > backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database

```bash
mysql -u root -p sistem_kasir < backup_20240101_120000.sql
```

---

## 🔒 Security Checklist

- ✅ Generate unique APP_KEY
- ✅ Set APP_ENV=production
- ✅ Disable APP_DEBUG
- ✅ Set strong database password
- ✅ Configure CORS jika menggunakan API
- ✅ Setup HTTPS
- ✅ Ubah default login credentials
- ✅ Configure firewall rules
- ✅ Regular backup database
- ✅ Update dependencies: `composer update`

---

## 📚 Useful Links

- [Laravel Documentation](https://laravel.com/docs/10.x)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PHP Documentation](https://www.php.net/manual/)
- [WhatsApp Business API](https://developers.facebook.com/docs/whatsapp/cloud-api)
- [Vue.js Documentation](https://vuejs.org/)

---

## ✅ Verification Checklist

Setelah instalasi, pastikan:

- ✅ `php artisan serve` berjalan tanpa error
- ✅ Database migration selesai
- ✅ Bisa login dengan credentials default
- ✅ Dashboard menampilkan data
- ✅ Bisa create produk baru
- ✅ Bisa create transaksi
- ✅ WhatsApp integration terkoneksi (jika sudah setup)

---

## 🆘 Need Help?

Jika ada masalah:

1. Cek documentation di repository
2. Buat issue di GitHub
3. Cek Laravel documentation
4. Search di Stack Overflow

---

**Happy Coding! 🎉**

Last Updated: Juni 2026

