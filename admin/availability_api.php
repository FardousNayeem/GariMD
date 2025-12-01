<?php
session_start();
if (!isset($_SESSION['admin_logged'])) { http_response_code(401); exit; }
require __DIR__ . '/../db/db.php';
header('Content-Type: application/json');

$date = $_GET['date'] ?? null;
if (!$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode([]);
    exit;
}

$sql = "
SELECT 
  m.name,
  m.capacity,
  COALESCE((
    SELECT COUNT(*) FROM appointments a
    WHERE a.mechanic_id = m.id AND a.appointment_date = ?
  ),0) AS booked,
  GREATEST(m.capacity - COALESCE((
    SELECT COUNT(*) FROM appointments a
    WHERE a.mechanic_id = m.id AND a.appointment_date = ?
  ),0), 0) AS remaining
FROM mechanics m
ORDER BY m.name";
$stmt = $pdo->prepare($sql);
$stmt->execute([$date, $date]);

echo json_encode($stmt->fetchAll());
?>