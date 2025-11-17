<?php
session_start();
if(!isset($_SESSION['admin_logged'])) exit;
require __DIR__ . '/../db/db.php';

$date = $_GET['date'] ?? null;
if(!$date) exit;

$stmt = $pdo->query("
    SELECT m.name,
      (SELECT COUNT(*) FROM appointments a
       WHERE a.mechanic_id = m.id AND a.appointment_date = '$date') AS booked,
      (4 - (SELECT COUNT(*) FROM appointments a
       WHERE a.mechanic_id = m.id AND a.appointment_date = '$date')) AS remaining
    FROM mechanics m
    ORDER BY m.name
");

echo json_encode($stmt->fetchAll());
