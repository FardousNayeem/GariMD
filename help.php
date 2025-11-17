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
        <li>Each mechanic has a default of <strong>4 slots/day</strong>. Admin can change this.</li>
        <li>A particular <strong>car (engine number)</strong> cannot be booked more than once on the same date (prevent duplicate bookings for same car).</li>
        <li>If you own multiple cars, you may book each car separately.</li>
      </ul>

      <h3>Common issues</h3>
      <p><strong>Mechanic fully booked:</strong> Choose another mechanic or another date.</p>
      <p><strong>Car already booked on same date:</strong> You cannot book that same car again that day.</p>

      <h3>Contact</h3>
      <p>If you face issues while testing, contact your lab instructor or the person in-charge with screenshots of your form and any server error messages.</p>

      <h3>Admin help</h3>
      <p>To manage appointments, go to <code>/admin</code> and login with admin credentials (provided by instructor or configured in the app). From the dashboard you can view, edit appointments and change mechanic capacities.</p>
    </section>
  </main>
  <footer class="wrap footer">© MechaApp — Help</footer>
</body>
</html>
