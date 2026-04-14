# Sistem Monitoring & Evaluasi Branding Wilayah ASN Pemkot Surabaya
## Kampung Pancasila Digital Tracking (KPDT)

---

## 📋 Deskripsi Proyek

Sistem **Kampung Pancasila Digital Tracking (KPDT)** adalah platform monitoring dan evaluasi untuk membantu Pemerintah Kota Surabaya dalam:

- **Memantau aktivitas publikasi ASN** (Aparatur Sipil Negara) di media sosial
- **Mengukur dampak kegiatan branding wilayah** secara objektif dan terukur
- **Mengevaluasi performa posting** berdasarkan target bulanan dan engagement metrics
- **Mengelola feedback dan evaluasi** dari pimpinan kepada ASN
- **Tracking performance dengan flagging otomatis** untuk ASN yang underperforming

### Target Sistem:
- Target posting: **4 posting/bulan** untuk setiap ASN
- Status performa: ON_TARGET, AT_RISK, BELOW_TARGET
- Metrics: Likes, Comments, Shares per posting

---

## 👥 Tim Pengembang

| Nama | NIM | Peran |
|------|-----|-------|
| Hikmawan Nugie Ramadhan | 1482300067 | Developer |
| Reno Indra Purnama | 1482300069 | Developer |

**Institusi**: Dinas Komunikasi dan Informatika Surabaya  
**Status**: Luaran Magang 2026

---

## 🛠️ Tech Stack & Tools

### Backend Framework
- **Laravel 11** - PHP Web Framework
- **PHP 8.2+** - Server-side programming

### Frontend
- **Tailwind CSS 3** - Utility-first CSS framework
- **Vite** - Frontend build tool & dev server
- **JavaScript/jQuery** - Client-side scripting

### Database
- **MySQL/MariaDB** - Relational database

### Security & Authorization
- **Spatie/Laravel-Permission** - Role-based access control
- **Laravel Auth** - Built-in authentication

### Development Tools
- **Composer** - PHP dependency manager
- **Node.js & NPM** - JavaScript dependency management
- **Artisan** - Laravel command-line interface

### Additional Packages
- **Carbon** - DateTime library
- **Faker** - Fake data generator
- **PHPUnit** - Testing framework

---

## 📋 Requirements

### System Requirements
- **PHP**: 8.2 atau lebih tinggi
- **MySQL/MariaDB**: 5.7 atau lebih tinggi
- **Composer**: Latest version
- **Node.js**: 16.0 atau lebih tinggi
- **NPM**: 8.0 atau lebih tinggi

### Environment Setup
```
APP_NAME=KPDT-Demo
APP_ENV=local
APP_DEBUG=true
APP_KEY=base64:...
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kpdt_demo
DB_USERNAME=root
DB_PASSWORD=
```

---

## 📁 Struktur Proyek

```
kpdt-demo/
├── app/
│   ├── Console/Commands/          # Artisan commands
│   ├── Http/
│   │   ├── Controllers/           # Controller untuk 3 role (ASN, PIMPINAN, ADMIN)
│   │   └── Middleware/            # Custom middleware
│   ├── Models/                    # Eloquent models
│   ├── Policies/                  # Authorization policies
│   └── Providers/                 # Service providers
├── database/
│   ├── migrations/                # Database migrations
│   └── factories/                 # Model factories
├── resources/
│   ├── views/                     # Blade templates
│   ├── css/                       # Stylesheets
│   └── js/                        # JavaScript files
├── routes/                        # Web routes
├── config/                        # Configuration files
├── storage/                       # File uploads & logs
├── tests/                         # Unit & feature tests
└── public/                        # Public assets
```

---

## 🔐 Role-Based Access

Sistem memiliki 3 role utama:

### 1. ASN (Aparatur Sipil Negara)
- Membuat dan mengelola posting media sosial
- Melihat dashboard personal dengan stats performa
- Menerima & merespons notifikasi flagging/feedback
- Update engagement data posting

### 2. PIMPINAN (Manager/Supervisor)
- Monitoring performance ASN
- Memberikan evaluasi & feedback ke ASN
- Menjalankan auto-flagging
- View KPI dashboard

### 3. ADMIN (Administrator)
- Manage master data sistem
- CRUD Users, Wilayah, OPD, Pilar
- System configuration

---

## 🚀 Fitur Utama

### Dashboard ASN
- Real-time performance stats
- Monthly posting target progress
- Flagging & feedback notifications
- Posting history & engagement metrics

### Monitoring Pimpinan
- ASN performance overview
- KPI statistics (ON_TARGET, AT_RISK, BELOW_TARGET)
- Filter by OPD & Wilayah
- Evaluation & feedback management

### Admin Panel
- Master data management
- User account management
- System configuration

### Auto-flagging System
- Otomatis flag ASN dengan posting < 4/bulan
- Notification system terintegrasi
- Runnable via command atau dashboard button

---

## 📦 Installation

### 1. Clone Repository
```bash
cd c:\laragon\www
```

### 2. Install Dependencies
```bash
composer install
npm install
```

### 3. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup
```bash
php artisan migrate
php artisan db:seed
```

### 5. Build Frontend
```bash
npm run build
# atau untuk development:
npm run dev
```

### 6. Run Server
```bash
php artisan serve
# Akses: http://localhost:8000
```

---

## 📊 Database Schema

### Key Tables:
- **users** - ASN, PIMPINAN, ADMIN accounts
- **postings** - Media sosial postings
- **posting_engagements** - Engagement data (likes, comments, shares)
- **evaluations** - Monthly evaluation records
- **notifications** - System notifications
- **wilayahs** - Territories
- **opds** - Organizational units
- **pilars** - Posting categories

---

## 🔄 Workflow

1. **ASN membuat posting** → Otomatis verified & tersimpan
2. **System hitung posting bulanan** → Stats di dashboard
3. **Auto-flagging jalan** → Flag ASN dengan posting < 4
4. **Pimpinan evaluasi** → Feedback & notes untuk ASN
5. **ASN menerima notifikasi** → Bisa clear dari dashboard

---

## 📝 Notes

- Target posting diperhitungkan berdasarkan **`posted_date`** (bukan `created_at`)
- Progress bar capped di 100% untuk performa visual yang konsisten
- Auto-flagging bisa di-trigger via command: `php artisan posting:flag-underperforming`
- Semua aktivitas terlog untuk audit trail

---

## 📞 Support & Contact

Untuk pertanyaan atau issue, hubungi:
- **Dinas Komunikasi dan Informatika Surabaya**

---

**Versi**: 1.0  
**Tahun**: 2026  
**Status**: Aktif
