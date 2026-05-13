# Portfolio — Nur Sena Örs

A full-stack portfolio I built from scratch using HTML5, CSS3, JavaScript, PHP and MySQL. This started as a course project but I wanted it to actually look like something I'd be proud to share — so I put a lot of extra work into the design and the details.

🌐 **Live Demo:** [your-live-link-here]  
📁 **GitHub:** [github.com/senaors/Portfolio](https://github.com/senaors)

---

## What's in it

- Responsive layout that works on mobile and desktop, built with CSS Grid and Flexbox
- Dark/light mode toggle — preference saved in a cookie so it remembers you
- Projects section loaded dynamically from a MySQL database via AJAX (no page reload)
- Contact form with both client-side JS validation and server-side PHP validation, messages saved to DB
- Admin dashboard behind a session login — add, edit, delete projects and read contact messages
- Scroll reveal animations using IntersectionObserver

---

## Project structure

The main entry point is `index.php`. Styles are in `css/style.css`, client-side logic in `js/main.js`. Backend PHP files live under `php/` (database connection, project endpoint, contact endpoint) and the admin panel is under `admin/`. The SQL export is in `sql/portfolio_db.sql`.

---

## Tech stack

| Layer    | Technology                     |
| -------- | ------------------------------ |
| Frontend | HTML5, CSS3, JavaScript (ES6+) |
| Backend  | PHP 8+                         |
| Database | MySQL via mysqli               |
| Server   | Apache (XAMPP)                 |
| Fonts    | Google Fonts — Syne + DM Sans  |

---

## Running it locally

**Requirements:** XAMPP (Apache + MySQL)

1. Copy the `portfolio/` folder into `C:\xampp\htdocs\`
2. Start Apache and MySQL from the XAMPP control panel
3. Go to `http://localhost/phpmyadmin`, create a database called `portfolio_db`, then import `sql/portfolio_db.sql`
4. Open `http://localhost/Portfolio/`

**Admin panel:** `http://localhost/Portfolio/admin/login.php`  
Username: `admin` / Password: `Admin@1234`

---

## The part that took the most work

Getting the AJAX + DOM integration right was trickier than I expected. The projects load asynchronously from PHP, but I also needed the scroll reveal animations (IntersectionObserver) to work on those dynamically created cards — they don't exist in the DOM at page load, so the observer had nothing to attach to initially. I ended up calling `observer.observe()` on each card right after injecting it, with a small staggered delay so the animations feel natural.

---

## Security

- Inputs sanitized with `htmlspecialchars()` on the PHP side and `escHtml()` in JS
- Prepared statements with `bind_param()` throughout — no raw SQL with user input
- `session_regenerate_id(true)` on login to prevent session fixation
- Admin remember cookie set with `HttpOnly`

---

## Author

**Nur Sena Örs** — Full-Stack Developer  
senaors136@hotmail.com  
[LinkedIn](https://www.linkedin.com/in/nur-sena-%C3%B6rs-6958b9238/) · [GitHub](https://github.com/senaors)

---

_© 2026 Nur Sena Örs — Built for Web Programming Course_
