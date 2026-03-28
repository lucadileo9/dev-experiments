# PHP Notes App

A lightweight, educational **notes management application** built with pure PHP, featuring user authentication, session management with flash data, and a clean MVC architecture. This project demonstrates modern PHP practices and design patterns.

## 🎯 Features

- **User Authentication** — Register, login, and logout with secure password hashing
- **Notes Management** — Create, read, update, and delete personal notes
- **User Sessions** — Secure session handling with flash data for one-time messages
- **Responsive UI** — Modern frontend built with Tailwind CSS
- **Form Validation** — Email and password validation with custom error messages
- **Authorization** — Middleware-based access control (authenticated/guest routes)
- **PRG Pattern** — Post-Redirect-Get pattern for clean form handling

## 🏗️ Architecture

### Project Structure

```
notes-app/
├── Core/                          # Core framework classes
│   ├── App.php                   # Service container
│   ├── Authenticator.php         # Authentication logic
│   ├── Database.php              # Database wrapper
│   ├── Router.php                # Route handler
│   ├── Session.php               # Session & flash data manager
│   ├── Validator.php             # Form validation
│   ├── functions.php             # Helper functions
│   └── Middleware/               # Route middleware
│       ├── Authenticated.php     # Require logged-in user
│       └── Guest.php             # Require logged-out user
├── Http/
│   ├── Forms/
│   │   └── LoginForm.php         # Login form validation
│   └── controllers/              # Application controllers
│       ├── index.php
│       ├── about.php
│       ├── contact.php
│       ├── notes/                # Notes CRUD controllers
│       ├── sessions/             # Auth controllers (login/logout)
│       └── users/                # User registration controller
├── views/                        # HTML templates
│   ├── partials/                 # Reusable components
│   │   ├── head.php
│   │   ├── header.php
│   │   └── footer.php
│   ├── notes/                    # Notes views
│   ├── sessions/                 # Auth views
│   └── users/                    # Registration views
├── public/
│   └── index.php                 # Application entry point
├── bootstrap.php                 # Framework initialization
├── routes.php                    # Route definitions
└── config.php                    # Configuration

```

## 📋 Requirements

- **PHP 7.4+** (or higher)
- **PDO MySQL** — Database abstraction layer
- **MySQL 5.7+** — Database server
- **Git** — Version control
- **Composer** (optional) — Dependency management

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/lucadileo9/php-tutorial.git
cd php-tutorial/notes-app
```

### 2. Configure the Database

Create a `.env` file or update `config.php` with your database credentials:

```php
define('DB_CONNECTION', 'mysql');
define('DB_HOST', '127.0.0.1');
define('DB_PORT', 3306);
define('DB_DATABASE', 'notes_app');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
```

### 3. Create the Database

```sql
CREATE DATABASE notes_app;
USE notes_app;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Notes table
CREATE TABLE notes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### 4. Start Development Server

```bash
php -S localhost:8000 -t public/
```

Visit `http://localhost:8000` in your browser.

## 📖 Usage

### Authentication

1. **Register** — Go to `/registration` and create an account
2. **Login** — Go to `/login` with your credentials
3. **Logout** — Click the logout button in the header

### Notes Management

- **Create** — Click "Create Note" from the notes page
- **View All** — Go to `/notes` to see all your notes
- **Edit** — Click edit on any note to update it
- **Delete** — Click delete to remove a note

### Public Pages

- `/` — Home page (shows different content for logged-in vs guest users)
- `/about` — About page
- `/contact` — Contact page

## 📄 License

This project is open source and available under the MIT License.

## 👨‍💻 Author

**Luca Di Leo**  
GitHub: [@lucadileo9](https://github.com/lucadileo9)

## 📚 Learning Resources

This project is part of a PHP tutorial series. Done on Laracasts, it covers building a full-featured application from scratch using pure PHP. The tutorial is designed to teach modern PHP development practices without relying on a framework.
It demonstrates:

- Pure PHP (no framework)
- MVC Architecture
- OOP Principles
- Design Patterns
- Security Best Practices
- Database Management
- Frontend Integration (Tailwind CSS)

---

**Happy coding!** 🚀
