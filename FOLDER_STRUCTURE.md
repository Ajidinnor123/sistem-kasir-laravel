# Struktur Folder Project

Panduan lengkap struktur folder proyek Sistem Kasir Laravel 10.

## 📁 Struktur Utama

```
sistem-kasir-laravel/
│
├── app/                              # Aplikasi Laravel
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   ├── Handler.php
│   │   ├── InsufficientStockException.php
│   │   ├── InvalidPaymentException.php
│   │   └── WhatsappException.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProductController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── PaymentController.php
│   │   │   ├── UserController.php
│   │   │   ├── OutletController.php
│   │   │   ├── ReportController.php
│   │   │   ├── StockController.php
│   │   │   ├── DiscountController.php
│   │   │   └── WhatsappController.php
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php
│   │   │   ├── EncryptCookies.php
│   │   │   ├── PreventRequestsDuringMaintenance.php
│   │   │   ├── RedirectIfAuthenticated.php
│   │   │   ├── TrimStrings.php
│   │   │   ├── TrustHosts.php
│   │   │   ├── TrustProxies.php
│   │   │   ├── VerifyCsrfToken.php
│   │   │   ├── CheckRole.php              # Custom: Cek role user
│   │   │   └── CheckOutlet.php            # Custom: Cek outlet user
│   │   └── Requests/
│   │       ├── StoreProductRequest.php
│   │       ├── UpdateProductRequest.php
│   │       ├── StoreTransactionRequest.php
│   │       ├── StoreCategoryRequest.php
│   │       ├── StoreUserRequest.php
│   │       └── StoreOutletRequest.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Outlet.php
│   │   ├── Category.php
│   │   ├── Product.php
│   │   ├── Transaction.php
│   │   ├── TransactionItem.php
│   │   ├── Payment.php
│   │   ├── Discount.php
│   │   ├── StockHistory.php
│   │   └── WhatsappMessage.php
│   ├── Services/
│   │   ├── TransactionService.php
│   │   ├── PaymentService.php
│   │   ├── WhatsappService.php
│   │   ├── ReportService.php
│   │   ├── StockService.php
│   │   ├── DiscountService.php
│   │   ├── ProductService.php
│   │   └── InvoiceService.php
│   ├── Events/
│   │   ├── TransactionCreated.php
│   │   ├── TransactionCompleted.php
│   │   ├── StockUpdated.php
│   │   └── PaymentProcessed.php
│   ├── Listeners/
│   │   ├── SendWhatsappReceipt.php
│   │   └── UpdateStockHistory.php
│   ├── Jobs/
│   │   ├── SendWhatsappMessage.php
│   │   ├── GenerateReport.php
│   │   └── CleanupOldTransactions.php
│   ├── Mail/
│   │   ├── TransactionReceipt.php
│   │   └── PaymentConfirmation.php
│   ├── Traits/
│   │   ├── HasOutlet.php
│   │   ├── HasRoles.php
│   │   └── GeneratesTransactionNumber.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── BroadcastServiceProvider.php
│       ├── EventServiceProvider.php
│       ├── RouteServiceProvider.php
│       └── RepositoryServiceProvider.php
│
├── bootstrap/
│   ├── app.php
│   └── cache/
│
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── hashing.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   ├── session.php
│   ├── view.php
│   ├── whatsapp.php           # Custom: WhatsApp config
│   └── payment.php             # Custom: Payment config
│
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   ├── ProductFactory.php
│   │   ├── CategoryFactory.php
│   │   ├── OutletFactory.php
│   │   └── TransactionFactory.php
│   ├── migrations/
│   │   ├── 2024_01_01_000001_create_outlets_table.php
│   │   ├── 2024_01_01_000002_create_users_table.php
│   │   ├── 2024_01_01_000003_create_categories_table.php
│   │   ├── 2024_01_01_000004_create_products_table.php
│   │   ├── 2024_01_01_000005_create_transactions_table.php
│   │   ├── 2024_01_01_000006_create_transaction_items_table.php
│   │   ├── 2024_01_01_000007_create_payments_table.php
│   │   ├── 2024_01_01_000008_create_discounts_table.php
│   │   ├── 2024_01_01_000009_create_stock_histories_table.php
│   │   └── 2024_01_01_000010_create_whatsapp_messages_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── OutletSeeder.php
│       ├── UserSeeder.php
│       ├── CategorySeeder.php
│       └── ProductSeeder.php
│
├── public/
│   ├── index.php
│   ├── .htaccess
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   ├── images/
│   ├── uploads/
│   │   ├── products/
│   │   ├── receipts/
│   │   └── reports/
│   └── favicon.ico
│
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   ├── app.js
│   │   ├── bootstrap.js
│   │   ├── transactions.js
│   │   └── products.js
│   ├── views/
│   │   ├── layouts/
│   │   │   ├── app.blade.php
│   │   │   ├── sidebar.blade.php
│   │   │   ├── navbar.blade.php
│   │   │   └── footer.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── forgot-password.blade.php
│   │   ├── dashboard/
│   │   │   ├── index.blade.php
│   │   │   ├── charts.blade.php
│   │   │   └── widgets.blade.php
│   │   ├── products/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── edit.blade.php
│   │   │   └── show.blade.php
│   │   ├── categories/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── transactions/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   ├── show.blade.php
│   │   │   ├── receipt.blade.php
│   │   │   └── print.blade.php
│   │   ├── reports/
│   │   │   ├── sales.blade.php
│   │   │   ├── inventory.blade.php
│   │   │   ├── payment.blade.php
│   │   │   ├── top-products.blade.php
│   │   │   └── index.blade.php
│   │   ├── users/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── outlets/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── discounts/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── edit.blade.php
│   │   ├── stock/
│   │   │   ├── index.blade.php
│   │   │   └── history.blade.php
│   │   └── components/
│   │       ├── alert.blade.php
│   │       ├── modal.blade.php
│   │       ├── form-input.blade.php
│   │       └── data-table.blade.php
│   └── lang/
│       ├── en/
│       └── id/
│
├── routes/
│   ├── api.php
│   ├── console.php
│   ├── channels.php
│   └── web.php
│
├── storage/
│   ├── app/
│   │   ├── public/
│   │   └── uploads/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   ├── testing/
│   │   └── views/
│   └── logs/
│
├── tests/
│   ├── Feature/
│   │   ├── TransactionTest.php
│   │   ├── ProductTest.php
│   │   ├── UserTest.php
│   │   ├── PaymentTest.php
│   │   └── WhatsappTest.php
│   ├── Unit/
│   │   ├── Services/
│   │   │   ├── TransactionServiceTest.php
│   │   │   ├── PaymentServiceTest.php
│   │   │   ├── WhatsappServiceTest.php
│   │   │   └── DiscountServiceTest.php
│   │   └── Models/
│   │       ├── UserTest.php
│   │       ├── ProductTest.php
│   │       └── TransactionTest.php
│   ├── CreatesApplication.php
│   └── TestCase.php
│
├── .env.example
├── .env.testing
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── DEPLOYMENT.md
├── DATABASE_SCHEMA.md
├── INSTALLATION.md
├── FOLDER_STRUCTURE.md
├── package.json
├── package-lock.json
├── phpunit.xml
├── tailwind.config.js
├── vite.config.js
└── README.md
```

## 📋 Deskripsi Per Folder

### `app/Console`
- **Kernel.php**: Pendaftaran command dan jadwal task

### `app/Exceptions`
- **Handler.php**: Exception handling global
- **Custom Exceptions**: Exception khusus untuk domain

### `app/Http/Controllers`
- **DashboardController**: Dashboard & analytics
- **ProductController**: CRUD produk
- **TransactionController**: CRUD transaksi
- **PaymentController**: Manajemen pembayaran
- **ReportController**: Generate laporan
- **StockController**: Manajemen stok
- **UserController**: Manajemen user
- **OutletController**: Manajemen outlet

### `app/Http/Middleware`
- **CheckRole**: Verifikasi role user (admin, manajer, kasir)
- **CheckOutlet**: Verifikasi user akses ke outlet

### `app/Models`
- **Eloquent Models** dengan relationship & scope

### `app/Services`
- **Business Logic Layer**: Pisah dari Controller
- **Reusable Code**: Share logic antar controller
- **Testing**: Mudah untuk unit testing

### `app/Events & Listeners`
- **Event-driven Architecture**
- **Decoupled Code**: Misal, transaction created → kirim WA
- **Scalable**: Mudah tambah listener baru

### `database/migrations`
- **Order**: 000001 → outlets, 000002 → users, dll
- **Foreign Keys**: Sesuaikan dengan dependency

### `resources/views`
- **Blade Templates**: Terstruktur per fitur
- **Reusable Components**: Alert, Modal, Form

### `tests`
- **Feature Tests**: Test endpoint/API
- **Unit Tests**: Test service & model
- **Database**: Use seeding untuk test data

---

## 🚀 Naming Conventions

### Controllers
```
ProductController.php           # CRUD produk
CategoryController.php          # CRUD kategori
TransactionController.php       # CRUD transaksi
```

### Models
```
Product.php
Category.php
Transaction.php
```

### Migrations
```
2024_01_01_000001_create_outlets_table.php
2024_01_02_000001_add_column_to_products_table.php
```

### Views
```
resources/views/products/index.blade.php
resources/views/products/create.blade.php
resources/views/dashboard/index.blade.php
```

### Services
```
ProductService.php
TransactionService.php
WhatsappService.php
```

---

## 📂 Best Practices

✅ **Satu folder = Satu tujuan**  
✅ **Controllers hanya untuk HTTP logic**  
✅ **Services untuk business logic**  
✅ **Models untuk database relationship**  
✅ **Request validation di Form Request**  
✅ **Exceptions untuk error handling**  
✅ **Traits untuk shared functionality**  

