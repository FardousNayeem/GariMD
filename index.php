<?php require __DIR__ . '/db/db.php'; ?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>GariMD — Book Appointment</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

<?php include __DIR__ . '/components/navbar.php'; ?>

<main class="wrap">
  <section class="card">
    <h2>Book an Appointment</h2>

    <form id="bookingForm" method="post" action="submit.php" novalidate>
      <div class="grid">
        <label>Name
          <input type="text" name="client_name" required placeholder="Enter your name">
        </label>

        <label>Phone
          <input type="text" name="phone" required placeholder="01969420420">
        </label>

        <label class="full">Address
          <textarea name="address" placeholder="Enter your address"></textarea>
        </label>

        <label>Car Registration Number
          <input type="text" name="car_license" required placeholder="Enter your registration number">
        </label>

        <label>Car Engine Number
          <input type="text" name="car_engine" required placeholder="Enter your engine number">
        </label>

        <label>Appointment Date
          <input type="date" name="appointment_date" id="appointment_date" required>
        </label>

        <label>Preferred Mechanic
          <select name="mechanic_id" id="mechanic_id" required>
            <option value="">   Select Mechanic   </option>
            <?php
              $stmt = $pdo->query("SELECT id, name FROM mechanics ORDER BY name");
              while ($m = $stmt->fetch()) {
                  echo "<option value='{$m['id']}'>".htmlspecialchars($m['name'])."</option>";
              }
            ?>
          </select>
        </label>
      </div>


      <div id="availability" class="availability-card hidden">
      </div>

      <button id="submitBtn" class="btn" type="submit">Book Appointment</button>
    </form>
  </section>

  <aside class="card small">
    <h3>Quick Info</h3>
    <p>Each mechanic takes <strong>4 appointments per day</strong>.</p>
    <p>If a mechanic is fully booked, try another mechanic or a different date.</p>
    <p>Check per-date availability from the menu.</p>
    <p>You may book multiple cars separately.</p>
  </aside>
</main>

<footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>
<script src="assets/app.js"></script>
</body>
</html>

