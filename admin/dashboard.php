<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';

// mechanic overview
$mechStmt = $pdo->query("
    SELECT m.*,
    (SELECT COUNT(*) FROM appointments a 
     WHERE a.mechanic_id = m.id AND a.appointment_date = CURDATE()) AS today_count
    FROM mechanics m
");
$mechanics = $mechStmt->fetchAll();

// all appointments
$appStmt = $pdo->query("
  SELECT a.*, m.name AS mechanic_name
  FROM appointments a
  JOIN mechanics m ON a.mechanic_id = m.id
  ORDER BY a.appointment_date DESC
");
$appointments = $appStmt->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Dashboard — GariMD</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main class="wrap">
    <section class="card">
      <h2>Mechanics (Today)</h2>
      <table class="tbl">
        <tr><th>Name</th><th>Booked Today</th><th>Remaining</th></tr>
        <?php foreach($mechanics as $m): ?>
          <tr>
            <td><?= htmlspecialchars($m['name']) ?></td>
            <td><?= $m['today_count'] ?></td>
            <td><?= 4 - $m['today_count'] ?></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>

    <section class="card">
      <h2>Appointments</h2>
      <table class="tbl">
        <tr>
          <th>ID</th><th>Name</th><th>Phone</th><th>Reg</th><th>Engine</th>
          <th>Date</th><th>Mechanic</th><th>Action</th>
        </tr>
        <?php foreach($appointments as $a): ?>
          <tr>
            <td><?= $a['id'] ?></td>
            <td><?= htmlspecialchars($a['client_name']) ?></td>
            <td><?= htmlspecialchars($a['phone']) ?></td>
            <td><?= htmlspecialchars($a['car_license']) ?></td>
            <td><?= htmlspecialchars($a['car_engine']) ?></td>
            <td><?= htmlspecialchars($a['appointment_date']) ?></td>
            <td><?= htmlspecialchars($a['mechanic_name']) ?></td>
            <td><a href="edit.php?id=<?= $a['id'] ?>">Edit</a></td>
          </tr>
        <?php endforeach; ?>
      </table>
    </section>
</main>

</body>
</html>
