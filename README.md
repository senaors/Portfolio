# Portfolio — Nur Sena Örs

A full-stack web portfolio built with **HTML5, CSS3, JavaScript, PHP & MySQL** —

🌐 **Live Demo:** [your-live-link-here]  
📁 **GitHub:** [github.com/senaors/Portfolio](https://github.com)

---

## ✨ Features

- **Responsive Design** — Mobile-first layout using CSS Flexbox & Grid
- **Dark / Light Mode** — Toggleable theme persisted via cookies
- **Dynamic Projects** — Fetched from MySQL database via AJAX (no page reload)
- **Contact Form** — JavaScript validation + server-side PHP + saved to MySQL
- **Admin Dashboard** — Session-based login, add/edit/delete projects, view messages
- **Semantic HTML5** — Proper use of `<nav>`, `<section>`, `<footer>`, `<form>`, tables
- **Scroll Animations** — IntersectionObserver-based reveal effects

---

## 🗂️ Project Structure

```
portfolio/
├── index.php              # Main entry point (PHP + HTML)
├── css/
│   └── style.css          # External stylesheet (responsive, dark mode)
├── js/
│   └── main.js            # DOM manipulation, AJAX, form validation, cookies
├── php/
│   ├── db.php             # Database connection
│   ├── get_projects.php   # AJAX endpoint — returns projects as JSON
│   └── contact.php        # AJAX endpoint — saves contact messages
├── admin/
│   ├── login.php          # Admin login (PHP Sessions)
│   ├── dashboard.php      # Admin CRUD panel
│   └── logout.php         # Session destroy
└── sql/
    └── portfolio_db.sql   # Full database export (import this first!)
```

---

## 🛠️ Tech Stack

| Layer    | Technology                     |
| -------- | ------------------------------ |
| Frontend | HTML5, CSS3, JavaScript (ES6+) |
| Backend  | PHP 8+                         |
| Database | MySQL (via mysqli)             |
| Server   | Apache (XAMPP)                 |
| Fonts    | Google Fonts (Syne + DM Sans)  |

---

## 🚀 Local Setup (XAMPP)

### 1. Place Files

Copy the `portfolio/` folder to:

```
C:\xampp\htdocs\portfolio\
```

### 2. Start XAMPP

Open XAMPP Control Panel → Start **Apache** and **MySQL**

### 3. Import Database

1. Open `http://localhost/phpmyadmin`
2. Create a new database named `portfolio_db`
3. Click **Import** → select `sql/portfolio_db.sql` → click **Go**

### 4. Open the Portfolio

```
http://localhost/portfolio/
```

### 5. Admin Panel

```
http://localhost/portfolio/admin/login.php

Username: admin
Password: Admin@1234
```

---

## 📋 Requirements Coverage

| Requirement                         | Implementation                             |
| ----------------------------------- | ------------------------------------------ |
| Semantic HTML5 tags                 | `<nav>`, `<section>`, `<footer>`, `<form>` |
| Tables & Forms                      | Contact form, Admin dashboard table        |
| CSS Box Model / Flexbox / Grid      | Used throughout layout                     |
| External stylesheet                 | `css/style.css`                            |
| Dynamic UI (dark mode, mobile menu) | `js/main.js` — cookie-persisted theme      |
| JavaScript Form Validation          | Client-side + server-side (PHP)            |
| DOM Manipulation on user events     | Scroll reveal, mobile nav, form feedback   |
| Contact → MySQL                     | `php/contact.php` + `contacts` table       |
| Dynamic content from DB             | `php/get_projects.php` → JSON → DOM        |
| AJAX / Fetch API                    | Projects & contact form — no page reload   |
| Sessions & Cookies                  | Admin session + theme cookie               |
| Admin Dashboard (add/edit/delete)   | `admin/dashboard.php`                      |
| SQL export file                     | `sql/portfolio_db.sql`                     |

---

## 🔐 Security Notes

- All user inputs sanitized with `htmlspecialchars()` and `filter_var()`
- Prepared statements (PDO/mysqli) used to prevent SQL injection
- `session_regenerate_id()` called on login to prevent session fixation
- Admin cookie uses `HttpOnly` flag

---

## 📸 Screenshots

> Add screenshots of your portfolio here after deployment.

---

## 👤 Author

**Nur Sena Örs**  
Full-Stack Developer  
📧 senaors136@hotmail.com
🔗 [LinkedIn](https://www.linkedin.com/in/nur-sena-%C3%B6rs-6958b9238/?lipi=urn%3Ali%3Apage%3Ad_flagship3_profile_view_base_contact_details%3Be1O%2FtT5SQBip4qKXrT488g%3D%3D) · [GitHub](https://github.com/senaors?tab=overview&from=2026-04-01&to=2026-04-30)

---

_© 2026 Nur Sena Örs — Built for Web Programming Course_
