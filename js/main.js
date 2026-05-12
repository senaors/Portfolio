/* ============================================================
   PORTFOLIO — main.js
   - Navbar scroll effect
   - Dark mode toggle (with cookie persistence)
   - Mobile menu
   - Scroll reveal
   - Projects AJAX load
   - Contact form validation & AJAX submit
   ============================================================ */
 
// ── Utility ──────────────────────────────────────────────────
const $ = id => document.getElementById(id);
const $$ = sel => document.querySelectorAll(sel);
 
function setCookie(name, value, days) {
  const expires = new Date(Date.now() + days * 864e5).toUTCString();
  document.cookie = `${name}=${value};expires=${expires};path=/;SameSite=Lax`;
}
function getCookie(name) {
  return document.cookie.split('; ').reduce((acc, c) => {
    const [k, v] = c.split('=');
    return k === name ? v : acc;
  }, null);
}
 
// ── Dark Mode ─────────────────────────────────────────────────
const body = document.body;
const darkToggle = $('darkToggle');
 
function applyTheme(dark) {
  body.classList.toggle('dark-mode', dark);
  body.classList.toggle('light-mode', !dark);
}
 
// On load: check cookie
const savedTheme = getCookie('theme');
applyTheme(savedTheme === 'dark');
 
darkToggle?.addEventListener('click', () => {
  const isDark = body.classList.contains('dark-mode');
  applyTheme(!isDark);
  setCookie('theme', !isDark ? 'dark' : 'light', 365);
});
 
// ── Navbar Scroll ─────────────────────────────────────────────
const navbar = $('navbar');
window.addEventListener('scroll', () => {
  navbar?.classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });
 
// ── Mobile Hamburger ──────────────────────────────────────────
const hamburger = $('hamburger');
 
// Create mobile nav overlay dynamically
const mobileNav = document.createElement('div');
mobileNav.className = 'mobile-nav';
const mobileLinks = [
  ['#about','About'], ['#projects','Projects'],
  ['#skills','Skills'], ['#contact','Contact']
];
mobileLinks.forEach(([href, label]) => {
  const a = document.createElement('a');
  a.href = href; a.textContent = label;
  a.addEventListener('click', closeMobileNav);
  mobileNav.appendChild(a);
});
document.body.appendChild(mobileNav);
 
function closeMobileNav() {
  mobileNav.classList.remove('open');
  hamburger?.classList.remove('open');
}
 
hamburger?.addEventListener('click', () => {
  const open = mobileNav.classList.toggle('open');
  hamburger.classList.toggle('open', open);
});
 
// ── Scroll Reveal ─────────────────────────────────────────────
const revealEls = $$('.reveal');
const observer = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('visible');
      observer.unobserve(e.target);
    }
  });
}, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
revealEls.forEach(el => observer.observe(el));
 
// ── Projects — AJAX Load ──────────────────────────────────────
async function loadProjects() {
  const grid = $('projects-grid');
  if (!grid) return;
  try {
    const res = await fetch('php/get_projects.php');
    const projects = await res.json();
    if (!projects.length) {
      grid.innerHTML = '<p style="color:var(--text2);text-align:center;grid-column:1/-1;">No projects found.</p>';
      return;
    }
    grid.innerHTML = '';
    projects.forEach((p, i) => {
      const card = document.createElement('div');
      card.className = 'project-card reveal';
      const tags = p.tags ? p.tags.split(',').map(t =>
        `<span>${t.trim()}</span>`).join('') : '';
      const imgContent = p.image_url
        ? `<img src="${escHtml(p.image_url)}" alt="${escHtml(p.title)}" loading="lazy" />`
        : `<div class="project-img-placeholder">${escHtml(p.title.substring(0,2).toUpperCase())}</div>`;
      card.innerHTML = `
        <div class="project-img">${imgContent}</div>
        <div class="project-body">
          <div class="project-tags">${tags}</div>
          <div class="project-title">${escHtml(p.title)}</div>
          <p class="project-desc">${escHtml(p.description)}</p>
          <div class="project-links">
            ${p.github_url ? `<a href="${escHtml(p.github_url)}" class="project-link" target="_blank" rel="noopener">⌥ Code</a>` : ''}
            ${p.demo_url ? `<a href="${escHtml(p.demo_url)}" class="project-link" target="_blank" rel="noopener">↗ Demo</a>` : ''}
          </div>
        </div>`;
      grid.appendChild(card);
      // Re-observe for reveal
      setTimeout(() => observer.observe(card), i * 80);
    });
  } catch (err) {
    grid.innerHTML = '<p style="color:var(--text2);text-align:center;grid-column:1/-1;">Could not load projects.</p>';
    console.error(err);
  }
}
loadProjects();
 
// ── Contact Form Validation & Submit ─────────────────────────
const form = $('contactForm');
 
function escHtml(str) {
  return String(str)
    .replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;')
    .replace(/"/g,'&quot;');
}
 
function showErr(id, msg) {
  const el = $(id);
  if (el) el.textContent = msg;
}
function clearErr(id) { showErr(id, ''); }
function markInvalid(inputId, errId, msg) {
  const inp = $(inputId);
  inp?.classList.add('error');
  showErr(errId, msg);
  return false;
}
function markValid(inputId, errId) {
  const inp = $(inputId);
  inp?.classList.remove('error');
  clearErr(errId);
  return true;
}
 
function validateForm() {
  let valid = true;
  const fields = [
    { id: 'fname', err: 'err-fname', label: 'First name' },
    { id: 'lname', err: 'err-lname', label: 'Last name' },
    { id: 'subject', err: 'err-subject', label: 'Subject' },
    { id: 'message', err: 'err-message', label: 'Message', min: 10 },
  ];
  fields.forEach(f => {
    const val = $(f.id)?.value.trim() || '';
    if (!val) { markInvalid(f.id, f.err, `${f.label} is required.`); valid = false; }
    else if (f.min && val.length < f.min) { markInvalid(f.id, f.err, `At least ${f.min} characters.`); valid = false; }
    else markValid(f.id, f.err);
  });
  // Email
  const emailVal = $('email')?.value.trim() || '';
  const emailRx = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailVal) { markInvalid('email','err-email','Email is required.'); valid = false; }
  else if (!emailRx.test(emailVal)) { markInvalid('email','err-email','Please enter a valid email.'); valid = false; }
  else markValid('email','err-email');
  return valid;
}
 
// Live validation
['fname','lname','email','subject','message'].forEach(id => {
  $(id)?.addEventListener('blur', () => validateForm());
  $(id)?.addEventListener('input', () => {
    $(id).classList.remove('error');
    clearErr(`err-${id}`);
  });
});
 
form?.addEventListener('submit', async (e) => {
  e.preventDefault();
  if (!validateForm()) return;
  const btn = $('submitBtn');
  const feedback = $('formFeedback');
  btn.disabled = true;
  btn.textContent = 'Sending…';
  feedback.className = 'form-feedback';
  feedback.style.display = 'none';
  const data = new FormData(form);
  try {
    // Formspree'ye gönder (email gelsin)
    const res = await fetch('https://formspree.io/f/xnjwrner', {
      method: 'POST',
      body: data,
      headers: { 'Accept': 'application/json' }
    });
    const json = await res.json();
    if (res.ok) {
      feedback.className = 'form-feedback success';
      feedback.textContent = '✓ Your message has been received! We will get back to you as soon as possible.';
      feedback.style.display = 'block';
      // DB'ye de kaydet
      fetch('php/contact.php', { method: 'POST', body: new FormData(form) }).catch(() => {});
      form.reset();
    } else {
      feedback.className = 'form-feedback error';
      feedback.textContent = json.errors ? json.errors.map(e => e.message).join(', ') : 'Bir hata oluştu, tekrar deneyin.';
    }
  } catch {
    feedback.className = 'form-feedback error';
    feedback.textContent = 'Bağlantı hatası. Lütfen tekrar deneyin.';
  } finally {
    btn.disabled = false;
    btn.innerHTML = 'Send Message <span class="btn-arrow">→</span>';
  }
});
 