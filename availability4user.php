<?php
require __DIR__ . '/db/db.php';
header('Content-Type: application/json');

$mechanic_id = $_POST['mechanic_id'] ?? null;
$date = $_POST['date'] ?? null;

if(!$mechanic_id || !$date) {
    echo json_encode(['error' => 'Missing mechanic or date']);
    exit;
}

try {
    $capacity = 4;

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE mechanic_id = ? AND appointment_date = ?");
    $stmt->execute([$mechanic_id, $date]);
    $count = (int)$stmt->fetchColumn();

    $remaining = max(0, $capacity - $count);

    echo json_encode([
        'capacity' => $capacity,
        'slots_left' => $remaining,
        'can_book' => $remaining > 0,
        'message' => $remaining > 0 ? 'Available' : 'Fully booked'
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
