# Laravel Dual-Guard Authentication System

A comprehensive Laravel application with a sophisticated dual authentication system for staff and students. Features custom guard implementations, email verification, password management, and modern frontend tooling.

## 🚀 Core Features

### **Dual Guard Authentication System**
- **Staff Authentication**: Separate login system for staff members
- **Student Authentication**: Independent login system for students
- **Guard Selection UI**: Radio button selection on login forms
- **Separate Database Tables**: Isolated login tables for each guard
- **Role-based Access**: Staff roles (admin, coordinator, staff) with different permissions

### **Complete Authentication Flow**
- **Registration**: Student-only registration with automatic login table creation
- **Login**: Guard-specific authentication with username/password
- **Email Verification**: Mandatory email verification before dashboard access
- **Password Management**: Forgot password, reset, and update functionality
- **Session Management**: Secure session handling with guard isolation
- **Logout**: Complete session termination across all guards

### **Security Features**
- **Email Verification**: Required for all accounts using `MustVerifyEmail`
- **Password Confirmation**: Additional verification for sensitive actions
- **Audit Logging**: Comprehensive activity tracking with `Auditable` trait
- **CSRF Protection**: Built-in Laravel protection
- **Form Validation**: Server-side validation with user-friendly error messages
- **Secure Password Hashing**: Laravel's bcrypt implementation

### **Modern Frontend Stack**
- **Vite Build Tool**: Fast asset compilation and hot module replacement
- **Bootstrap 5**: Responsive, mobile-first CSS framework
- **jQuery & JavaScript Libraries**: Enhanced interactivity
- **Select2**: Advanced select boxes
- **DataTables**: Feature-rich table displays
- **Chart.js**: Data visualization
- **SweetAlert2**: Beautiful alert dialogs
- **FullCalendar**: Event scheduling

## 📋 System Requirements

- **PHP**: 8.2 or higher
- **Composer**: 2.0 or higher
- **Node.js**: 18.0 or higher
- **NPM**: 8.0 or higher
- **Database**: MySQL 5.7+, PostgreSQL, or SQLite
- **Web Server**: Apache/Nginx with mod_rewrite
- **Extensions**: BCMath, Ctype, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML

## 🛠️ Installation & Setup

### **1. Clone and Configure**
```bash
git clone <repository-url>
cd customGuard
cp .env.example .env
php artisan key:generate

2. Configure Environment

Edit .env file with your settings:
env

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

3. Install Dependencies
bash

composer install
npm install

4. Database Setup
bash

php artisan migrate
# Optional: Seed with sample data
php artisan db:seed

5. Build Assets
bash

# Development with hot reload
npm run dev

# Production build
npm run build

6. Serve Application
bash

php artisan serve

Visit http://localhost:8000 in your browser.
🏗️ Architecture Overview
Authentication Flow
text

User → Login Page → Select Guard (Staff/Student) → Enter Credentials
    ↓
Authenticate → Check Email Verification → Redirect to Dashboard
    ↓
Logout → Clear All Sessions → Redirect to Home

Database Schema
text

┌─────────────────┐      ┌─────────────────┐
│     staff       │      │    students     │
├─────────────────┤      ├─────────────────┤
│ id              │      │ id              │
│ staff_id (UK)   │      │ student_id (UK) │
│ name            │      │ name            │
│ email (UK)      │      │ email (UK)      │
│ password        │      │ password        │
│ department      │      │ program         │
│ role            │      │ intake_year     │
│ phone           │      │ phone           │
│ status          │      │ status          │
│ timestamps      │      │ timestamps      │
└─────────────────┘      └─────────────────┘
         ↑                        ↑
         │                        │
┌─────────────────┐      ┌─────────────────┐
│     logins      │      │ student_logins  │
├─────────────────┤      ├─────────────────┤
│ id              │      │ id              │
│ user_id (FK)    │      │ student_id (FK) │
│ username (UK)   │      │ username (UK)   │
│ password        │      │ password        │
│ remember_token  │      │ remember_token  │
│ timestamps      │      │ timestamps      │
│ soft_deletes    │      │ soft_deletes    │
└─────────────────┘      └─────────────────┘

Directory Structure
text

app/
├── Http/
│   ├── Controllers/
│   │   └── Auth/
│   │       ├── AuthenticatedSessionController.php  # Login/logout
│   │       ├── ConfirmablePasswordController.php   # Password confirmation
│   │       ├── EmailVerificationNotificationController.php
│   │       ├── EmailVerificationPromptController.php
│   │       ├── NewPasswordController.php           # Password reset
│   │       ├── PasswordController.php              # Password update
│   │       ├── PasswordResetLinkController.php     # Forgot password
│   │       ├── RegisteredUserController.php        # Registration
│   │       └── VerifyEmailController.php           # Email verification
│   ├── Middleware/
│   │   ├── Auth.php                # General authentication
│   │   ├── AuthVerified.php        # Email verification check
│   │   ├── AuthenticateStaff.php   # Staff-only access
│   │   ├── AuthenticateStudent.php # Student-only access
│   │   └── NoAuth.php              # Public-only access
│   └── Requests/
│       └── Auth/LoginRequest.php   # Custom login request
├── Models/
│   ├── Login.php          # Staff authentication model
│   ├── Staff.php          # Staff model
│   ├── StudentLogin.php   # Student authentication model
│   └── Student.php        # Student model
├── Traits/
│   └── Auditable.php      # Audit logging
└── Helpers/
    └── UserGuardHelper.php # Guard utilities

resources/views/auth/
├── login.blade.php
├── register.blade.php
├── forgot-password.blade.php
├── reset-password.blade.php
├── verify-email.blade.php
└── confirm-password.blade.php

🔐 Authentication Controllers
1. Login Controller (AuthenticatedSessionController)

    Handles both staff and student login

    Validates guard selection (login_type)

    Attempts authentication with selected guard

    Redirects to appropriate dashboard based on guard

    Logout clears all guard sessions

Key Methods:
php

public function store(Request $request)  // Handle login
public function destroy(Request $request) // Handle logout

2. Registration Controller (RegisteredUserController)

    Student-only registration system

    Creates both Student and StudentLogin records

    Automatically logs in after registration

    Triggers email verification event

3. Password Management Controllers

    PasswordResetLinkController: Forgot password functionality

    NewPasswordController: Password reset handling

    PasswordController: Authenticated password update

    ConfirmablePasswordController: Password confirmation for sensitive actions

4. Email Verification Controllers

    EmailVerificationPromptController: Show verification notice

    VerifyEmailController: Process verification link

    EmailVerificationNotificationController: Resend verification email

🎨 Frontend Implementation
Authentication Views

All authentication views follow a consistent Bootstrap card layout:
blade

<!-- Example: Login Form -->
<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="card">
        <div class="card-header"><h3>Sign In</h3></div>
        <div class="card-body">
            <!-- Guard Selection -->
            <div class="btn-group" role="group">
                <input type="radio" name="login_type" value="staff" id="staff_radio">
                <label class="btn btn-outline-primary" for="staff_radio">Staff</label>
                <input type="radio" name="login_type" value="student" id="student_radio">
                <label class="btn btn-outline-primary" for="student_radio">Student</label>
            </div>
            <!-- Form Fields -->
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Log in</button>
        </div>
    </div>
</form>

JavaScript Integration
javascript

// resources/js/app.js
import 'bootstrap';
import 'jquery';
import 'select2';
import 'datatables.net-bs5';
import 'sweetalert2';
// Additional imports...

Vite Configuration
javascript

// vite.config.js
export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/scss/app.scss',
                'resources/css/app.css',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
    ],
    build: {
        chunkSizeWarningLimit: 4000,
    },
});

🛡️ Security Implementation
Middleware Protection
php

// Staff-only routes
Route::middleware(['auth.staff', 'authverified'])->group(function () {
    Route::get('/staff/dashboard', ...);
});

// Student-only routes  
Route::middleware(['auth.student', 'authverified'])->group(function () {
    Route::get('/student/dashboard', ...);
});

// Public-only routes
Route::middleware('noauth')->group(function () {
    Route::get('/', ...);
    Route::get('/login', ...);
});

Password Reset Flow
text

1. User selects guard → enters username
2. System looks up email from related model
3. Sends reset link to that email
4. User clicks link → selects guard → enters new password
5. Password updated in login table

Email Verification

    Custom hasVerifiedEmail() method checks related model

    Verification status stored in Staff/Student models

    Custom markEmailAsVerified() updates related model

    Verification required before dashboard access

📊 Database & Models
Staff Model (App\Models\Staff)
php

class Staff extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = ['name', 'email', 'password', 'staff_id', 'department', 'role'];
    protected $hidden = ['password', 'remember_token'];
    
    public function isAdmin(): bool {
        return $this->role === 'admin';
    }
}

Student Model (App\Models\Student)
php

class Student extends Authenticatable  
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $fillable = ['name', 'email', 'password', 'student_id', 'program', 'intake_year'];
    protected $hidden = ['password', 'remember_token'];
}

Login Models (Login & StudentLogin)

    Implement MustVerifyEmail interface

    Override authentication methods for username-based login

    Custom email verification methods that delegate to related models

    Use Auditable trait for logging

🔧 Configuration
Auth Configuration (config/auth.php)
php

'guards' => [
    'staff' => [
        'driver' => 'session',
        'provider' => 'logins',
    ],
    'student' => [
        'driver' => 'session',  
        'provider' => 'student_logins',
    ],
],

'providers' => [
    'logins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Login::class,
    ],
    'student_logins' => [
        'driver' => 'eloquent',
        'model' => App\Models\StudentLogin::class,
    ],
],

Password Broker Configuration
php

'passwords' => [
    'staff' => [
        'provider' => 'logins',
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
    'student' => [
        'provider' => 'student_logins', 
        'table' => 'password_reset_tokens',
        'expire' => 60,
        'throttle' => 60,
    ],
],

🚦 Routing System
Public Routes (routes/web.php)
php

Route::middleware('noauth')->group(function () {
    Route::get('/', ...); // Welcome page
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    // Password reset routes...
});

Protected Routes
php

// Email verification routes
Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');

// Staff dashboard
Route::middleware(['auth.staff', 'authverified'])->group(function () {
    Route::get('/staff/dashboard', ...);
});

// Student dashboard  
Route::middleware(['auth.student', 'authverified'])->group(function () {
    Route::get('/student/dashboard', ...);
});

🧪 Testing
Creating Test Users
bash

# Create a staff member
php artisan tinker
>>> $staff = App\Models\Staff::create([
...     'staff_id' => 'STF001',
...     'name' => 'John Doe',
...     'email' => 'john@example.com',
...     'password' => bcrypt('password'),
...     'department' => 'IT',
...     'role' => 'admin'
... ]);

>>> $login = App\Models\Login::create([
...     'user_id' => $staff->id,
...     'username' => 'johndoe',
...     'password' => bcrypt('password')
... ]);

Testing Authentication
php

// Test staff login
auth('staff')->attempt(['username' => 'johndoe', 'password' => 'password']);

// Test student login  
auth('student')->attempt(['username' => 'student123', 'password' => 'password']);

// Get authenticated user
$user = UserGuardHelper::auth_user();
$guard = UserGuardHelper::auth_guard();

🚀 Deployment
Production Build
bash

# Optimize for production
npm run build
php artisan config:cache
php artisan route:cache  
php artisan view:cache

# Set proper permissions
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

Environment Configuration
env

APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Secure session settings
SESSION_DRIVER=database
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Production mail settings
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-server.com
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls

Queue Workers
bash

# Process email queues
php artisan queue:work --daemon

# Or use Supervisor
sudo supervisorctl start laravel-worker:*

🐛 Troubleshooting
Common Issues & Solutions
1. Login Not Working
bash

# Check user exists
php artisan tinker
>>> App\Models\Login::where('username', 'testuser')->first()

# Check password hash
>>> Hash::check('password', $user->password)

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

2. Email Verification Issues
bash

# Check mail configuration
php artisan tinker
>>> config('mail')

# Test email sending
php artisan tinker
>>> Mail::raw('Test', function($message) {
...     $message->to('test@example.com')->subject('Test');
... });

# Check queue workers
sudo supervisorctl status

3. Password Reset Problems
bash

# Check password reset tokens
SELECT * FROM password_reset_tokens WHERE email LIKE '%@%';

# Verify broker configuration
php artisan tinker
>>> Password::broker('staff')->getRepository();

4. Asset Loading Issues
bash

# Rebuild assets
npm run build

# Check Vite manifest
ls -la public/build/

# Clear browser cache
Ctrl + Shift + R (Hard reload)

Debug Commands
bash

# View all routes
php artisan route:list

# Check environment
php artisan env

# View logs
tail -f storage/logs/laravel.log

# Test database connection
php artisan db:show

🔄 Maintenance
Regular Tasks

    Backup Database: Weekly automated backups

    Clear Caches: After configuration changes

    Update Dependencies: Monthly security updates

    Review Logs: Daily error log monitoring

    Test Email: Weekly email functionality test

Security Updates
bash

# Update Laravel
composer update laravel/framework

# Update npm packages
npm update

# Check security advisories
composer audit
npm audit

🤝 Contributing

    Fork the repository

    Create feature branch: git checkout -b feature/new-feature

    Commit changes: git commit -m 'Add new feature'

    Push to branch: git push origin feature/new-feature

    Open Pull Request

Coding Standards

    Follow PSR-12 coding standards

    Use meaningful variable names

    Add comments for complex logic

    Write tests for new features

    Update documentation accordingly

📄 License

This project is licensed under the MIT License - see the LICENSE file for details.
🙏 Acknowledgments

    Laravel - The PHP Framework For Web Artisans

    Laravel Breeze - Authentication scaffolding

    Bootstrap - Frontend component library

    Vite - Next-generation frontend tooling

    All contributors and the open-source community

Support: For issues and questions, please open an issue on GitHub.

Security Vulnerabilities: Please email security@example.com instead of using the issue tracker.
text


## How to Download/Save:

### Option 1: Copy and Paste
1. Select all the text above (Ctrl+A or Cmd+A)
2. Copy (Ctrl+C or Cmd+C)
3. Create a new file named `README.md` in your project root
4. Paste the content (Ctrl+V or Cmd+V)
5. Save the file

### Option 2: Save from Browser
1. Right-click on this chat
2. Select "Save as..." or "Download"
3. Save as `README.md`
4. Move to your project directory

### Option 3: Terminal (Linux/Mac)
```bash
# Copy this entire response to a file
echo '[paste the entire content here]' > README.md

Option 4: Create with Command Line
bash

# Create the file
touch README.md

# Open in editor and paste
nano README.md
# or
vim README.md
# or
