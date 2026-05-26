# Minimal Maison Theme

Luxury custom WordPress theme — Persian RTL, WooCommerce, Vite + Tailwind.

## Structure

```
minimal-maison/
├── style.css              # Theme metadata (required by WordPress)
├── functions.php          # Loads inc/
├── header.php / footer.php
├── front-page.php / index.php
├── inc/
│   ├── setup.php          # Supports, menus, image sizes
│   ├── assets.php         # Vite dev server + production manifest
│   └── woocommerce.php    # WooCommerce integration
├── template-parts/
├── resources/
│   ├── css/app.css        # Tailwind entry
│   └── js/app.js          # Vite entry
├── assets/                # Static files (images, fonts) — optional
├── dist/                  # Built assets (gitignored) — `npm run build`
├── package.json
├── vite.config.js
├── tailwind.config.js
└── postcss.config.js
```

## Frontend development

From this theme directory:

```bash
cd wordpress/wp-content/themes/minimal-maison
npm install
npm run dev
```

Vite runs at **http://localhost:5173**. WordPress (Docker) loads scripts from there when:

- `WP_ENVIRONMENT_TYPE` is `local`, and
- `dist/.vite/manifest.json` does not exist yet.

Open the site at **http://localhost:8080** (keep Vite running in a second terminal).

### Production build

```bash
npm run build
```

Creates `dist/.vite/manifest.json` + hashed assets. WordPress enqueues from `dist/` automatically.

To switch back to dev mode, delete the `dist/` folder or run dev without building.

## WordPress

Activate **Minimal Maison** under Appearance → Themes. Assign menus under Appearance → Menus.
