<?php
require __DIR__ . '/db/db.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>MechaApp — Book Appointment</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <header class="site-header">
    <div class="wrap">
      <h1>MechaApp</h1>
      <nav><a href="help.php">Help</a> | <a href="admin/login.php">Admin</a></nav>
    </div>
  </header>

  <main class="wrap">
    <section class="card">
      <h2>Book an Appointment</h2>
      <form id="bookingForm" method="post" action="submit.php" novalidate>
        <div class="grid">
          <label>
            Name <input type="text" name="client_name" required>
          </label>
          <label>
            Phone <input type="text" name="phone" required placeholder="digits only">
          </label>
          <label class="full">
            Address <textarea name="address" rows="2"></textarea>
          </label>
          <label>
            Car Registration No <input type="text" name="car_license" required>
          </label>
          <label>
            Car Engine No <input type="text" name="car_engine" required placeholder="unique engine number">
          </label>
          <label>
            Appointment Date <input type="date" name="appointment_date" id="appointment_date" required>
          </label>
          <label>
            Preferred Mechanic
            <select name="mechanic_id" id="mechanic_id" required>
              <option value="">-- Select mechanic --</option>
              <?php
                $stmt = $pdo->query("SELECT id, name, capacity FROM mechanics ORDER BY name");
                while ($m = $stmt->fetch()) {
                  echo "<option value=\"{$m['id']}\">".htmlspecialchars($m['name'])."</option>";
                }
              ?>
            </select>
          </label>
        </div>

        <div id="availability" class="availability"></div>

        <div class="actions">
          <button type="submit" class="btn">Book Appointment</button>
        </div>
      </form>
    </section>

    <aside class="card small">
      <h3>Quick info</h3>
      <p>Each mechanic has a default of 4 slots per day. Admin can change capacities.</p>
      <p>If you have multiple cars, you can book for each car separately.</p>
    </aside>
  </main>

  <footer class="wrap footer">© MechaApp</footer>

  <script src="assets/app.js"></script>
</body>
</html>
