# Project Specification & Wireframes — Hearth & Crumb Bakery (fictional client)

**Course:** MCA108P  **Client:** Hearth & Crumb, an artisan bakery in Old Town, Pune.

## Goals
1. Showcase products, team and reviews. 2. Let guests reserve a table online. 3. Make the bakery easy to find.

## Target audience
Local professionals (25–45), families on weekends, students needing a café workspace. Mostly mobile users.

## Pages
| Page | Purpose | Key sections |
|---|---|---|
| index.html | Brand + conversion | Hero carousel, intro, signature bakes, team, testimonials with star ratings |
| menu.html | Offerings | Bread, pastry, coffee lists with prices |
| contact.html | Visit & book | Reservation form (validated), Google Map, address, hours |
| All pages | Shared | Header/nav, footer with social feed + share buttons |

## Wireframes (mobile-first)
```
MOBILE (375px)            DESKTOP (≥960px)
+----------------+        +-------------------------------------+
| logo   [Menu]  |        | logo        Home Menu Visit&Book    |
+----------------+        +-------------------------------------+
| HERO CAROUSEL  |        |            HERO CAROUSEL            |
| < o o o >      |        |              < o o o >              |
+----------------+        +-------------------------------------+
| Intro + CTA    |        | Intro + CTA                         |
| [card]         |        | [card] [card] [card]                |
| [card]         |        | [team] [team] [team]                |
| [team]...      |        | [review][review][review]            |
| [review]...    |        +-------------------------------------+
| FOOTER stacked |        | FOOTER: visit | feed | share        |
+----------------+        +-------------------------------------+
Contact page desktop: form (left) | map + address (right)
```

## Functional requirements
- Carousel: autoplay 5s, arrows, dots, keyboard, pause on hover/focus, honours reduced-motion.
- Booking form: required fields, email/phone patterns, future dates only, guests 1–12.
- Rating stars persisted in localStorage.
- SEO: unique title, description, canonical and Open Graph on every page.

## Non-functional requirements
WCAG 2.1 AA, Lighthouse ≥ 90 in all categories, minified CSS/JS, responsive 320px–1920px, Chrome/Firefox/Edge/Safari.
