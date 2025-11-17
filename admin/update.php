<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: dashboard.php'); exit;
}

$action = $_POST['action'] ?? '';

if($action === 'update_capacity' && isset($_POST['id'], $_POST['capacity'])) {
    $id = (int)$_POST['id'];
    $cap = max(1, (int)$_POST['capacity']);
    $stmt = $pdo->prepare("UPDATE mechanics SET capacity = ? WHERE id = ?");
    $stmt->execute([$cap, $id]);
    header('Location: dashboard.php'); exit;
}

if($action === 'update_appointment' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $date = $_POST['appointment_date'];
    $mechanic_id = (int)$_POST['mechanic_id'];

    try {
        // atomic check: lock mechanic row
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("SELECT capacity FROM mechanics WHERE id = ? FOR UPDATE");
        $stmt->execute([$mechanic_id]);
        $r = $stmt->fetch();
        if(!$r) {
            $pdo->rollBack();
            $_SESSION['err'] = 'Mechanic not found.';
            header("Location: edit.php?id=$id"); exit;
        }
        $cap = (int)$r['capacity'];

        // count other appointments for that mechanic on date (exclude this appointment)
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE mechanic_id = ? AND appointment_date = ? AND id != ?");
        $stmt->execute([$mechanic_id, $date, $id]);
        $count = (int)$stmt->fetchColumn();
        if($count >= $cap) {
            $pdo->rollBack();
            $_SESSION['err'] = 'Mechanic is full for that date.';
            header("Location: edit.php?id=$id"); exit;
        }

        // ensure car isn't already booked on that date (exclude this appointment)
        $stmt = $pdo->prepare("SELECT car_engine FROM appointments WHERE id = ?");
        $stmt->execute([$id]);
        $car_engine = $stmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE car_engine = ? AND appointment_date = ? AND id != ?");
        $stmt->execute([$car_engine, $date, $id]);
        if((int)$stmt->fetchColumn() > 0) {
            $pdo->rollBack();
            $_SESSION['err'] = 'That car is already booked on that date.';
            header("Location: edit.php?id=$id"); exit;
        }

        // update
        $stmt = $pdo->prepare("UPDATE appointments SET appointment_date = ?, mechanic_id = ? WHERE id = ?");
        $stmt->execute([$date, $mechanic_id, $id]);
        $pdo->commit();
        header('Location: dashboard.php'); exit;
    } catch (Exception $e) {
        if($pdo->inTransaction()) $pdo->rollBack();
        $_SESSION['err'] = 'Server error: ' . $e->getMessage();
        header("Location: edit.php?id=$id"); exit;
    }
}

header('Location: dashboard.php');
