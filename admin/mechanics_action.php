<?php
session_start();
if(!isset($_SESSION['admin_logged'])) exit;
require __DIR__ . '/../db/db.php';

$action = $_GET['action'] ?? $_POST['action'];

if($action === 'add') {
    $name = trim($_POST['name']);
    if($name !== "") {
        $stmt = $pdo->prepare("INSERT INTO mechanics(name, capacity) VALUES(?, 4)");
        $stmt->execute([$name]);
    }
    header("Location: mechanics.php");
    exit;
}

if($action === 'delete') {
    $id = (int)$_GET['id'];
    $pdo->prepare("DELETE FROM mechanics WHERE id = ?")->execute([$id]);
    header("Location: mechanics.php");
    exit;
}
