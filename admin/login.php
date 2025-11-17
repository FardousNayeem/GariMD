<?php
session_start();
if(isset($_SESSION['admin_logged'])) header('Location: dashboard.php');

$msg = '';
if($_SERVER['REQUEST_METHOD']==='POST') {
  $user = $_POST['user'] ?? '';
  $pass = $_POST['pass'] ?? '';
  // simple - change for production
  if($user === 'admin' && $pass === 'password123') {
    $_SESSION['admin_logged'] = true;
    header('Location: dashboard.php'); exit;
  } else { $msg = 'Invalid credentials'; }
}
?>
<!doctype html>
<html>
<head><meta charset="utf-8"><title>Admin Login</title>
<link rel="stylesheet" href="../assets/style.css"></head>
<body>
  <header class="site-header"><div class="wrap"><h1>MechaApp - Admin</h1></div></header>
  <main class="wrap">
    <section class="card small">
      <h2>Admin Login</h2>
      <?php if($msg) echo "<div style='color:red'>{$msg}</div>"; ?>
      <form method="post">
        <label>Username <input name="user" required></label>
        <label>Password <input type="password" name="pass" required></label>
        <div class="actions"><button class="btn" type="submit">Login</button></div>
      </form>
    </section>
  </main>
</body>
</html>

