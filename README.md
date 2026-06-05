# EduTrack — ITEC 106 Final Project

> **Laravel Web Application — Class Schedule Management System**
> White & Green theme inspired by CvSU aesthetics

---

## 📋 Project Overview

**EduTrack** is a full-featured Laravel web application that covers:

| Requirement | Status |
|---|---|
| ✅ Authentication (Login & Registration) | Complete |
| ✅ CRUD — Users Management | Complete |
| ✅ CRUD — Class Schedule (2nd Module) | Complete |
| ✅ Dashboard with Charts/Graphs (Chart.js) | Complete |
| ✅ Navigation (Sidebar + Top Navbar) | Complete |
| ✅ Session Handling | Complete |
| ✅ Toast Notifications | Complete |
| ✅ User Profile with Avatar Upload | Complete |
| ✅ Bootstrap 5 UI/UX | Complete |
| ✅ MVC Architecture (Clean Code) | Complete |

---

## 🚀 Setup Instructions

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL / MariaDB
- Node.js (optional, for Vite)
- A local server: XAMPP / Laragon / Herd

---

### Step 1 — Clone / Download the project

```bash
# If using Git
git clone https://github.com/your-username/edutrack.git
cd edutrack

# Or extract the ZIP and navigate to the folder
cd edutrack
```

---

### Step 2 — Install PHP dependencies

```bash
composer install
```

---

### Step 3 — Environment setup

```bash
# Copy the example env file
cp .env.example .env

# Generate the application key
php artisan key:generate
```

---

### Step 4 — Configure your database

Open `.env` and update these values:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edutrack_db     # Create this database first in phpMyAdmin
DB_USERNAME=root
DB_PASSWORD=                # Your MySQL password
```

**Create the database** in phpMyAdmin or terminal:
```sql
CREATE DATABASE edutrack_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

### Step 5 — Run migrations and seed demo data

```bash
# Run migrations (creates all tables)
php artisan migrate

# Seed with demo data (optional but recommended)
php artisan db:seed
```

Demo credentials after seeding:
| Email | Password |
|---|---|
| admin@edutrack.com | password |
| juan@edutrack.com | password |

---

### Step 6 — Create storage symlink (for profile picture uploads)

```bash
php artisan storage:link
```

---

### Step 7 — Start the development server

```bash
php artisan serve
```

Visit: **http://127.0.0.1:8000**

---

## 🌐 Web Hosting on cPanel / Shared Hosting

### Step 1 — Build for production
```bash
# Update .env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com
```

### Step 2 — Upload files
1. Upload ALL project files to your hosting **except** the `public` folder
2. Upload ONLY the contents of `public/` to `public_html/`
3. Edit `public_html/index.php`:

```php
// Change these two lines:
require __DIR__.'/../vendor/autoload.php';
// to point to your actual path, e.g.:
require __DIR__.'/../edutrack/vendor/autoload.php';

$app = require_once __DIR__.'/../edutrack/bootstrap/app.php';
```

### Step 3 — Set up the database
1. Create a MySQL database in cPanel
2. Update `.env` with cPanel DB credentials
3. Run migrations via SSH or a migration script

### Step 4 — Storage link
```bash
php artisan storage:link
# or manually symlink public/storage → storage/app/public
```

---

## 📁 Project Structure

```
edutrack/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php          # Login, Register, Logout
│   │   │   ├── DashboardController.php     # Charts & stats
│   │   │   ├── UserController.php          # Users CRUD
│   │   │   ├── ScheduleController.php      # Class Schedule CRUD
│   │   │   └── ProfileController.php       # Profile & avatar
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       └── RedirectIfAuthenticated.php
│   └── Models/
│       ├── User.php
│       └── Schedule.php
│
├── database/
│   ├── migrations/
│   │   ├── create_users_table.php
│   │   └── create_schedules_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
│
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── app.blade.php               # Main layout (sidebar + topnav)
│       │   └── guest.blade.php             # Auth layout (split panel)
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       ├── dashboard/
│       │   └── index.blade.php             # Charts dashboard
│       ├── users/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── schedules/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       └── profile/
│           └── show.blade.php
│
└── routes/
    └── web.php
```

---

## ✨ Features Breakdown

### Authentication
- Registration with full name, email, password + confirmation
- Form validation with inline error messages
- Login with email/password, remember me support
- Toast notification on register & login
- Secure logout with session invalidation

### Dashboard
- **Stat cards**: Total users, My schedules, New users this week, Unique subjects
- **Bar chart**: Schedules per day of the week (Chart.js)
- **Doughnut chart**: Subject distribution
- **Bar chart**: Schedules by semester
- **Recent schedules table** with color labels
- Live clock in top navbar

### Users Management (CRUD)
- Paginated table with search
- Add user (toast notification)
- Edit user name & email
- Delete user (with confirmation dialog)
- Prevents deleting your own account

### Class Schedule (CRUD)
- Paginated table with search + day filter
- Add schedule: subject name, code, instructor, room, day, time, semester, school year, color label
- Edit schedule with all fields
- Delete with confirmation
- Color-coded labels for visual distinction
- Schedules scoped to logged-in user only

### User Profile
- Display name, email, phone, gender, address, join date
- Edit all profile information
- Change password (optional)
- Profile picture upload (JPG/PNG/WEBP, max 2MB)
- Auto-initials avatar fallback

### UI/UX
- Bootstrap 5 throughout
- Sticky sidebar navigation with active state highlighting
- Responsive (mobile sidebar with overlay)
- Toast notifications for all CRUD actions
- Green + white CvSU-inspired color palette
- Color swatch picker for schedule labels
- Password show/hide toggles

---

## 🎨 Color Palette

| Name | Hex |
|---|---|
| Primary Dark | `#114d2b` |
| Primary | `#1a6b3c` |
| Primary Light | `#28a164` |
| Accent | `#4caf78` |
| Accent Soft | `#e8f5ee` |
| Sidebar BG | `#0f3d22` |

---

## 📊 Rubric Coverage

| Criteria | Weight | Coverage |
|---|---|---|
| Functionality | 40% | All CRUD, Auth, Profile, Charts |
| UI/Design | 15% | Bootstrap 5, Custom CSS, Responsive |
| Use of Laravel Features | 15% | Eloquent ORM, Blade, Middleware, Validation, Storage |
| Completeness | 10% | All 7 requirements met |
| Web Hosted | 10% | Deploy guide included above |
| Code Structure | 10% | MVC, ResourceController, clean code |

---

*Built with ❤️ using Laravel 11 + Bootstrap 5 + Chart.js*
