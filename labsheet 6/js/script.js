document.addEventListener("DOMContentLoaded", () => {
  // Q4: Mobile hamburger menu.
  document.querySelectorAll(".menu-toggle").forEach(button => {
    button.addEventListener("click", () => {
      const menu = button.parentElement.querySelector(".nav-links");
      const opened = menu.classList.toggle("open");
      button.setAttribute("aria-expanded", String(opened));
      button.textContent = opened ? "×" : "☰";
    });
  });

  // Q6: Contact form validation.
  const form = document.getElementById("validateForm");
  if (form) form.addEventListener("submit", event => {
    event.preventDefault();
    const name = document.getElementById("vName").value.trim();
    const email = document.getElementById("vEmail").value.trim();
    const message = document.getElementById("vMessage").value.trim();
    const validEmail = /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(email);
    document.getElementById("vNameError").textContent = name ? "" : "Name is required.";
    document.getElementById("vEmailError").textContent = !email ? "Email is required." : (!validEmail ? "Enter a valid email." : "");
    document.getElementById("vMessageError").textContent = message ? "" : "Message is required.";
    const success = document.getElementById("vSuccess");
    if (name && validEmail && message) { success.textContent = "Form validated successfully!"; form.reset(); }
    else success.textContent = "";
  });

  // Q7: Toggle light and dark themes using CSS root variables.
  document.getElementById("themeButton")?.addEventListener("click", () => {
    document.body.classList.toggle("dark-theme");
  });

  // Q10: FAQ accordion.
  document.querySelectorAll(".faq-question").forEach(button => {
    button.addEventListener("click", () => {
      const item = button.closest(".faq-item");
      const opened = item.classList.toggle("open");
      button.querySelector("span").textContent = opened ? "−" : "+";
    });
  });

  // Q11: Testimonial carousel using a JavaScript array.
  const quotes = [
    { text: "Excellent work and very professional.", name: "Aditi" },
    { text: "The website looks clean and works smoothly.", name: "Rahul" },
    { text: "Great communication and a wonderful result.", name: "Simran" }
  ];
  let quoteIndex = 0;
  function renderQuote() {
    const text = document.getElementById("quoteText");
    if (!text) return;
    text.style.opacity = 0;
    setTimeout(() => {
      text.textContent = "“" + quotes[quoteIndex].text + "”";
      document.getElementById("quoteName").textContent = "— " + quotes[quoteIndex].name;
      document.getElementById("quoteCount").textContent = (quoteIndex + 1) + " / " + quotes.length;
      text.style.opacity = 1;
    }, 150);
  }
  document.getElementById("previousQuote")?.addEventListener("click", () => {
    quoteIndex = (quoteIndex - 1 + quotes.length) % quotes.length; renderQuote();
  });
  document.getElementById("nextQuote")?.addEventListener("click", () => {
    quoteIndex = (quoteIndex + 1) % quotes.length; renderQuote();
  });

  // Q13: Back-to-top button.
  const backTop = document.getElementById("backTop");
  if (backTop) {
    window.addEventListener("scroll", () => backTop.classList.toggle("visible", window.scrollY > 250));
    backTop.addEventListener("click", () => window.scrollTo({ top: 0, behavior: "smooth" }));
  }

  // Q15: Animate counters when they enter the viewport.
  const counters = document.querySelectorAll(".counter");
  if ("IntersectionObserver" in window && counters.length) {
    const observer = new IntersectionObserver(entries => entries.forEach(entry => {
      if (entry.isIntersecting) {
        const element = entry.target, target = Number(element.dataset.target);
        let value = 0;
        const step = Math.max(1, Math.ceil(target / 60));
        const timer = setInterval(() => {
          value = Math.min(value + step, target);
          element.textContent = value;
          if (value >= target) clearInterval(timer);
        }, 25);
        observer.unobserve(element);
      }
    }), { threshold: 0.4 });
    counters.forEach(counter => observer.observe(counter));
  }

  // Q17: Modal opens and closes with X, outside click or Escape.
  const modal = document.getElementById("demoModal");
  document.getElementById("showModal")?.addEventListener("click", () => {
    modal.classList.add("open"); modal.setAttribute("aria-hidden", "false");
  });
  const closeModal = () => { modal?.classList.remove("open"); modal?.setAttribute("aria-hidden", "true"); };
  document.getElementById("hideModal")?.addEventListener("click", closeModal);
  modal?.addEventListener("click", event => { if (event.target === modal) closeModal(); });
  document.addEventListener("keydown", event => { if (event.key === "Escape") closeModal(); });

  // Q19: Filter project cards while typing.
  const filter = document.getElementById("projectFilter");
  if (filter) filter.addEventListener("input", () => {
    const term = filter.value.toLowerCase().trim();
    const items = document.querySelectorAll(".project-item");
    let count = 0;
    items.forEach(item => {
      const text = (item.dataset.keywords + " " + item.textContent).toLowerCase();
      const match = text.includes(term);
      item.hidden = !match;
      if (match) count++;
    });
    document.getElementById("filterEmpty").hidden = count > 0;
  });
});
