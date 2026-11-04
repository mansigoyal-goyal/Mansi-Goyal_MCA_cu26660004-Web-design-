# Hearth & Crumb Bakery — MCA108P Lab Project

Responsive 3-page website (HTML5, CSS Grid/Flexbox, vanilla JS) for a fictional artisan bakery.

## Run in VS Code
1. Unzip and open the folder: **File → Open Folder**.
2. Install the **Live Server** extension, right-click `index.html` → **Open with Live Server**.
   (Or in the terminal: `npx http-server . -p 8080` and visit http://localhost:8080.)

## Edit & rebuild minified assets
Pages load `css/styles.min.css` and `js/*.min.js`. After editing the unminified sources:
```
npm install
npm run build
```

## Structure
- `index.html`, `menu.html`, `contact.html`
- `css/styles.css` (source) · `js/main.js`, `js/booking.js` (source)
- `images/` SVG artwork (tiny file sizes)
- `docs/` specification, design rationale, testing report, slide outline

## Lighthouse audit
Open the site in Chrome → DevTools (F12) → Lighthouse → Analyze. Record results in `docs/03-testing-report.md`.

Note: the Google Map uses the keyless embed URL, so it needs an internet connection.
