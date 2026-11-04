# Testing Report

## Automated checks run during development
- Playwright (Chromium) smoke test at 375px: carousel advances, rating stars work, no horizontal scroll, form validation fires for 5 empty required fields and success message appears for valid input, 0 JS errors.

## Cross-browser checklist (complete before presentation)
| Feature | Chrome | Firefox | Edge | Safari |
|---|---|---|---|---|
| Layout (Grid/Flex) | ☐ | ☐ | ☐ | ☐ |
| Carousel | ☐ | ☐ | ☐ | ☐ |
| Booking validation (date/time inputs) | ☐ | ☐ | ☐ | ☐ |
| Map embed | ☐ | ☐ | ☐ | ☐ |
| Rating stars | ☐ | ☐ | ☐ | ☐ |

## Responsive check (DevTools → Device toolbar)
320, 375 (iPhone SE/12), 414, 768 (iPad), 1024, 1440, 1920 px — verify no horizontal scroll, nav toggles below 960px.

## Lighthouse
Chrome DevTools → Lighthouse → run Mobile + Desktop on index, menu and contact. Record scores below.
| Page | Perf | A11y | Best Practices | SEO |
|---|---|---|---|---|
| index | | | | |
| menu | | | | |
| contact | | | | |
Tip: the Google Maps iframe may lower Best Practices slightly (third-party cookies).
