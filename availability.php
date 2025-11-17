<?php
// db/availibility.php - AJAX: checks mechanic slots and returns JSON
require __DIR__ . '/db/db.php';
header('Content-Type: application/json');

$mechanic_id = $_POST['mechanic_id'] ?? null;
$date = $_POST['date'] ?? null;

if(!$mechanic_id || !$date) {
    echo json_encode(['error' => 'Missing mechanic or date']);
    exit;
}

try {
    // get capacity
    $stmt = $pdo->prepare("SELECT capacity FROM mechanics WHERE id = ?");
    $stmt->execute([$mechanic_id]);
    $row = $stmt->fetch();
    if(!$row) {
        echo json_encode(['error' => 'Mechanic not found']);
        exit;
    }
    $capacity = (int)$row['capacity'];

    // count appointments
    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM appointments WHERE mechanic_id = ? AND appointment_date = ?");
    $stmt->execute([$mechanic_id, $date]);
    $cnt = (int)$stmt->fetchColumn();
    $slots_left = max(0, $capacity - $cnt);

    echo json_encode([
        'capacity' => $capacity,
        'slots_left' => $slots_left,
        'can_book' => $slots_left > 0,
        'message' => $slots_left > 0 ? 'Mechanic has available slots' : 'Mechanic fully booked'
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>