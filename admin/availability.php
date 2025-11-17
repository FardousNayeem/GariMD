<?php
session_start();
if(!isset($_SESSION['admin_logged'])) header('Location: login.php');
require __DIR__ . '/../db/db.php';
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Mechanic Availability — GariMD</title>
<link rel="stylesheet" href="../assets/style.css">
</head>
<body>

<?php include __DIR__ . '/../components/navbar.php'; ?>

<main class="wrap center-page">
  <section class="card">
    <h2>Mechanic Availability</h2>

    <label>Select Date:
      <input type="date" id="calendar_date">
    </label>

    <div id="calendar_result" style="margin-top:20px;"></div>
  </section>
</main>

<script>
document.getElementById('calendar_date').addEventListener('change', function(){
    const date = this.value;
    if(!date) return;

    fetch('availability_api.php?date=' + date)
      .then(r=>r.json())
      .then(data=>{
          let html = "<table class='tbl'><tr><th>Mechanic</th><th>Appointments</th><th>Remaining</th></tr>";
          data.forEach(row=>{
              html += `<tr>
                          <td>${row.name}</td>
                          <td>${row.booked}</td>
                          <td>${row.remaining}</td>
                       </tr>`;
          });
          html += "</table>";

          document.getElementById('calendar_result').innerHTML = html;
      });
});
</script>
<footer class="wrap footer">©2025 GariMD. Created by Fardous Nayeem</footer>

</body>
</html>
