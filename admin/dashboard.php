<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';

// mechanics
$mechStmt = $pdo->query("SELECT id, name, capacity FROM mechanics ORDER BY name");
$mechanics = $mechStmt->fetchAll();

// appointments
$appStmt = $pdo->query("SELECT a.*, m.name as mechanic_name FROM appointments a JOIN mechanics m ON a.mechanic_id = m.id ORDER BY appointment_date DESC, id DESC");
$appointments = $appStmt->fetchAll();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Admin Dashboard</title>
<link rel="stylesheet" href="../assets/style.css"></head>
<body>
  <header class="site-header"><div class="wrap"><h1>Admin Dashboard</h1><nav><a href="logout.php">Logout</a></nav></div></header>
  <main class="wrap">
    <section class="card">
      <h2>Mechanics</h2>
      <form method="post" action="update.php">
        <table class="tbl" style="width:100%;border-collapse:collapse;">
          <thead><tr><th>Name</th><th>Capacity</th><th>Change</th></tr></thead>
          <tbody>
            <?php foreach($mechanics as $m): ?>
            <tr>
              <td><?=htmlspecialchars($m['name'])?></td>
              <td><?=intval($m['capacity'])?></td>
              <td>
                <input type="hidden" name="action" value="update_capacity">
                <input type="hidden" name="id" value="<?=intval($m['id'])?>">
                <input name="capacity" type="number" min="1" value="<?=intval($m['capacity'])?>" style="width:80px">
                <button class="btn" formaction="update.php" formmethod="post" type="submit">Save</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </form>
    </section>

    <section class="card">
      <h2>Appointments</h2>
      <table class="tbl" style="width:100%;border-collapse:collapse;">
        <thead><tr><th>ID</th><th>Name</th><th>Phone</th><th>Car Reg</th><th>Engine</th><th>Date</th><th>Mechanic</th><th>Action</th></tr></thead>
        <tbody>
          <?php foreach($appointments as $a): ?>
            <tr>
              <td><?=$a['id']?></td>
              <td><?=htmlspecialchars($a['client_name'])?></td>
              <td><?=htmlspecialchars($a['phone'])?></td>
              <td><?=htmlspecialchars($a['car_license'])?></td>
              <td><?=htmlspecialchars($a['car_engine'])?></td>
              <td><?=htmlspecialchars($a['appointment_date'])?></td>
              <td><?=htmlspecialchars($a['mechanic_name'])?></td>
              <td><a href="edit.php?id=<?=$a['id']?>">Edit</a></td>
            </tr>
          <?php endforeach; ?>
          <?php if(empty($appointments)) echo '<tr><td colspan="8">No appointments yet.</td></tr>'; ?>
        </tbody>
      </table>
    </section>
  </main>
</body>
</html>
