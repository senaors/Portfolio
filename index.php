<?php
session_start();
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Nur Sena Örs — Full-Stack Developer</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,wght@0,300;0,400;0,500;1,300&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="css/style.css" />
</head>
<body class="light-mode">

<!-- ===== NAVIGATION ===== -->
<nav id="navbar">
  <div class="nav-inner">
    <a href="#" class="nav-logo">AM<span class="dot">.</span></a>
    <ul class="nav-links" id="navLinks">
      <li><a href="#about">About</a></li>
      <li><a href="#projects">Projects</a></li>
      <li><a href="#skills">Skills</a></li>
      <li><a href="#contact">Contact</a></li>
      <?php if ($is_admin): ?>
      <li><a href="admin/dashboard.php" class="admin-link">⚙ Dashboard</a></li>
      <?php endif; ?>
    </ul>
    <div class="nav-actions">
      <button id="darkToggle" aria-label="Toggle dark mode" title="Toggle dark mode">
        <span class="icon-sun">☀</span><span class="icon-moon">☽</span>
      </button>
      <button id="hamburger" aria-label="Open menu">
        <span></span><span></span><span></span>
      </button>
    </div>
  </div>
</nav>

<!-- ===== HERO ===== -->
<section id="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-content">
    <p class="hero-eyebrow reveal">Available for work</p>
    <h1 class="hero-title reveal">
      Hi, I'm<br/>
      <span class="hero-name">Nur Sena Örs</span>
    </h1>
    <p class="hero-sub reveal">
      Full-Stack Developer crafting fast, accessible & beautiful web experiences — from pixel-perfect UIs to scalable backends.
    </p>
    <div class="hero-cta reveal">
      <a href="#projects" class="btn btn-primary">View My Work</a>
      <a href="#contact" class="btn btn-outline">Get In Touch</a>
    </div>
    <div class="hero-stats reveal">
      <div class="stat"><span class="stat-n">3+</span><span class="stat-l">Years Exp.</span></div>
      <div class="stat-div"></div>
      <div class="stat"><span class="stat-n">3+</span><span class="stat-l">Projects</span></div>
      <div class="stat-div"></div>
      <div class="stat"><span class="stat-n">1+</span><span class="stat-l">Happy Clients</span></div>
    </div>
  </div>
  <a href="#about" class="scroll-down" aria-label="Scroll down">
    <span class="scroll-arrow">↓</span>
  </a>
</section>

<!-- ===== ABOUT ===== -->
<section id="about">
  <div class="container">
    <div class="section-label reveal">About Me</div>
    <div class="about-grid">
      <div class="about-photo reveal">
        <div class="photo-frame">
          <div class="photo-inner"></div>
        </div>
        <div class="about-badge">
          <span>Open to</span>
          <strong>Opportunities</strong>
        </div>
      </div>
      <div class="about-text">
        <h2 class="reveal">Building things for the web — with care.</h2>
        <p class="reveal">I'm a full-stack developer with 3+ years of experience turning complex ideas into elegant, functional products. I specialize in PHP, JavaScript, MySQL, and modern frontend technologies.</p>
        <p class="reveal">When I'm not coding, you'll find me exploring new technologies, contributing to open-source, or sharing knowledge with the developer community.</p>
        <div class="about-cards reveal">
          <div class="acard">
            <div class="acard-icon">⚡</div>
            <h4>Clean Code</h4>
            <p>Maintainable, scalable solutions with modern best practices.</p>
          </div>
          <div class="acard">
            <div class="acard-icon">◈</div>
            <h4>Design Focus</h4>
            <p>Intuitive interfaces that users love to interact with.</p>
          </div>
          <div class="acard">
            <div class="acard-icon">▲</div>
            <h4>Performance</h4>
            <p>Optimizing every detail for speed and seamless UX.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== PROJECTS ===== -->
<section id="projects">
  <div class="container">
    <div class="section-label reveal">Featured Work</div>
    <div class="section-head reveal">
      <h2>Projects</h2>
      <p>A selection of work that showcases my skills across the full stack.</p>
    </div>
    <!-- Projects loaded via AJAX from PHP/MySQL -->
    <div id="projects-grid" class="projects-grid">
      <div class="loading-spinner"><span></span></div>
    </div>
  </div>
</section>

<!-- ===== SKILLS ===== -->
<section id="skills">
  <div class="container">
    <div class="section-label reveal">What I Know</div>
    <h2 class="reveal">Skills & Technologies</h2>
    <p class="section-sub reveal">A toolkit built through years of hands-on experience and continuous learning.</p>
    <div class="skills-grid reveal">
      <div class="skill-block">
        <h4 class="skill-cat">Frontend</h4>
        <div class="skill-tags">
          <span>HTML5</span><span>CSS3</span><span>JavaScript</span>
          <span>React</span><span>Tailwind CSS</span><span>Flexbox / Grid</span>
        </div>
      </div>
      <div class="skill-block">
        <h4 class="skill-cat">Backend</h4>
        <div class="skill-tags">
          <span>PHP</span><span>Node.js</span><span>REST APIs</span>
          <span>AJAX</span><span>Sessions</span><span>Cookies</span>
        </div>
      </div>
      <div class="skill-block">
        <h4 class="skill-cat">Database</h4>
        <div class="skill-tags">
          <span>MySQL</span><span>PostgreSQL</span><span>phpMyAdmin</span>
          <span>SQL Queries</span><span>Joins</span><span>Indexes</span>
        </div>
      </div>
      <div class="skill-block">
        <h4 class="skill-cat">Tools</h4>
        <div class="skill-tags">
          <span>Git & GitHub</span><span>XAMPP</span><span>VS Code</span>
          <span>Figma</span><span>Linux CLI</span><span>Docker</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== CONTACT ===== -->
<section id="contact">
  <div class="container">
    <div class="section-label reveal">Say Hello</div>
    <div class="contact-grid">
      <div class="contact-left reveal">
        <h2>Let's Work<br/>Together.</h2>
        <p>I'm always open to discussing new projects, creative ideas, or opportunities.</p>
        <div class="contact-links">
          <a href="mailto:senaors136@hotmail.com" class="clink">
            <span class="clink-icon">✉</span>
            <div><small>Email</small><strong>senaors136@hotmail.com</strong></div>
          </a>
          <a href="https://www.linkedin.com/messaging/thread/2-MjQzNjZhMzktN2I3NC00OGI1LWFkMzQtZjg1N2ZjNDllMTVmXzEwMA==/" class="clink" target="_blank" rel="noopener">
            <span class="clink-icon">in</span>
            <div><small>LinkedIn</small><strong>/senaors</strong></div>
          </a>
          <a href="https://github.com/senaors" class="clink" target="_blank" rel="noopener">
            <span class="clink-icon">⌥</span>
            <div><small>GitHub</small><strong>@senaors</strong></div>
          </a>
        </div>
      </div>
      <div class="contact-right reveal">
        <form id="contactForm" novalidate>
          <div class="form-row">
            <div class="form-group">
              <label for="fname">First Name *</label>
              <input type="text" id="fname" name="fname" placeholder="Name" required />
              <span class="err-msg" id="err-fname"></span>
            </div>
            <div class="form-group">
              <label for="lname">Last Name *</label>
              <input type="text" id="lname" name="lname" placeholder="Surname" required />
              <span class="err-msg" id="err-lname"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" placeholder="you@example.com" required />
            <span class="err-msg" id="err-email"></span>
          </div>
          <div class="form-group">
            <label for="subject">Subject *</label>
            <input type="text" id="subject" name="subject" placeholder="Project Inquiry" required />
            <span class="err-msg" id="err-subject"></span>
          </div>
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" rows="5" placeholder="Tell me about your project..." required></textarea>
            <span class="err-msg" id="err-message"></span>
          </div>
          <button type="submit" class="btn btn-primary btn-full" id="submitBtn">
            Send Message <span class="btn-arrow">→</span>
          </button>
          <div id="formFeedback" class="form-feedback"></div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- ===== FOOTER ===== -->
<footer>
  <div class="container footer-inner">
    <span class="footer-logo">AM<span class="dot">.</span></span>
    <p>© 2026 Nur Sena Örs. Built with HTML, CSS, PHP & MySQL.</p>
    <a href="admin/login.php" class="footer-admin-link">Admin</a>
  </div>
</footer>

<script src="js/main.js"></script>
</body>
</html>
