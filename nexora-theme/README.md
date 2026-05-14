# Nexora WordPress Theme

A modern, high-performance WordPress landing page theme.

## Installation

1. Upload the `nexora-theme` folder to `/wp-content/themes/`
2. Go to **Appearance → Themes** and activate **Nexora**
3. Go to **Settings → Reading** → set "Your homepage displays" to **A static page** → choose any page as Homepage
4. The landing page (`front-page.php`) will now display automatically

## Customization

All text content is editable via **Appearance → Customize**:
- **Hero Section** — badge, headline, subtitle, buttons, stats
- **CTA Section** — heading, subtitle, button labels
- **Footer** — description, copyright text

## Managing Content via WordPress Admin

### Features (6 cards)
Go to **Features** in the admin menu → Add New Feature
- **Title** = feature heading
- **Content** = description text
- Add a custom field `_feature_icon` with an emoji value (e.g. `🎨`)

### Testimonials
Go to **Testimonials** → Add New Testimonial
- **Title** = person's name
- **Content** = testimonial text
- Custom fields: `_testi_name`, `_testi_role`

### Pricing Plans
Go to **Pricing Plans** → Add New Plan
- Custom fields:
  - `_pricing_price` — number (e.g. `29`)
  - `_pricing_period` — text (e.g. `per month, billed annually`)
  - `_pricing_featured` — `1` for highlighted plan
  - `_pricing_features` — one feature per line
  - `_pricing_btn_text` — button label
  - `_pricing_btn_style` — `primary` or `ghost`

## Theme Files

```
nexora-theme/
├── style.css           ← Required theme header
├── functions.php       ← Theme setup, enqueue, CPTs, Customizer
├── index.php           ← Fallback template
├── front-page.php      ← Main landing page template
├── header.php          ← <head>, nav
├── footer.php          ← footer, wp_footer()
└── assets/
    ├── css/main.css    ← All styles
    └── js/main.js      ← Smooth scroll, mobile nav, scroll reveal
```

## Requirements
- WordPress 6.0+
- PHP 7.4+
