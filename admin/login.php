<?php
session_start();

// If already logged in, redirect to dashboard
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']) {
    header('Location: dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simple hardcoded admin credentials (in real app: use DB + bcrypt)
    $admin_user = 'admin';
    $admin_pass = 'Admin@1234'; // Change this!

    $user = trim($_POST['username'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if ($user === $admin_user && $pass === $admin_pass) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_user'] = $user;
        // Set persistent cookie
        setcookie('admin_remember', base64_encode($user), time() + 86400 * 7, '/', '', false, true);
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login — Portfolio</title>
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet" />
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: #0f0f0e;
      color: #f0ede8;
      min-height: 100vh;
      display: flex; align-items: center; justify-content: center;
    }
    .login-box {
      width: 100%; max-width: 400px; padding: 48px 40px;
      background: #1f1f1d; border: 1px solid #2a2a28;
      border-radius: 20px;
    }
    .login-logo {
      font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.8rem;
      margin-bottom: 8px; color: #f0ede8;
    }
    .login-logo span { color: #d4562a; }
    .login-sub { color: #888880; font-size: .88rem; margin-bottom: 36px; }
    label { display: block; font-size: .8rem; font-weight: 500; color: #888880;
      text-transform: uppercase; letter-spacing: .06em; margin-bottom: 6px; }
    input[type="text"], input[type="password"] {
      width: 100%; padding: 12px 16px; border-radius: 10px;
      border: 1.5px solid #2a2a28; background: #0f0f0e;
      color: #f0ede8; font-family: inherit; font-size: .95rem;
      margin-bottom: 20px; transition: border-color .2s;
    }
    input:focus { outline: none; border-color: #d4562a; }
    .btn {
      width: 100%; padding: 14px; border-radius: 10px;
      background: #d4562a; color: #fff; border: none;
      font-family: 'Syne', sans-serif; font-size: 1rem; font-weight: 700;
      cursor: pointer; transition: background .2s;
    }
    .btn:hover { background: #b8421f; }
    .error-msg {
      background: rgba(224,82,82,.15); color: #f87171;
      border: 1px solid rgba(224,82,82,.3);
      border-radius: 8px; padding: 10px 14px;
      font-size: .85rem; margin-bottom: 20px;
    }
    .back-link {
      display: block; text-align: center; margin-top: 20px;
      font-size: .82rem; color: #555550; text-decoration: none;
    }
    .back-link:hover { color: #d4562a; }
  </style>
</head>
<body>
<div class="login-box">
  <div class="login-logo">AM<span>.</span></div>
  <p class="login-sub">Admin Dashboard Login</p>
  <?php if ($error): ?>
    <div class="error-msg"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>
  <form method="POST" action="">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required placeholder="admin" autocomplete="username" />
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required placeholder="••••••••" autocomplete="current-password" />
    <button type="submit" class="btn">Sign In →</button>
  </form>
  <a href="../index.php" class="back-link">← Back to Portfolio</a>
</div>
</body>
</html>
