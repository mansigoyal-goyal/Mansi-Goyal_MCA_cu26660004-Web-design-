# Design Rationale

## Audience alignment
Warm, calm and honest — the look of a neighbourhood bakery rather than a chain. Large tap targets (44px+) and a single-column mobile layout serve guests browsing on phones.

## Colour palette (WCAG contrast)
| Token | Hex | Use | Contrast |
|---|---|---|---|
| Cream | #FFF8F0 | Background | — |
| Brown | #3B2416 | Body text | ≈ 14:1 on cream |
| Crust | #8A3516 | Buttons, links | ≈ 7.5:1 on cream; 7.9:1 white-on-crust |
| Sage | #2F5D3A | Prices, focus ring | ≈ 7:1 on cream |
Inspired by baked crust, flour and herbs. All text pairs exceed AA (4.5:1); several reach AAA.

## Typography
Headings: Georgia (serif) for a crafted, traditional feel. Body: system UI sans-serif for speed (no font download) and legibility. Modular scale ratio 1.25 (0.875 → 2.44 rem). Line-height 1.6 for body.

## White space
8px spacing scale; 3–4rem vertical padding between sections; max line length 60ch.

## Layout
CSS Grid for card grids and page columns, Flexbox for header, carousel and menu rows. Breakpoints at 640px and 960px, written mobile-first.

## Accessibility
Landmarks (header/nav/main/footer), skip link, visible focus, alt text on all informative images (decorative logo uses empty alt), aria-live for rating and form messages, aria-invalid + role=alert errors, reduced-motion support.
