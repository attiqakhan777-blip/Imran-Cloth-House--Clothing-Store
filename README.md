# Imran Cloth House — Clothing Store

Full-stack ecommerce website for **Imran Cloth House**, a clothing brand serving quality unstitched clothes and fabrics since **1990**.

**Live site:** [https://www.imranclothhouse.com](https://www.imranclothhouse.com)

---

## About the project

This is a custom Laravel ecommerce application built for online clothing sales — products, cart, checkout, customer accounts, coupons, and a full admin panel to manage the store.

### What it includes

**Storefront**
- Home page with editable sections (hero, collections, etc.)
- Product catalog by gender, category, brand, and sale
- Product detail page with gallery, lightbox, and size/stock
- Cart, checkout, and order success flow
- Customer register / login / OTP password reset
- Favorites / wishlist
- Coupons (fixed Rs discount, one-time use, not on sale items)
- Static pages: About, Contact, FAQ, Policies, Store locator

**Admin panel**
- Dashboard (orders, revenue from delivered orders, charts)
- Products, categories, brands, attributes
- Coupons CRUD
- Orders management (pending / delivered / returned)
- Invoices
- Home page builder
- Shipping / settings

---

## Tech stack

| Layer | Technology |
|--------|------------|
| Backend | Laravel 13, PHP 8.3+ |
| Frontend | Blade templates, Tailwind CSS |
| Database | MySQL |
| Auth | Admin + Customer guards |
| Build | Vite (optional assets) |

---

## Project structure (main folders)

```
app/Http/Controllers/     # Admin + frontend controllers
app/Models/               # Eloquent models
resources/views/          # Blade UI (admin + storefront)
routes/web.php            # Web routes
database/migrations/      # Database schema
public/                   # Public entry + uploads
```

---

## Setup (local)

1. Clone the repo
```bash
git clone https://github.com/attiqakhan777-blip/Imran-Cloth-House--Clothing-Store.git
cd Imran-Cloth-House--Clothing-Store
```

2. Install PHP dependencies
```bash
composer install
```

3. Environment
```bash
cp .env.example .env
php artisan key:generate
```

4. Configure `.env` with your MySQL database, mail, and app URL.

5. Run migrations
```bash
php artisan migrate
```

6. Link storage (for uploads)
```bash
php artisan storage:link
```

7. Start the app
```bash
php artisan serve
```

Admin and customer seeders may be available under `database/seeders` — run only if needed after checking credentials.

---

## Features overview

- Multi-category clothing catalog (Men, Women, Sale, brands)
- Order lifecycle tracked in admin
- Revenue calculated from **delivered** orders
- Coupon system with sale-item restriction
- Guest + logged-in checkout support
- Responsive storefront UI

---

## Notes

- Do **not** commit `.env` — secrets stay local / on the server
- Product images live under `public/uploads`
- Backup `.zip` files in the workspace are not part of this repo

---

## License

Private project for Imran Cloth House. Not open-sourced for redistribution.
