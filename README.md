# My PHP Project
# 📝 PHP Blog Application

A fully functional blog web application built with PHP, MySQL, and Bootstrap.

---

## 🚀 Features

- **User Authentication** — Register, login, logout with secure password hashing
- **CRUD Operations** — Create, Read, Update, Delete blog posts
- **Search Functionality** — Search posts by title or content
- **Pagination** — Browse posts with page navigation
- **User Roles** — Admin and Editor role-based access control
- **Security** — SQL injection prevention, XSS protection, form validation
- **Dashboard** — View stats and recent posts
- **Responsive UI** — Built with Bootstrap 5

---

## 🛠️ Tech Stack

| Technology | Usage |
|---|---|
| PHP | Server-side scripting |
| MySQL (MariaDB) | Database |
| PDO | Database connection |
| Bootstrap 5 | Frontend UI |
| Git & GitHub | Version control |
| XAMPP | Local development server |

---

## 📁 Project Structure

```
my-php-project/
├── config.php        # Database connection and session setup
├── index.php         # Home page - list all posts with search & pagination
├── create.php        # Create a new blog post
├── edit.php          # Edit an existing blog post
├── delete.php        # Delete a blog post (admin only)
├── register.php      # User registration
├── login.php         # User login
├── logout.php        # User logout
├── dashboard.php     # Dashboard with stats and recent posts
└── README.md         # Project documentation
```

---

## 🗄️ Database Schema

### Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor'
);
```

### Posts Table
```sql
CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## ⚙️ Installation

### Prerequisites
- XAMPP (Apache + MySQL)
- PHP 7.4+
- Git

### Steps

1. **Clone the repository**
```bash
git clone https://github.com/theeananya-creator/my-php-project.git
```

2. **Move to XAMPP htdocs folder**
```bash
mv my-php-project /c/xampp/downloads/htdocs/
```

3. **Start XAMPP services**
   - Open XAMPP Control Panel
   - Start Apache and MySQL

4. **Create the database**
   - Open `http://localhost/phpmyadmin`
   - Run the following SQL:
```sql
CREATE DATABASE blog;

USE blog;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'editor') DEFAULT 'editor'
);

CREATE TABLE posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

5. **Configure database connection**
   - Open `config.php`
   - Update the following if needed:
```php
$host = '127.0.0.1';
$port = '3307';
$dbname = 'blog';
$username = 'root';
$password = '';
```

6. **Open the application**
```
http://localhost/my-php-project/register.php
```

---

## 👤 User Roles

| Role | Create Post | Edit Post | Delete Post |
|---|---|---|---|
| Admin | ✅ | ✅ | ✅ |
| Editor | ✅ | ✅ | ❌ |

> The first registered user is set as **admin** by default.
> All subsequent users are assigned the **editor** role.

---

## 🔒 Security Measures

- **Prepared Statements** — All database queries use PDO prepared statements to prevent SQL injection
- **Password Hashing** — Passwords are hashed using `password_hash()` with bcrypt
- **XSS Protection** — All output is sanitized using `htmlspecialchars()`
- **Session Management** — Secure session handling for user login states
- **Server-side Validation** — All forms validated on the server
- **Client-side Validation** — HTML5 validation for better UX
- **Role-based Access Control** — Only admins can delete posts

---

## 📸 Pages Overview

| Page | URL | Description |
|---|---|---|
| Register | `/register.php` | Create a new account |
| Login | `/login.php` | Login to your account |
| Home | `/index.php` | View all posts with search & pagination |
| Dashboard | `/dashboard.php` | View stats and recent posts |
| Create Post | `/create.php` | Add a new blog post |
| Edit Post | `/edit.php?id=X` | Edit an existing post |

---

## 📋 Tasks Completed

| Task | Description |
|---|---|
| Task 1 | Development Environment Setup |
| Task 2 | CRUD Blog App with User Authentication |
| Task 3 | Search, Pagination and Bootstrap UI |
| Task 4 | Security Enhancements and User Roles |
| Task 5 | Final Project Integration and Dashboard |

---

## 👩‍💻 Author

**Ananya Konda**
- GitHub: [@theeananya-creator](https://github.com/theeananya-creator)

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).