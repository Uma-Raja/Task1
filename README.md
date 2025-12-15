# Task1 – Authentication System

A full-stack authentication and user profile management system built using **PHP**, **MySQL**, **MongoDB**, and **Redis**. This project demonstrates secure user registration, login, session/token handling, profile management, and logout functionality.

---

## 🚀 Features

* User Registration with validation
* Secure Login & Logout
* Token-based Authentication (Bearer Token)
* Session & Token storage using **Redis**
* User profile data stored in **MongoDB**
* User credentials stored securely in **MySQL**
* Protected profile access (authorization required)
* Update profile details

---

## 🛠️ Tech Stack

* **Backend:** PHP 8+
* **Frontend:** HTML, CSS, Bootstrap 5, JavaScript (jQuery)
* **Database:**

  * MySQL – user authentication data
  * MongoDB – user profile data
  * Redis – session & token storage
* **Server:** Apache (XAMPP)
* **Version Control:** Git & GitHub

---

## 📂 Project Structure

```
Task1/
├── html/
│   ├── login.html
│   ├── register.html
│   └── profile.html
│
├── php/
│   ├── config.php        # Database & service connections (ignored in Git)
│   ├── register.php
│   ├── login.php
│   ├── profile.php
│   └── logout.php
│
├── js/
│   ├── login.js
│   ├── register.js
│   └── profile.js
│
├── css/
│   └── style.css
│
├── .gitignore
└── README.md
```

---

## ⚙️ Setup Instructions

### 1️⃣ Clone the repository

```bash
git clone https://github.com/Uma-Raja/Task1.git
```

### 2️⃣ Move project to XAMPP htdocs

```
D:/xampp/htdocs/Task1
```

### 3️⃣ Configure databases

#### MySQL

* Create a database named `Task1`
* Create a `users` table with required fields

#### MongoDB

* Ensure MongoDB service is running
* Database used: `Task1_db`
* Collection: `profiles`

#### Redis

* Ensure Redis server is running on port `6379`

### 4️⃣ Configure `config.php`

Create `php/config.php` and add your local credentials:

```php
$db_host = '127.0.0.1';
$db_name = 'Task1';
$db_user = 'root';
$db_pass = '';
```

> ⚠️ `config.php` is intentionally ignored from Git for security reasons.

---

## ▶️ How to Run

1. Start **Apache** and **MySQL** from XAMPP
2. Start **MongoDB** service
3. Start **Redis** server
4. Open browser and go to:

```
http://localhost/Task1/html/login.html
```

---

## 🔐 Authentication Flow

1. User registers → MySQL + MongoDB
2. User logs in → token generated & stored in Redis
3. Token saved in browser `localStorage`
4. Profile access requires valid token
5. Logout deletes token from Redis

---

## 📌 Future Improvements

* Email verification
* Password reset
* Profile picture upload
* UI/UX improvements
* Role-based access (Admin/User)
* Deployment to cloud server

---

## 👤 Author

**Uma Raja**
GitHub: [https://github.com/Uma-Raja](https://github.com/Uma-Raja)

---

## ⭐ Acknowledgment

This project was built as a learning-focused full-stack authentication system, integrating multiple backend technologies and real-world debugging scenarios.

---

⭐ If you like this project, feel free to star the repository!
