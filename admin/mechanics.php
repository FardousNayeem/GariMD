<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';

$mechs = $pdo->query("SELECT * FROM mechanics ORDER BY name")->fetchAll();
?>
<!doctype html>
<html>
<head>
<title>Manage Mechanics — GariMD</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main class="wrap center-page">
<section class="card">
  <h2>Manage Mechanics</h2>

  <form method="post" action="mechanics_action.php">
    <input type="hidden" name="action" value="add">
    <label>Name
      <input type="text" name="name" required>
    </label>
    <button class="btn" style="margin-top:10px;">Add Mechanic</button>
  </form>

  <h3 style="margin-top:30px;">Existing Mechanics</h3>
  <table class="tbl">
    <tr><th>Name</th><th>Action</th></tr>
    <?php foreach($mechs as $m): ?>
      <tr>
        <td><?= htmlspecialchars($m['name']) ?></td>
        <td><a href="mechanics_action.php?action=delete&id=<?= $m['id'] ?>" onclick="return confirm('Delete mechanic?')">Delete</a></td>
      </tr>
    <?php endforeach; ?>
  </table>
</section>
</main>
<footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
