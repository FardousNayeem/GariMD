document.addEventListener('DOMContentLoaded', function(){
  const mechSelect  = document.getElementById('mechanic_id');
  const dateInput   = document.getElementById('appointment_date');
  const availability= document.getElementById('availability');
  const form        = document.getElementById('bookingForm');
  const submitBtn   = document.getElementById('submitBtn') || document.querySelector('#bookingForm .btn');

  const today = new Date();
  const tzIso = new Date(today.getTime() - (today.getTimezoneOffset() * 60000)).toISOString().slice(0,10);
  if (dateInput) dateInput.setAttribute('min', tzIso);

  let timer;
  const debounce = (fn, ms=250) => { clearTimeout(timer); timer = setTimeout(fn, ms); };

  function clearAvailability(){
    availability?.classList.add('hidden');
    if (availability) availability.innerHTML = '';
    if (submitBtn) {
      submitBtn.disabled = false;
      submitBtn.classList.remove('btn-disabled');
    }
  }

  function renderAvailabilityCard(data, date){
    if (!availability) return;
    const percent = data.capacity ? Math.round((data.booked / data.capacity) * 100) : 0;
    const full = !data.can_book;

    availability.classList.remove('hidden');
    availability.innerHTML = `
      <div class="availability-head">
        <div>
          <div class="label">Availability for</div>
          <div class="value">${data.mechanic || 'Selected mechanic'} — ${date}</div>
        </div>
        <span class="badge ${full ? 'badge-danger' : 'badge-ok'}">${full ? 'Full' : 'Open'}</span>
      </div>

      <div class="progress">
        <div class="progress-bar" style="width:${percent}%"></div>
      </div>

      <div class="availability-stats">
        <div><span class="stat">${data.booked}</span><span class="muted">Booked</span></div>
        <div><span class="stat">${data.slots_left}</span><span class="muted">Slots Left</span></div>
        <div><span class="stat">${data.capacity}</span><span class="muted">Capacity</span></div>
      </div>
    `;

    const isPast = date < tzIso;
    if (submitBtn) {
      submitBtn.disabled = full || isPast;
      submitBtn.classList.toggle('btn-disabled', submitBtn.disabled);
    }
  }

  function checkAvailability() {
    const mech = mechSelect?.value;
    const date = dateInput?.value;
    if (!availability) return;

    if(!mech || !date){ clearAvailability(); return; }

    const fd = new FormData();
    fd.append('mechanic_id', mech);
    fd.append('date', date);

    fetch('availability4user.php', { method: 'POST', body: fd })
      .then(r => r.json())
      .then(data => {
        if (data && !data.error) {
          renderAvailabilityCard(data, date);
        } else {
          availability.classList.remove('hidden');
          availability.innerHTML = `<div class="error-box">Could not check availability.</div>`;
          if (submitBtn) submitBtn.disabled = true;
        }
      })
      .catch(() => {
        availability.classList.remove('hidden');
        availability.innerHTML = `<div class="error-box">Network error while checking availability.</div>`;
        if (submitBtn) submitBtn.disabled = true;
      });
  }

  mechSelect?.addEventListener('change', () => debounce(checkAvailability));
  dateInput?.addEventListener('change', () => debounce(checkAvailability));

  form?.addEventListener('submit', function(e){
    const phone  = form.phone.value.trim();
    const engine = form.car_engine.value.trim();

    if(!/^\d{6,15}$/.test(phone)) { e.preventDefault(); alert('Enter a valid phone (6-15 digits).'); return; }
    if(!/^[0-9A-Za-z\-]+$/.test(engine)) { e.preventDefault(); alert('Enter a valid car engine number (alphanumeric).'); return; }
    if(dateInput.value < tzIso) { e.preventDefault(); alert('Date cannot be in the past.'); return; }
  });
});
