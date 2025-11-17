<?php
require __DIR__ . '/db/db.php';
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Appointment Booked — GariMD</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include __DIR__ . '/components/navbar.php'; ?>

<main class="wrap">
    <section class="card" style="max-width: 600px; margin: 40px auto; text-align:center;">
        <h2>Appointment Booked</h2>
        <p>Your appointment has been booked successfully.</p>
        <p><a class="btn" href="index.php">Book Another Appointment</a></p>
    </section>
</main>

<footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
