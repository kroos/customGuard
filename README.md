# Laravel Dual‑Guard Authentication System

A clean and professional documentation for a Laravel application featuring a dual‑guard authentication system for **staff** and **students**, complete authentication flows, security layers, email verification, password resets, and a modern frontend build pipeline.

---

## 🚀 Core Features

### **Dual Guard Authentication**
- **Staff Guard** – Dedicated login, roles, and access control  
- **Student Guard** – Independent login and registration
- **Guard Switcher** – Radio selectors for choosing login type
- **Separate Authentication Tables**
- **Staff Roles** (admin, coordinator, staff)

---

## 🔐 Authentication Flow

- **Registration** (students only)
- **Guard‑specific Login** with username/password
- **Email Verification** required before dashboard access
- **Password Reset & Update** per guard
- **Session Isolation**
- **Full Logout** across all guards

---

## 🛡 Security Features

- `MustVerifyEmail` applied to login models  
- Password confirmation for sensitive actions  
- Audit logging with an `Auditable` trait  
- CSRF protection  
- Strong validation rules  
- Bcrypt password hashing  

---

## 🧰 Frontend Stack

- **Vite** for asset bundling  
- **Bootstrap 5**  
- **jQuery**  
- **Select2**  
- **DataTables**  
- **Chart.js**  
- **SweetAlert2**  
- **FullCalendar**

---

## 📋 Requirements

- PHP ≥ 8.2  
- Composer ≥ 2  
- Node ≥ 18  
- MySQL / PostgreSQL / SQLite  
- Required PHP extensions: `BCMath`, `Ctype`, `JSON`, `Mbstring`, `OpenSSL`, etc.

---

## 🛠 Installation

### 1. Clone & Prepare
```bash
git clone <repository-url>
cd customGuard
cp .env.example .env
php artisan key:generate
```

### 2. Configure Environment

```env
APP_NAME="Laravel Dual Guard"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_dual_guard
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AUTH_GUARD=staff
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Migrate & Seed
```bash
php artisan migrate
php artisan db:seed   # optional
```

### 5. Build Assets

Development:
```bash
npm run dev
```

Production:
```bash
npm run build
```

### 6. Serve Application
```bash
php artisan serve
```

---

## 🏗 System Architecture

### Authentication Flow
```
User → Select Guard → Login → Email Verification → Dashboard → Logout
```

### Database Structure
```
staff             students
staff_logins      student_logins
```

Each guard has:
- Login table (credentials)  
- User table (profile & email verification)

---

## 📁 Directory Structure (Important Files)

```
app/
├── Http/Controllers/Auth/
├── Middleware/
├── Models/
├── Traits/Auditable.php
└── Helpers/UserGuardHelper.php

resources/views/auth/
```

---

## 🔐 Key Controllers

### Login Controller
- Handles staff & student login  
- Redirects per guard  
- Clears all sessions on logout  

### Registration
- Creates Student + StudentLogin  
- Sends verification email  

### Password Controllers
- Forgot password  
- Reset password  
- Update password  
- Confirm password  

### Email Verification
- Verification prompt  
- Handle verification link  
- Resend verification email  

---

## 🔧 Auth Configuration

### Guards
```php
'guards' => [
    'staff' => ['driver' => 'session','provider' => 'logins'],
    'student' => ['driver' => 'session','provider' => 'student_logins'],
],
```

### Providers
```php
'providers' => [
    'logins' => ['driver' => 'eloquent','model' => App\Models\Login::class],
    'student_logins' => ['driver' => 'eloquent','model' => App\Models\StudentLogin::class],
],
```

### Password Brokers
```php
'passwords' => [
    'staff' => ['provider' => 'logins'],
    'student' => ['provider' => 'student_logins'],
],
```

---

## 🚦 Routing

### Public
```php
Route::middleware('noauth')->group(function () {
    Route::get('/', ...);
    Route::get('login', ...);
    Route::post('login', ...);
    Route::get('register', ...);
});
```

### Protected
```php
Route::middleware(['auth.staff','authverified'])->get('/staff/dashboard', ...);
Route::middleware(['auth.student','authverified'])->get('/student/dashboard', ...);
```

---

## 🧪 Testing

### Create sample staff
```bash
php artisan tinker
$staff = App\Models\Staff::create([...]);
$login = App\Models\Login::create([...]);
```

---

## 🚀 Deployment

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Secure sessions
```env
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

---

## 🐛 Troubleshooting

### Login Issues
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Check password
```php
Hash::check('password', $user->password)
```

### Verify email sending
```php
Mail::raw('Test', fn($m) => $m->to('you@example.com'));
```

---

## 🤝 Contributing

1. Fork  
2. Create branch  
3. Commit  
4. PR  

---

## 📄 License

MIT License.

---

## 🙏 Acknowledgements
Laravel, Breeze, Bootstrap, Vite, and every OSS contributor.
