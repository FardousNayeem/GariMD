document.addEventListener('DOMContentLoaded', function(){
  const mechSelect = document.getElementById('mechanic_id');
  const dateInput = document.getElementById('appointment_date');
  const availability = document.getElementById('availability');
  const form = document.getElementById('bookingForm');

  function checkAvailability() {
    const mech = mechSelect.value;
    const date = dateInput.value;
    availability.innerHTML = '';
    if(!mech || !date) return;

    const fd = new FormData();
    fd.append('mechanic_id', mech);
    fd.append('date', date);

    fetch('availability4user.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(data => {
        if(data.error) {
          availability.innerHTML = `<div class="err">${data.error}</div>`;
        } else {
          availability.innerHTML = `<div>Slots left: <strong>${data.slots_left}</strong> / ${data.capacity}</div>`;

          const submitBtn = document.querySelector('.btn');

          if (!data.can_book) {
              availability.innerHTML += `<div class="error-box">
                  This mechanic is fully booked on ${date}. Please choose another mechanic.
              </div>`;
              submitBtn.disabled = true;
              submitBtn.style.opacity = "0.6";
          } else {
              submitBtn.disabled = false;
              submitBtn.style.opacity = "1";
          }

        }
      })
      .catch(() => {
        availability.innerHTML = '<div class="err">Could not check availability.</div>';
      });
  }

  mechSelect.addEventListener('change', checkAvailability);
  dateInput.addEventListener('change', checkAvailability);

  form.addEventListener('submit', function(e){
    const phone = form.phone.value.trim();
    const engine = form.car_engine.value.trim();
    if(!/^\d{6,15}$/.test(phone)) {
      e.preventDefault();
      alert('Enter a valid phone (6-15 digits).');
      return;
    }
    if(!/^[0-9A-Za-z\-]+$/.test(engine)) {
      e.preventDefault();
      alert('Enter a valid car engine number (alphanumeric).');
      return;
    }
  });
});
