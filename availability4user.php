<?php
require __DIR__ . '/db/db.php';
header('Content-Type: application/json');

$mechanic_id = isset($_POST['mechanic_id']) ? (int)$_POST['mechanic_id'] : 0;
$date = $_POST['date'] ?? null;

if (!$mechanic_id || !$date || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
    echo json_encode(['error' => 'Missing or invalid mechanic/date']);
    exit;
}

try {
    $stmt = $pdo->prepare("SELECT capacity, name FROM mechanics WHERE id = ?");
    $stmt->execute([$mechanic_id]);
    $mech = $stmt->fetch();
    if (!$mech) {
        echo json_encode(['error' => 'Mechanic not found']);
        exit;
    }
    $capacity = (int)$mech['capacity'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE mechanic_id = ? AND appointment_date = ?");
    $stmt->execute([$mechanic_id, $date]);
    $count = (int)$stmt->fetchColumn();
    $remaining = max(0, $capacity - $count);

    echo json_encode([
        'mechanic'    => $mech['name'],
        'capacity'    => $capacity,
        'booked'      => $count,
        'slots_left'  => $remaining,
        'can_book'    => $remaining > 0,
        'status'      => $remaining > 0 ? 'Available' : 'Fully booked'
    ]);
} catch (Exception $e) {
    echo json_encode(['error' => 'Server error']);
}
?>