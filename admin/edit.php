<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';

$id = (int)($_GET['id'] ?? 0);
if(!$id) header('Location: dashboard.php');

$stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = ?");
$stmt->execute([$id]);
$app = $stmt->fetch();
if(!$app) header('Location: dashboard.php');

$mechStmt = $pdo->query("SELECT id, name FROM mechanics ORDER BY name");
$mechanics = $mechStmt->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Edit</title>
<link rel="stylesheet" href="../assets/style.css"></head>
<body>
  <header class="site-header"><div class="wrap"><h1>Edit Appointment</h1></div></header>
  <main class="wrap">
    <section class="card small">
      <h2>#<?= $id ?></h2>
      <form method="post" action="update.php">
        <input type="hidden" name="action" value="update_appointment">
        <input type="hidden" name="id" value="<?=$id?>">
        <label>Client: <?=htmlspecialchars($app['client_name'])?></label>
        <label>Date <input type="date" name="appointment_date" value="<?=htmlspecialchars($app['appointment_date'])?>" required></label>
        <label>Mechanic
          <select name="mechanic_id" required>
            <?php foreach($mechanics as $m): ?>
              <option value="<?=$m['id']?>" <?= $m['id']==$app['mechanic_id'] ? 'selected':'' ?>><?=htmlspecialchars($m['name'])?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <div class="actions"><button class="btn" type="submit">Save</button> <a class="btn secondary" href="dashboard.php">Back</a></div>
      </form>
    </section>
  </main>
  <footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
