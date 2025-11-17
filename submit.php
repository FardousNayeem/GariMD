<?php
require __DIR__ . '/db/db.php';

function fail($msg) {
    echo "<p style='color:red;'>Error: " . htmlspecialchars($msg) . "</p>";
    echo "<p><a href='index.php'>Go back</a></p>";
    exit;
}

$required = ['client_name','phone','car_license','car_engine','appointment_date','mechanic_id'];
foreach($required as $r) {
    if(empty($_POST[$r])) fail("Please fill all required fields.");
}

// sanitize
$client_name = trim($_POST['client_name']);
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone']);
$car_license = trim($_POST['car_license']);
$car_engine = trim($_POST['car_engine']);
$date = $_POST['appointment_date'];
$mechanic_id = (int)$_POST['mechanic_id'];

// basic validation
if(!preg_match('/^\d{6,15}$/', $phone)) fail('Phone must be digits (6-15).');
if(!preg_match('/^[0-9A-Za-z\-]+$/', $car_engine)) fail('Invalid engine number.');

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("SELECT capacity FROM mechanics WHERE id = ? FOR UPDATE");
    $stmt->execute([$mechanic_id]);
    $row = $stmt->fetch();
    if(!$row) {
        $pdo->rollBack();
        fail('Mechanic not found.');
    }
    $capacity = (int)$row['capacity'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE mechanic_id = ? AND appointment_date = ?");
    $stmt->execute([$mechanic_id, $date]);
    $count = (int)$stmt->fetchColumn();

    if($count >= $capacity) {
        $pdo->rollBack();
        fail("This mechanic is fully booked. Please choose another mechanic or date.");
    }

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM appointments WHERE car_engine = ? AND appointment_date = ?");
    $stmt->execute([$car_engine, $date]);
    if((int)$stmt->fetchColumn() > 0) {
        $pdo->rollBack();
        fail('This car already has an appointment on that date.');
    }

    $stmt = $pdo->prepare("INSERT INTO appointments
      (client_name, address, phone, car_license, car_engine, appointment_date, mechanic_id)
      VALUES (?,?,?,?,?,?,?)");
    $stmt->execute([$client_name,$address,$phone,$car_license,$car_engine,$date,$mechanic_id]);

    $pdo->commit();

    header('Location: success.php');
    exit;
} catch (Exception $e) {
    if($pdo->inTransaction()) $pdo->rollBack();
    fail('Server error: ' . $e->getMessage());
}

?>