<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || !$_SESSION['admin_logged_in']) {
    header('Location: login.php');
    exit;
}
require_once __DIR__ . '/../php/db.php';
$db = getDB();

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = (int)$_POST['delete_id'];
    $stmt = $db->prepare("DELETE FROM projects WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    header('Location: dashboard.php?deleted=1');
    exit;
}

// Handle add/edit
$edit_project = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    $res = $db->prepare("SELECT * FROM projects WHERE id = ?");
    $res->bind_param('i', $id);
    $res->execute();
    $edit_project = $res->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_project'])) {
    $title = htmlspecialchars(trim($_POST['title'] ?? ''), ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars(trim($_POST['description'] ?? ''), ENT_QUOTES, 'UTF-8');
    $tags = htmlspecialchars(trim($_POST['tags'] ?? ''), ENT_QUOTES, 'UTF-8');
    $github_url = trim($_POST['github_url'] ?? '');
    $demo_url = trim($_POST['demo_url'] ?? '');
    $image_url = trim($_POST['image_url'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $pid = (int)($_POST['project_id'] ?? 0);

    if ($pid > 0) {
        $stmt = $db->prepare("UPDATE projects SET title=?, description=?, tags=?, github_url=?, demo_url=?, image_url=?, sort_order=? WHERE id=?");
        $stmt->bind_param('ssssssis', $title, $description, $tags, $github_url, $demo_url, $image_url, $sort_order, $pid);
    } else {
        $stmt = $db->prepare("INSERT INTO projects (title, description, tags, github_url, demo_url, image_url, sort_order, created_at) VALUES (?,?,?,?,?,?,?,NOW())");
        $stmt->bind_param('ssssssi', $title, $description, $tags, $github_url, $demo_url, $image_url, $sort_order);
    }
    $stmt->execute();
    header('Location: dashboard.php?saved=1');
    exit;
}

// Fetch all projects
$projects = $db->query("SELECT * FROM projects ORDER BY sort_order ASC, created_at DESC")->fetch_all(MYSQLI_ASSOC);

// Fetch contacts
$contacts = $db->query("SELECT * FROM contacts ORDER BY created_at DESC LIMIT 20")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard — Portfolio</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root { --acc: #d4562a; --bg: #0f0f0e; --bg2: #1a1a18; --surface: #1f1f1d;
      --border: #2a2a28; --text: #f0ede8; --text2: #888880; }
    body { font-family: 'DM Sans', sans-serif; background: var(--bg); color: var(--text); }
    a { color: var(--acc); text-decoration: none; }
    h1,h2,h3 { font-family: 'Syne', sans-serif; }

    /* Sidebar */
    .layout { display: flex; min-height: 100vh; }
    .sidebar {
      width: 220px; flex-shrink: 0; background: var(--bg2);
      border-right: 1px solid var(--border); padding: 28px 20px;
      display: flex; flex-direction: column; gap: 8px; position: sticky; top: 0; height: 100vh;
    }
    .sidebar-logo { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.4rem; margin-bottom: 28px; }
    .sidebar-logo span { color: var(--acc); }
    .nav-item {
      padding: 10px 14px; border-radius: 8px; font-size: .88rem;
      color: var(--text2); cursor: pointer; transition: all .2s;
      border: none; background: none; text-align: left; width: 100%;
      font-family: inherit;
    }
    .nav-item:hover, .nav-item.active { background: var(--surface); color: var(--text); }
    .sidebar-bottom { margin-top: auto; }
    .logout-btn {
      width: 100%; padding: 10px 14px; border-radius: 8px;
      background: rgba(212,86,42,.15); color: var(--acc);
      border: 1px solid rgba(212,86,42,.3); font-family: inherit;
      font-size: .88rem; cursor: pointer; transition: all .2s;
    }
    .logout-btn:hover { background: var(--acc); color: #fff; }

    /* Content */
    .content { flex: 1; padding: 40px 48px; overflow-x: auto; }
    .page { display: none; }
    .page.active { display: block; }
    .page-title { font-size: 1.6rem; margin-bottom: 8px; }
    .page-sub { color: var(--text2); font-size: .9rem; margin-bottom: 32px; }

    /* Alert */
    .alert {
      padding: 12px 16px; border-radius: 8px; margin-bottom: 24px;
      font-size: .88rem; background: rgba(52,211,153,.1); color: #34d399;
      border: 1px solid rgba(52,211,153,.2);
    }

    /* Form */
    .form-card { background: var(--surface); border: 1px solid var(--border); border-radius: 16px; padding: 32px; max-width: 680px; }
    .form-group { margin-bottom: 20px; }
    .form-group label { display: block; font-size: .8rem; font-weight: 500; color: var(--text2); text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; }
    .form-group input, .form-group textarea {
      width: 100%; padding: 10px 14px; border-radius: 8px;
      border: 1.5px solid var(--border); background: var(--bg);
      color: var(--text); font-family: inherit; font-size: .9rem;
      transition: border-color .2s;
    }
    .form-group input:focus, .form-group textarea:focus { outline: none; border-color: var(--acc); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .btn { padding: 10px 24px; border-radius: 8px; font-family: 'Syne', sans-serif; font-weight: 700; font-size: .9rem; cursor: pointer; border: none; transition: all .2s; }
    .btn-acc { background: var(--acc); color: #fff; }
    .btn-acc:hover { background: #b8421f; }
    .btn-ghost { background: transparent; color: var(--text2); border: 1px solid var(--border); }
    .btn-ghost:hover { border-color: var(--acc); color: var(--acc); }
    .btn-danger { background: rgba(239,68,68,.15); color: #f87171; border: 1px solid rgba(239,68,68,.2); }
    .btn-danger:hover { background: #ef4444; color: #fff; }
    .btn-sm { padding: 6px 14px; font-size: .78rem; }
    .btn-grp { display: flex; gap: 10px; }

    /* Table */
    table { width: 100%; border-collapse: collapse; font-size: .88rem; }
    th { text-align: left; padding: 10px 14px; border-bottom: 1px solid var(--border); color: var(--text2); font-size: .75rem; text-transform: uppercase; letter-spacing: .08em; font-weight: 600; }
    td { padding: 12px 14px; border-bottom: 1px solid var(--border); vertical-align: top; }
    tr:last-child td { border-bottom: none; }
    tr:hover td { background: var(--surface); }
    .tag-pill { display: inline-block; padding: 2px 8px; background: var(--bg2); border-radius: 50px; font-size: .72rem; color: var(--text2); margin: 2px; }

    /* Contacts table */
    .contact-msg { color: var(--text2); font-size: .83rem; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .contact-date { color: var(--text2); font-size: .8rem; white-space: nowrap; }
  </style>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-logo">AM<span>.</span></div>
    <button class="nav-item active" onclick="showPage('projects')">📁 Projects</button>
    <button class="nav-item" onclick="showPage('messages')">✉ Messages</button>
    <button class="nav-item" onclick="showPage('add')">+ Add Project</button>
    <a href="../index.php" class="nav-item" style="display:block;">← Portfolio</a>
    <div class="sidebar-bottom">
      <form method="POST" action="logout.php">
        <button type="submit" class="logout-btn">Sign Out</button>
      </form>
    </div>
  </aside>

  <main class="content">
    <?php if (isset($_GET['saved'])): ?>
      <div class="alert">✓ Project saved successfully!</div>
    <?php endif; ?>
    <?php if (isset($_GET['deleted'])): ?>
      <div class="alert">✓ Project deleted.</div>
    <?php endif; ?>

    <!-- PROJECTS PAGE -->
    <div class="page active" id="page-projects">
      <h1 class="page-title">Projects</h1>
      <p class="page-sub">Manage your portfolio projects. They load dynamically on the homepage.</p>
      <div style="overflow-x:auto; background:var(--surface); border:1px solid var(--border); border-radius:16px;">
        <table>
          <thead>
            <tr>
              <th>#</th><th>Title</th><th>Tags</th><th>Order</th><th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($projects as $i => $p): ?>
            <tr>
              <td><?= $p['id'] ?></td>
              <td><strong><?= htmlspecialchars($p['title']) ?></strong>
                <div style="color:var(--text2);font-size:.78rem;margin-top:3px;"><?= htmlspecialchars(substr($p['description'], 0, 60)) ?>…</div>
              </td>
              <td><?php foreach(explode(',', $p['tags'] ?? '') as $t): ?>
                <span class="tag-pill"><?= htmlspecialchars(trim($t)) ?></span>
              <?php endforeach; ?></td>
              <td><?= $p['sort_order'] ?></td>
              <td>
                <div class="btn-grp">
                  <button class="btn btn-ghost btn-sm" onclick="showPage('add'); loadEdit(<?= htmlspecialchars(json_encode($p)) ?>)">Edit</button>
                  <form method="POST" onsubmit="return confirm('Delete this project?');" style="display:inline">
                    <input type="hidden" name="delete_id" value="<?= $p['id'] ?>" />
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                  </form>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($projects)): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text2);padding:32px;">No projects yet. Add one!</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- MESSAGES PAGE -->
    <div class="page" id="page-messages">
      <h1 class="page-title">Contact Messages</h1>
      <p class="page-sub">Messages submitted through the contact form.</p>
      <div style="overflow-x:auto; background:var(--surface); border:1px solid var(--border); border-radius:16px;">
        <table>
          <thead>
            <tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Date</th></tr>
          </thead>
          <tbody>
            <?php foreach ($contacts as $c): ?>
            <tr>
              <td><strong><?= htmlspecialchars($c['first_name'] . ' ' . $c['last_name']) ?></strong></td>
              <td><?= htmlspecialchars($c['email']) ?></td>
              <td><?= htmlspecialchars($c['subject']) ?></td>
              <td class="contact-msg"><?= htmlspecialchars($c['message']) ?></td>
              <td class="contact-date"><?= date('d M Y', strtotime($c['created_at'])) ?></td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($contacts)): ?>
            <tr><td colspan="5" style="text-align:center;color:var(--text2);padding:32px;">No messages yet.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- ADD/EDIT PAGE -->
    <div class="page" id="page-add">
      <h1 class="page-title" id="formPageTitle">Add Project</h1>
      <p class="page-sub">Fill in the details below to add or edit a project.</p>
      <div class="form-card">
        <form method="POST" action="dashboard.php">
          <input type="hidden" name="save_project" value="1" />
          <input type="hidden" name="project_id" id="field_id" value="0" />
          <div class="form-group">
            <label>Project Title *</label>
            <input type="text" name="title" id="field_title" placeholder="E-Commerce Platform" required />
          </div>
          <div class="form-group">
            <label>Description *</label>
            <textarea name="description" id="field_description" rows="3" placeholder="Brief description of the project..." required></textarea>
          </div>
          <div class="form-group">
            <label>Tags (comma-separated)</label>
            <input type="text" name="tags" id="field_tags" placeholder="PHP, MySQL, JavaScript" />
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>GitHub URL</label>
              <input type="url" name="github_url" id="field_github_url" placeholder="https://github.com/..." />
            </div>
            <div class="form-group">
              <label>Demo URL</label>
              <input type="url" name="demo_url" id="field_demo_url" placeholder="https://..." />
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Image URL</label>
              <input type="url" name="image_url" id="field_image_url" placeholder="https://..." />
            </div>
            <div class="form-group">
              <label>Sort Order</label>
              <input type="number" name="sort_order" id="field_sort_order" value="0" min="0" />
            </div>
          </div>
          <div class="btn-grp">
            <button type="submit" class="btn btn-acc">Save Project</button>
            <button type="button" class="btn btn-ghost" onclick="showPage('projects'); resetForm()">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>

<script>
function showPage(name) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
  document.getElementById('page-' + name)?.classList.add('active');
}
function loadEdit(project) {
  document.getElementById('formPageTitle').textContent = 'Edit Project';
  document.getElementById('field_id').value = project.id;
  document.getElementById('field_title').value = project.title;
  document.getElementById('field_description').value = project.description;
  document.getElementById('field_tags').value = project.tags || '';
  document.getElementById('field_github_url').value = project.github_url || '';
  document.getElementById('field_demo_url').value = project.demo_url || '';
  document.getElementById('field_image_url').value = project.image_url || '';
  document.getElementById('field_sort_order').value = project.sort_order || 0;
}
function resetForm() {
  document.getElementById('formPageTitle').textContent = 'Add Project';
  document.getElementById('field_id').value = '0';
  ['title','description','tags','github_url','demo_url','image_url'].forEach(f => {
    document.getElementById('field_' + f).value = '';
  });
  document.getElementById('field_sort_order').value = '0';
}
</script>
</body>
</html>
