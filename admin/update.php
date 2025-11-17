<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require '../db.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: dashboard.php'); exit; }

$action = $_POST['action'] ?? '';

// update capacity
if($action === 'update_capacity' && isset($_POST['id'], $_POST['capacity'])) {
    $id = (int)$_POST['id']; $cap = (int)$_POST['capacity'];
    $stmt = $pdo->prepare("UPDATE mechanics SET capacity = ? WHERE id = ?");
    $stmt->execute([$cap, $id]);
    header('Location: dashboard.php'); exit;
}

// update appointment (from edit.php)
if($action === 'update_appointment' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $date = $_POST['appointment_date'];
    $mechanic_id = (int)$_POST['mechanic_id'];

    // check mechanic capacity for that date (excluding this appointment)
    $stmt = $pdo->prepare("SELECT capacity FROM mechanics WHERE id = ?");
    $stmt->execute([$mechanic_id]);
    $cap = (int)$stmt->fetchColumn();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE mechanic_id = ? AND appointment_date = ? AND id != ?");
    $stmt->execute([$mechanic_id, $date, $id]);
    $count = (int)$stmt->fetchColumn();
    if($count >= $cap) {
        $_SESSION['err'] = 'Mechanic is full for that date.';
        header("Location: edit.php?id=$id"); exit;
    }

    // update
    $stmt = $pdo->prepare("UPDATE appointments SET appointment_date = ?, mechanic_id = ? WHERE id = ?");
    $stmt->execute([$date, $mechanic_id, $id]);
    header('Location: dashboard.php'); exit;
}

header('Location: dashboard.php');
