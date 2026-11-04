/**
 * Hearth & Crumb Bakery — table reservation form
 * Client-side validation only (no server). Errors are announced
 * to screen readers via aria-invalid + aria-describedby + role="alert".
 */
(function () {
  'use strict';

  var form = document.getElementById('booking-form');
  if (!form) return;

  var success = document.getElementById('booking-success');
  var dateInput = form.elements.date;

  // Disallow past dates
  var today = new Date();
  dateInput.min = today.toISOString().split('T')[0];

  /* Each rule returns an error message, or '' when valid. */
  var rules = {
    name: function (v) { return v.trim().length >= 2 ? '' : 'Please enter your full name.'; },
    email: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(v) ? '' : 'Enter a valid email, e.g. you@example.com.'; },
    phone: function (v) { return /^[+]?[\d\s-]{10,15}$/.test(v.trim()) ? '' : 'Enter a phone number with 10–15 digits.'; },
    date: function (v) {
      if (!v) return 'Please choose a date.';
      return v < dateInput.min ? 'Date cannot be in the past.' : '';
    },
    time: function (v) { return v ? '' : 'Please choose a time.'; },
    guests: function (v) {
      var n = parseInt(v, 10);
      return n >= 1 && n <= 12 ? '' : 'Guests must be between 1 and 12.';
    }
  };

  function validateField(field) {
    var msg = rules[field.name](field.value);
    var err = document.getElementById(field.name + '-error');
    err.textContent = msg;
    field.setAttribute('aria-invalid', msg ? 'true' : 'false');
    return !msg;
  }

  // Validate on blur for fast feedback; re-validate while fixing
  Object.keys(rules).forEach(function (name) {
    var f = form.elements[name];
    f.addEventListener('blur', function () { validateField(f); });
    f.addEventListener('input', function () {
      if (f.getAttribute('aria-invalid') === 'true') validateField(f);
    });
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();
    var firstBad = null;
    Object.keys(rules).forEach(function (name) {
      var f = form.elements[name];
      if (!validateField(f) && !firstBad) firstBad = f;
    });
    if (firstBad) { firstBad.focus(); return; }

    // Demo only: a real site would POST to a server here.
    success.hidden = false;
    success.textContent = 'Thank you, ' + form.elements.name.value.trim() +
      '! Your table for ' + form.elements.guests.value + ' on ' + form.elements.date.value +
      ' at ' + form.elements.time.value + ' is requested. We will confirm by email.';
    form.reset();
    success.focus();
  });
})();
