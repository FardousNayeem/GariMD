<?php
session_start();

$summary = $_SESSION['last_appointment'] ?? null;

unset($_SESSION['last_appointment']);
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Booked — GariMD</title>
    <link rel="stylesheet" href="assets/style.css">
    <meta http-equiv="refresh" content="6; url=index.php">
</head>
<body>

<?php include __DIR__ . '/components/navbar.php'; ?>

<main class="wrap center-page">
    <section class="card success-container">

        <h2>Appointment Confirmed!</h2>
        <p>Your appointment has been booked successfully.</p>

        <?php if ($summary): ?>
            <div class="summary-box">
                <p><strong>Name:</strong> <?= htmlspecialchars($summary['client_name']) ?></p>
                <p><strong>Car Registration:</strong> <?= htmlspecialchars($summary['car_license']) ?></p>
                <p><strong>Engine Number:</strong> <?= htmlspecialchars($summary['car_engine']) ?></p>
                <p><strong>Date:</strong> <?= htmlspecialchars($summary['appointment_date']) ?></p>
                <p><strong>Mechanic:</strong> <?= htmlspecialchars($summary['mechanic']) ?></p>
            </div>
        <?php endif; ?>

        <p><a class="btn" href="index.php">Book Another Appointment</a></p>

        <p class="redirect-note">You will be redirected back to the homepage in 6 seconds…</p>
    </section>
</main>

</body>
</html>
