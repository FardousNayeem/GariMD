<?php
require __DIR__ . '/db/db.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Help — MechaApp</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="site-header"><div class="wrap"><h1>MechaApp</h1><nav><a href="index.php">Home</a> | <a href="admin/login.php">Admin</a></nav></div></header>
  <main class="wrap">
    <section class="card">
      <h2>Help & FAQ</h2>
      <h3>How to book</h3>
      <ol>
        <li>Open the booking form on the Home page.</li>
        <li>Fill your name, phone, address (optional), car registration and engine number, select date and mechanic.</li>
        <li>The system shows how many slots that mechanic has on the chosen date.</li>
        <li>Submit. If all checks pass, you'll be redirected to confirmation.</li>
      </ol>

      <h3>Rules</h3>
      <ul>
        <li>Each mechanic can take <strong>4 appointments per day</strong>.</li>
        <li>A particular <strong>car (engine number)</strong> cannot be booked more than once on the same date (prevent duplicate bookings for same car).</li>
        <li>If you wish to take appointmentments for multiple cars, kindly book each car separately.</li>
      </ul>

      <h3>Common issues</h3>
      <p><strong>Mechanic fully booked:</strong> Choose another mechanic or another date.</p>
      <p><strong>Car already booked on same date:</strong> You cannot book that same car again that day.</p>

      <h3>Contact</h3>
      <p>If you face issues, please contact the admin at 
        <a href="mailto:fardous.nayeem@g.bracu.ac.bd" class="mail-link">
            fardous.nayeem@g.bracu.ac.bd
        </a>
      </p>

    </section>
  </main>
  <footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
