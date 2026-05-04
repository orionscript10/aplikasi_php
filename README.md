# RECAFE - Aplikasi Pemesanan Cafe

Aplikasi pemesanan makanan dan minuman untuk cafe yang mudah dan praktis.

## Deployment ke Railway

### Prasyarat
- GitHub account
- Railway account (daftar di https://railway.app)
- Database MySQL

### Step-by-Step Deployment

#### 1. Persiapan Kode
Repository sudah dilengkapi dengan file konfigurasi untuk deployment:
- `Procfile` - Konfigurasi untuk menjalankan aplikasi
- `.env.example` - Template environment variables

#### 2. Connect ke Railway
1. Buka https://railway.app
2. Login dengan GitHub
3. Klik "New Project"
4. Pilih "Deploy from GitHub repo"
5. Pilih repository `orionscript10/aplikasi_php`

#### 3. Setup Database di Railway
1. Di dashboard Railway project Anda, klik "New"
2. Pilih "Database" → "MySQL"
3. Railway akan otomatis membuat database dan generate credentials

#### 4. Set Environment Variables
Railway akan otomatis membuat variable `DATABASE_URL`. Tambahkan:

```
DB_HOST=<host dari Railway MySQL>
DB_USER=<username dari Railway MySQL>
DB_PASSWORD=<password dari Railway MySQL>
DB_NAME=<nama database dari Railway MySQL>
```

Atau biarkan sistem otomatis menggunakan `DATABASE_URL`.

#### 5. Deploy
1. Push code ke GitHub
2. Railway otomatis build dan deploy
3. Tunggu sampai deployment selesai
4. Buka URL yang diberikan Railway di browser

### Struktur Aplikasi

```
aplikasi_php/
├── index.php           # Router utama
├── login.php           # Halaman login
├── home.php            # Halaman home
├── menu.php            # Manajemen menu
├── orders.php          # Manajemen pesanan
├── orders_item.php     # Detail item pesanan
├── dapur.php           # Dashboard dapur
├── user.php            # Manajemen user
├── reports.php         # Laporan penjualan
├── katmenu.php         # Kategori menu
├── view_item.php       # View item
├── header.php          # Header template
├── sidebar.php         # Sidebar template
├── main.php            # Main layout
├── proses/             # Backend scripts
│   ├── connect.php     # Database connection
│   └── proses_*.php    # Processing scripts
├── assets/             # CSS, JS, images
├── Procfile            # Railway configuration
└── .env.example        # Environment template
```

### Login Default
- Username: (sesuai database)
- Password: (sesuai database)

### Support
Untuk bantuan lebih lanjut, silakan buat issue di repository ini.
