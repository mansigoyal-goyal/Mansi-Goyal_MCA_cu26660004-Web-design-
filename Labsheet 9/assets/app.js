// Task 10: delete confirmation
document.querySelectorAll('.delete-form').forEach(f => {
  f.addEventListener('submit', ev => {
    if (!confirm('Are you sure you want to delete this item? This cannot be undone.')) ev.preventDefault();
  });
});

// Task 20: live search suggestions using fetch()
const box = document.getElementById('search-box');
const list = document.getElementById('suggestions');
if (box && list) {
  let timer;
  box.addEventListener('input', () => {
    clearTimeout(timer);
    const q = box.value.trim();
    if (q.length < 2) { list.innerHTML = ''; return; }
    timer = setTimeout(async () => {
      try {
        const res = await fetch('suggest.php?q=' + encodeURIComponent(q));
        const items = await res.json();
        list.innerHTML = '';
        items.forEach(name => {
          const d = document.createElement('div');
          d.textContent = name;                 // textContent prevents XSS
          d.onclick = () => { box.value = name; list.innerHTML = ''; };
          list.appendChild(d);
        });
      } catch (err) { console.error(err); }
    }, 250);
  });
  document.addEventListener('click', e => { if (e.target !== box) list.innerHTML = ''; });
}
