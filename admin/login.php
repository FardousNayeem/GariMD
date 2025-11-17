<?php
session_start();
if(isset($_SESSION['admin_logged'])) header('Location: dashboard.php');
$msg = '';

if($_SERVER['REQUEST_METHOD']==='POST') {
  $user = $_POST['user'];
  $pass = $_POST['pass'];

  if($user === 'admin' && $pass === 'password123') {
    $_SESSION['admin_logged'] = true;
    header('Location: dashboard.php');
    exit;
  } else {
    $msg = "Invalid login.";
  }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login — GariMD</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main class="wrap login-center">
  <section class="card login-card">
    <h2>Admin Login</h2>

    <?php if($msg): ?>
      <div class="error-box"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
      <label>Username
        <input type="text" name="user" required>
      </label>
      <label>Password
        <input type="password" name="pass" required>
      </label>

      <button class="btn" type="submit" style="margin-top:15px;">Login</button>
    </form>
  </section>
</main>
<footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
