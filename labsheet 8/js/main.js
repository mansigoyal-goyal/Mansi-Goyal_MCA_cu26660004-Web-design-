/**
 * Hearth & Crumb Bakery — site-wide behaviour
 * 1. Mobile navigation toggle
 * 2. Hero carousel (autoplay, arrows, dots, keyboard, pause on hover/focus)
 * 3. Interactive testimonial rating stars (saved in localStorage)
 * 4. Social share buttons (built from the current page URL)
 */
(function () {
  'use strict';

  /* ---------- 1. Mobile nav ---------- */
  var toggle = document.querySelector('.nav-toggle');
  var nav = document.getElementById('site-nav');
  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
    });
  }

  /* ---------- 2. Carousel ---------- */
  var carousel = document.querySelector('[data-carousel]');
  if (carousel) {
    var track = carousel.querySelector('.carousel__track');
    var slides = carousel.querySelectorAll('.carousel__slide');
    var dotsBox = carousel.querySelector('.carousel__dots');
    var index = 0;
    var timer = null;
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Build one dot button per slide
    slides.forEach(function (_, i) {
      var dot = document.createElement('button');
      dot.className = 'carousel__dot';
      dot.type = 'button';
      dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
      dot.addEventListener('click', function () { goTo(i); });
      dotsBox.appendChild(dot);
    });
    var dots = dotsBox.querySelectorAll('.carousel__dot');

    function goTo(i) {
      index = (i + slides.length) % slides.length;
      track.style.transform = 'translateX(-' + index * 100 + '%)';
      slides.forEach(function (s, n) { s.setAttribute('aria-hidden', String(n !== index)); });
      dots.forEach(function (d, n) { d.setAttribute('aria-current', String(n === index)); });
    }
    function start() {
      if (reduceMotion) return;            // respect user motion preference
      stop();
      timer = setInterval(function () { goTo(index + 1); }, 5000);
    }
    function stop() { clearInterval(timer); }

    carousel.querySelector('[data-prev]').addEventListener('click', function () { goTo(index - 1); });
    carousel.querySelector('[data-next]').addEventListener('click', function () { goTo(index + 1); });
    carousel.addEventListener('mouseenter', stop);
    carousel.addEventListener('mouseleave', start);
    carousel.addEventListener('focusin', stop);
    carousel.addEventListener('focusout', start);
    carousel.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowLeft') goTo(index - 1);
      if (e.key === 'ArrowRight') goTo(index + 1);
    });
    goTo(0);
    start();
  }

  /* ---------- 3. Rating stars ---------- */
  document.querySelectorAll('[data-rating]').forEach(function (group) {
    var id = group.getAttribute('data-rating');
    var stars = group.querySelectorAll('button');
    var status = group.parentNode.querySelector('.stars__status');

    function paint(value) {
      stars.forEach(function (s, i) {
        s.classList.toggle('is-on', i < value);
        s.setAttribute('aria-pressed', String(i + 1 === value));
      });
      status.textContent = value ? 'You rated this ' + value + ' out of 5.' : 'Click a star to rate.';
    }
    var saved = 0;
    try { saved = parseInt(localStorage.getItem('rating-' + id), 10) || 0; } catch (e) { /* storage blocked */ }
    paint(saved);

    stars.forEach(function (s, i) {
      s.addEventListener('click', function () {
        paint(i + 1);
        try { localStorage.setItem('rating-' + id, String(i + 1)); } catch (e) { /* ignore */ }
      });
      // Hover preview
      s.addEventListener('mouseenter', function () {
        stars.forEach(function (x, n) { x.classList.toggle('is-on', n <= i); });
      });
    });
    group.addEventListener('mouseleave', function () {
      var current = 0;
      stars.forEach(function (x, n) { if (x.getAttribute('aria-pressed') === 'true') current = n + 1; });
      paint(current);
    });
  });

  /* ---------- 4. Share buttons ---------- */
  var url = encodeURIComponent(window.location.href);
  var text = encodeURIComponent(document.title);
  var targets = {
    facebook: 'https://www.facebook.com/sharer/sharer.php?u=' + url,
    x: 'https://twitter.com/intent/tweet?url=' + url + '&text=' + text,
    whatsapp: 'https://wa.me/?text=' + text + '%20' + url
  };
  document.querySelectorAll('[data-share]').forEach(function (a) {
    a.href = targets[a.getAttribute('data-share')];
  });
})();
