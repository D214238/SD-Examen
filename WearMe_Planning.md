# WearMe — Volledig Planningsdocument

> Laravel 13 · Blade · Breeze · Spatie Permissions · MySQL · Geen Livewire · Geen Tailwind · PER 3.0

---

## Inhoudsopgave

1. [Analyse bestaande codebase & gaps](#1-analyse-bestaande-codebase--gaps)
2. [Database & Migraties](#2-database--migraties)
3. [Models, Factories & Seeders](#3-models-factories--seeders)
4. [Bestandsstructuur volledig uitgeschreven](#4-bestandsstructuur-volledig-uitgeschreven)
5. [Routes](#5-routes)
6. [Controllers](#6-controllers)
7. [Services & Utilities](#7-services--utilities)
8. [Form Requests](#8-form-requests)
9. [Blade Componenten](#9-blade-componenten)
10. [Blade Views (pages)](#10-blade-views-pages)
11. [CSS & JavaScript Strategie](#11-css--javascript-strategie)
12. [Rollen & Autorisatie (Spatie)](#12-rollen--autorisatie-spatie)
13. [Middleware](#13-middleware)
14. [Providers](#14-providers)
15. [Helpers & Traits](#15-helpers--traits)
16. [Implementatievolgorde (per sprint)](#16-implementatievolgorde-per-sprint)

---

## 1. Analyse bestaande codebase & gaps

### Wat er al is (en aangepast/uitgebreid moet worden)

| Onderdeel | Status | Opmerking |
|---|---|---|
| `users` migratie | ⚠️ Onvolledig | Mist: `first_name`, `last_name`, `phone`, geen aparte adres-tabel, geen Spatie roles |
| `categories` migratie | ⚠️ Onvolledig | Mist: `parent_id` voor hiërarchie (hoofd/sub/sub-sub) |
| `products` migratie | ⚠️ Onvolledig | Mist: `brand`, meerdere foto's (aparte tabel), `is_featured`, `is_sale`, `discount_type`, `quantity` (los van stock), barcode |
| `carts` migratie | ✅ Bruikbaar | Kleine aanpassingen |
| `orders` migratie | ⚠️ Onvolledig | Adres moet FK naar `addresses` tabel zijn; mist `barcode`, Dutch statuses |
| `order_products` migratie | ⚠️ Onvolledig | Mist: `discount_price`, `brand`, `product_image` (snapshot) |
| `settings` migratie | ✅ Bruikbaar | Uitbreiden met footer-links tabel |
| `User` model | ⚠️ Onvolledig | Mist Spatie `HasRoles`, aparte adressen relatie |
| `Category` model | ⚠️ Onvolledig | Mist parent/children relatie, recursive |
| `Product` model | ⚠️ Onvolledig | Mist brand, images relatie, is_featured, is_sale |
| `Order` model | ⚠️ Onvolledig | Adres via FK, barcode generator, NL statussen |
| `Cart` / `CartItem` | ✅ Bruikbaar | |
| `Setting` model | ✅ Bruikbaar | |
| Controllers | ⚠️ Onvolledig | Structuur niet conform spec (Page/User/Shared), te weinig gesplitst |
| Views | ⚠️ Onvolledig | Geen componentstructuur conform spec, geen CSS |
| Geen factories/seeders | ❌ Ontbreekt | Volledig aanmaken |
| Geen Spatie installatie | ❌ Ontbreekt | |
| Geen adres-tabel | ❌ Ontbreekt | |
| Geen product images tabel | ❌ Ontbreekt | |
| Geen footer links tabel | ❌ Ontbreekt | |
| Geen barcode logica | ❌ Ontbreekt | |

---

## 2. Database & Migraties

### Migraties — volgorde & bestandsnamen

```
database/migrations/
│
├── 0001_01_01_000000_create_users_table.php            ← VERVANGEN
├── 0001_01_01_000001_create_cache_table.php            ← ongewijzigd
├── 0001_01_01_000002_create_jobs_table.php             ← ongewijzigd
│
├── 2025_01_01_000001_create_permission_tables.php      ← via Spatie publish
│
├── 2025_01_02_000001_create_addresses_table.php        ← NIEUW
├── 2025_01_02_000002_add_address_to_users_table.php    ← NIEUW (FK naar addresses)
│
├── 2025_01_03_000001_create_categories_table.php       ← VERVANGEN
├── 2025_01_03_000002_create_brands_table.php           ← NIEUW
├── 2025_01_03_000003_create_products_table.php         ← VERVANGEN
├── 2025_01_03_000004_create_product_images_table.php   ← NIEUW
│
├── 2025_01_04_000001_create_carts_table.php            ← LICHT AANGEPAST
│
├── 2025_01_05_000001_create_orders_table.php           ← VERVANGEN
├── 2025_01_05_000002_create_order_items_table.php      ← VERVANGEN (was order_products)
│
├── 2025_01_06_000001_create_settings_table.php         ← ongewijzigd
└── 2025_01_06_000002_create_footer_links_table.php     ← NIEUW
```

---

### Tabelschema's (volledig)

#### `users`
```sql
id                  BIGINT PK AUTO_INCREMENT
first_name          VARCHAR(100)
last_name           VARCHAR(100)
email               VARCHAR(255) UNIQUE
email_verified_at   TIMESTAMP NULL
password            VARCHAR(255)
phone               VARCHAR(30) NULL
active_address_id   BIGINT FK → addresses.id NULL   -- huidig standaard adres
remember_token      VARCHAR(100) NULL
created_at          TIMESTAMP
updated_at          TIMESTAMP
```

#### `addresses`
```sql
id              BIGINT PK AUTO_INCREMENT
user_id         BIGINT FK → users.id CASCADE
street          VARCHAR(255)         -- straatnaam + huisnummer
city            VARCHAR(100)
state           VARCHAR(100) NULL    -- provincie
zip_code        VARCHAR(20)
country         VARCHAR(100) DEFAULT 'Nederland'
is_default      BOOLEAN DEFAULT false
created_at      TIMESTAMP
updated_at      TIMESTAMP
```
> Een user kan meerdere adressen hebben. `active_address_id` op `users` wijst naar het huidig geselecteerde adres. Ordres bewaren een **kopie** via `address_id` FK, zodat wijzigingen later het order-adres niet raken.

#### `categories`
```sql
id              BIGINT PK AUTO_INCREMENT
parent_id       BIGINT FK → categories.id NULL CASCADE   -- NULL = hoofdcategorie
name            VARCHAR(150)
slug            VARCHAR(150) UNIQUE
description     TEXT NULL
image           VARCHAR(255) NULL
is_active       BOOLEAN DEFAULT true
sort_order      INT DEFAULT 0
created_at      TIMESTAMP
updated_at      TIMESTAMP
```
> Oneindig nestbaar via self-referencing. In de praktijk gebruikt WearMe: hoofd → sub → sub-sub.

#### `brands`
```sql
id          BIGINT PK AUTO_INCREMENT
name        VARCHAR(150)
slug        VARCHAR(150) UNIQUE
logo        VARCHAR(255) NULL
is_active   BOOLEAN DEFAULT true
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### `products`
```sql
id                  BIGINT PK AUTO_INCREMENT
category_id         BIGINT FK → categories.id RESTRICT
brand_id            BIGINT FK → brands.id NULL RESTRICT
name                VARCHAR(255)
slug                VARCHAR(255) UNIQUE
description         LONGTEXT NULL          -- Markdown (EasyMDE)
price               DECIMAL(10,2)
discount_type       ENUM('none','percent','amount') DEFAULT 'none'
discount_value      DECIMAL(10,2) NULL     -- % of bedrag
stock               INT DEFAULT 0
is_active           BOOLEAN DEFAULT true
is_featured         BOOLEAN DEFAULT false  -- uitgelicht op home
is_sale             BOOLEAN DEFAULT false  -- in actie-slideshow
sku                 VARCHAR(100) NULL UNIQUE
created_at          TIMESTAMP
updated_at          TIMESTAMP
```
> `effective_price` wordt berekend in het model als accessor.

#### `product_images`
```sql
id          BIGINT PK AUTO_INCREMENT
product_id  BIGINT FK → products.id CASCADE
path        VARCHAR(255)
alt         VARCHAR(255) NULL
sort_order  INT DEFAULT 0
is_primary  BOOLEAN DEFAULT false
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### `carts`
```sql
id          BIGINT PK AUTO_INCREMENT
user_id     BIGINT FK → users.id NULL CASCADE
session_id  VARCHAR(100) NULL
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### `cart_items`
```sql
id          BIGINT PK AUTO_INCREMENT
cart_id     BIGINT FK → carts.id CASCADE
product_id  BIGINT FK → products.id CASCADE
quantity    INT DEFAULT 1
price       DECIMAL(10,2)    -- prijs op moment van toevoeging
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### `orders`
```sql
id              BIGINT PK AUTO_INCREMENT
user_id         BIGINT FK → users.id RESTRICT
address_id      BIGINT FK → addresses.id RESTRICT   -- snapshot-adres van order
order_number    VARCHAR(50) UNIQUE                  -- bijv. WM-2025-00123
barcode         VARCHAR(255) NULL                   -- barcode string (order_number gecodeerd)
status          ENUM('onbehandeld','in_behandeling','klaar','afgerond','geannuleerd') DEFAULT 'onbehandeld'
subtotal        DECIMAL(10,2)
discount_total  DECIMAL(10,2) DEFAULT 0
total           DECIMAL(10,2)
notes           TEXT NULL
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

#### `order_items`
```sql
id              BIGINT PK AUTO_INCREMENT
order_id        BIGINT FK → orders.id CASCADE
product_id      BIGINT FK → products.id RESTRICT
product_name    VARCHAR(255)         -- snapshot naam
product_brand   VARCHAR(150) NULL    -- snapshot merk
product_image   VARCHAR(255) NULL    -- snapshot hoofdfoto
quantity        INT
unit_price      DECIMAL(10,2)        -- prijs excl. korting
discount_type   ENUM('none','percent','amount') DEFAULT 'none'
discount_value  DECIMAL(10,2) DEFAULT 0
line_total      DECIMAL(10,2)        -- quantity × effectieve prijs
created_at      TIMESTAMP
updated_at      TIMESTAMP
```

#### `settings`
```sql
id          BIGINT PK AUTO_INCREMENT
key         VARCHAR(100) UNIQUE
value       TEXT NULL
group       VARCHAR(50) DEFAULT 'general'
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

**Settings keys (group: `shop`)**
- `shop_name`, `shop_email`, `shop_phone`, `shop_address`, `shop_description`

#### `footer_links`
```sql
id          BIGINT PK AUTO_INCREMENT
header      VARCHAR(150)       -- kolomtitel in footer
label       VARCHAR(150)       -- linktekst
url         VARCHAR(255)
sort_order  INT DEFAULT 0
is_active   BOOLEAN DEFAULT true
created_at  TIMESTAMP
updated_at  TIMESTAMP
```

#### Spatie-tabellen (via `php artisan vendor:publish`)
- `roles`, `permissions`, `model_has_roles`, `model_has_permissions`, `role_has_permissions`

---

## 3. Models, Factories & Seeders

### Models

| Model | Bestand | Relaties |
|---|---|---|
| `User` | `app/Models/User.php` | `hasMany(Address)`, `belongsTo(Address, 'active_address_id')`, `hasMany(Order)`, `hasOne(Cart)`, `HasRoles` (Spatie) |
| `Address` | `app/Models/Address.php` | `belongsTo(User)` |
| `Category` | `app/Models/Category.php` | `belongsTo(Category, 'parent_id')` (parent), `hasMany(Category, 'parent_id')` (children), `hasMany(Product)`, recursive ancestors/descendants |
| `Brand` | `app/Models/Brand.php` | `hasMany(Product)` |
| `Product` | `app/Models/Product.php` | `belongsTo(Category)`, `belongsTo(Brand)`, `hasMany(ProductImage)`, `hasMany(OrderItem)`, accessors: `effectivePrice`, `discountAmount`, `primaryImage` |
| `ProductImage` | `app/Models/ProductImage.php` | `belongsTo(Product)` |
| `Cart` | `app/Models/Cart.php` | `belongsTo(User)`, `hasMany(CartItem)`, accessor: `total`, `count` |
| `CartItem` | `app/Models/CartItem.php` | `belongsTo(Cart)`, `belongsTo(Product)`, accessor: `subtotal` |
| `Order` | `app/Models/Order.php` | `belongsTo(User)`, `belongsTo(Address)`, `hasMany(OrderItem)`, accessor: `statusLabel`, `statusClass`; static: `generateOrderNumber()`, `generateBarcode()` |
| `OrderItem` | `app/Models/OrderItem.php` | `belongsTo(Order)`, `belongsTo(Product)` |
| `Setting` | `app/Models/Setting.php` | static `get()`, `set()` |
| `FooterLink` | `app/Models/FooterLink.php` | |

### Traits

```
app/Traits/
├── HasSlug.php         -- auto-slug genereren op creating/updating
└── HasBarcode.php      -- barcode generatie helper
```

### Factories

```
database/factories/
├── UserFactory.php
├── AddressFactory.php
├── CategoryFactory.php
├── BrandFactory.php
├── ProductFactory.php
├── ProductImageFactory.php
├── OrderFactory.php
└── OrderItemFactory.php
```

### Seeders

```
database/seeders/
├── DatabaseSeeder.php              -- orkestreert alles
├── RoleSeeder.php                  -- roles: user, admin, superadmin
├── SuperAdminSeeder.php            -- 1 vaste superadmin account
├── AdminSeeder.php                 -- 2-3 admin accounts
├── UserSeeder.php                  -- 20-50 gebruikers met adressen
├── CategorySeeder.php              -- hoofd + sub + sub-sub categorieën
├── BrandSeeder.php                 -- 8-10 merken (bijv. Pandora, Fossil, etc.)
├── ProductSeeder.php               -- 50-100 producten met images
├── OrderSeeder.php                 -- 30-50 orders verdeeld over users
├── SettingSeeder.php               -- winkelgegevens
└── FooterLinkSeeder.php            -- footer kolommen + links
```

**Seed-inhoud categorieboom (voorbeeld):**
```
Sieraden
  ├── Ringen
  ├── Kettingen
  │     ├── Goud
  │     └── Zilver
  ├── Armbanden
  └── Oorbellen
Horloges
  ├── Heren
  └── Dames
Accessoires
  ├── Brooches
  └── Haarspeldjes
```

**Rollen & Rechten:**
- `superadmin` — kan alles, kan nooit verwijderd worden (bewaakt via Policy)
- `admin` — beheert winkel via admin paneel
- `user` — gewone klant

---

## 4. Bestandsstructuur volledig uitgeschreven

```
app/
├── Helpers/
│   └── Helpers.php
│
├── Http/
│   ├── Controllers/
│   │   ├── Page/
│   │   │   ├── Auth/
│   │   │   │   ├── LoginController.php
│   │   │   │   ├── RegisterController.php
│   │   │   │   └── PasswordResetController.php
│   │   │   │
│   │   │   ├── Home/
│   │   │   │   └── HomeController.php
│   │   │   │
│   │   │   ├── Product/
│   │   │   │   ├── ProductController.php
│   │   │   │   └── ProductActionController.php
│   │   │   │
│   │   │   ├── Category/
│   │   │   │   └── CategoryController.php
│   │   │   │
│   │   │   ├── Cart/
│   │   │   │   ├── CartController.php
│   │   │   │   └── CartActionController.php
│   │   │   │
│   │   │   ├── Checkout/
│   │   │   │   ├── CheckoutController.php
│   │   │   │   └── CheckoutActionController.php
│   │   │   │
│   │   │   ├── Order/
│   │   │   │   └── OrderController.php
│   │   │   │
│   │   │   ├── Profile/
│   │   │   │   ├── ProfileController.php
│   │   │   │   └── ProfileActionController.php
│   │   │   │
│   │   │   └── Admin/
│   │   │       ├── Dashboard/
│   │   │       │   └── DashboardController.php
│   │   │       ├── Product/
│   │   │       │   ├── ProductController.php
│   │   │       │   └── ProductActionController.php
│   │   │       ├── Category/
│   │   │       │   ├── CategoryController.php
│   │   │       │   └── CategoryActionController.php
│   │   │       ├── Brand/
│   │   │       │   ├── BrandController.php
│   │   │       │   └── BrandActionController.php
│   │   │       ├── User/
│   │   │       │   ├── UserController.php
│   │   │       │   └── UserActionController.php
│   │   │       ├── Admin/
│   │   │       │   ├── AdminController.php
│   │   │       │   └── AdminActionController.php
│   │   │       ├── Order/
│   │   │       │   ├── OrderController.php
│   │   │       │   └── OrderActionController.php
│   │   │       ├── Profile/
│   │   │       │   ├── ProfileController.php
│   │   │       │   └── ProfileActionController.php
│   │   │       └── Setting/
│   │   │           ├── SettingController.php
│   │   │           └── SettingActionController.php
│   │   │
│   │   └── Shared/
│   │       ├── ExportController.php        -- invokeable, CSV export
│   │       └── ImageUploadController.php   -- invokeable, afbeeldingen
│   │
│   ├── Middleware/
│   │   ├── EnsureIsAdmin.php
│   │   └── MergeSessionCart.php    -- bij login: sessiecart → db-cart
│   │
│   ├── Requests/
│   │   ├── Auth/
│   │   │   ├── LoginRequest.php
│   │   │   └── RegisterRequest.php
│   │   ├── Profile/
│   │   │   ├── UpdateProfileRequest.php
│   │   │   └── UpdateAddressRequest.php
│   │   ├── Checkout/
│   │   │   └── PlaceOrderRequest.php
│   │   └── Admin/
│   │       ├── Product/
│   │       │   ├── StoreProductRequest.php
│   │       │   └── UpdateProductRequest.php
│   │       ├── Category/
│   │       │   ├── StoreCategoryRequest.php
│   │       │   └── UpdateCategoryRequest.php
│   │       ├── Brand/
│   │       │   ├── StoreBrandRequest.php
│   │       │   └── UpdateBrandRequest.php
│   │       ├── User/
│   │       │   ├── StoreUserRequest.php
│   │       │   └── UpdateUserRequest.php
│   │       ├── Order/
│   │       │   └── UpdateOrderRequest.php
│   │       └── Setting/
│   │           └── UpdateSettingRequest.php
│   │
│   └── Services/
│       ├── CartService.php         -- cart logica (merge, add, remove, totals)
│       ├── OrderService.php        -- order aanmaken, stock update
│       └── ExportService.php       -- CSV generatie
│
├── Models/
│   ├── User.php
│   ├── Address.php
│   ├── Category.php
│   ├── Brand.php
│   ├── Product.php
│   ├── ProductImage.php
│   ├── Cart.php
│   ├── CartItem.php
│   ├── Order.php
│   ├── OrderItem.php
│   ├── Setting.php
│   └── FooterLink.php
│
├── Policies/
│   ├── UserPolicy.php       -- superadmin bescherming
│   └── OrderPolicy.php      -- user ziet alleen eigen orders
│
├── Providers/
│   ├── AppServiceProvider.php
│   ├── Extenders/
│   │   ├── BladeExtensionProvider.php   -- custom Blade directives (bijv. @markdown)
│   │   └── StringExtensionProvider.php
│   ├── Services/
│   │   ├── CartServiceProvider.php
│   │   └── OrderServiceProvider.php
│   └── Utilities/
│       └── ExportUtilityProvider.php
│
├── Helpers/
│   └── Helpers.php
│
├── Structures/
│   └── CartCollection.php   -- custom collection voor cart items
│
├── Traits/
│   ├── HasSlug.php
│   └── HasBarcode.php
│
└── Utilities/
    ├── ExportUtility.php    -- pure CSV utility, geen DB
    └── FormatUtility.php    -- prijzen, datums formatteren
```

```
resources/
├── views/
│   ├── layout/
│   │   ├── app.blade.php            -- hoofd layout (<!DOCTYPE html>, nav, footer)
│   │   ├── admin.blade.php          -- admin layout (sidebar)
│   │   └── print.blade.php          -- print layout (kaal, voor order print)
│   │
│   ├── pages/
│   │   ├── home/
│   │   │   └── index.blade.php
│   │   ├── products/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── categories/
│   │   │   └── show.blade.php
│   │   ├── cart/
│   │   │   └── index.blade.php
│   │   ├── checkout/
│   │   │   ├── index.blade.php      -- check/bevestig order
│   │   │   └── thankyou.blade.php
│   │   ├── orders/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── profile/
│   │   │   ├── index.blade.php
│   │   │   └── edit.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   ├── register.blade.php
│   │   │   └── passwords/
│   │   │       ├── email.blade.php
│   │   │       └── reset.blade.php
│   │   └── admin/
│   │       ├── dashboard/
│   │       │   └── index.blade.php
│   │       ├── products/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── show.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── categories/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── show.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── brands/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── users/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── show.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── admins/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── show.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── orders/
│   │       │   ├── index.blade.php
│   │       │   ├── create.blade.php
│   │       │   ├── show.blade.php
│   │       │   ├── edit.blade.php
│   │       │   └── export.blade.php
│   │       ├── profile/
│   │       │   └── edit.blade.php
│   │       └── settings/
│   │           └── index.blade.php
│   │
│   └── components/
│       ├── layout/
│       │   ├── header.blade.php         -- sticky nav met zoekbalk + cart icon
│       │   ├── footer.blade.php         -- winkelgegevens + footer links
│       │   ├── sidebar.blade.php        -- admin sidebar nav
│       │   └── flash-messages.blade.php -- session success/error berichten
│       │
│       ├── ui/
│       │   ├── button.blade.php         -- props: type, variant, size, href
│       │   ├── badge.blade.php          -- props: variant (success/warning/etc.)
│       │   ├── alert.blade.php          -- props: type, dismissible
│       │   ├── modal.blade.php          -- confirm/delete modal
│       │   ├── pagination.blade.php     -- wraps Laravel paginator
│       │   ├── breadcrumb.blade.php     -- props: items []
│       │   ├── loading-spinner.blade.php
│       │   └── empty-state.blade.php   -- props: message, icon
│       │
│       ├── form/
│       │   ├── input.blade.php          -- props: name, label, type, required, value, error
│       │   ├── textarea.blade.php       -- props: name, label, rows, required
│       │   ├── select.blade.php         -- props: name, label, options, selected, required
│       │   ├── checkbox.blade.php       -- props: name, label, checked
│       │   ├── radio.blade.php          -- props: name, value, label, checked
│       │   ├── file-upload.blade.php    -- props: name, label, multiple, accept
│       │   ├── markdown-editor.blade.php -- EasyMDE integratie
│       │   ├── price-input.blade.php    -- props: name, label, currency
│       │   └── error.blade.php          -- props: field (toont validatie fout)
│       │
│       ├── table/
│       │   ├── index.blade.php          -- wrapper tabel met thead/tbody slot
│       │   ├── head.blade.php           -- th met sorteer-link
│       │   ├── row.blade.php            -- tr wrapper
│       │   ├── actions.blade.php        -- td met view/edit/delete knoppen
│       │   └── filter-bar.blade.php     -- zoekbalk + filter inputs boven tabel
│       │
│       ├── product/
│       │   ├── card.blade.php           -- product kaart voor grid (afbeelding, naam, prijs, korting)
│       │   ├── grid.blade.php           -- grid wrapper van meerdere cards
│       │   ├── price.blade.php          -- toont prijs + eventueel doorgestreepte orig. prijs
│       │   ├── badge-discount.blade.php -- "20% korting" badge
│       │   ├── stock-indicator.blade.php -- "op voorraad" / "uitverkocht"
│       │   └── image-gallery.blade.php  -- foto's op productpagina
│       │
│       ├── cart/
│       │   ├── item-row.blade.php       -- 1 cart-item rij (foto, naam, prijs, qty, verwijder)
│       │   └── summary.blade.php        -- subtotaal, korting, totaal samenvatting
│       │
│       ├── order/
│       │   ├── status-badge.blade.php   -- gekleurde badge per status
│       │   ├── item-row.blade.php       -- 1 order-item rij
│       │   ├── summary.blade.php        -- totaalsamenvatting
│       │   ├── address-block.blade.php  -- verzendadres weergave
│       │   └── barcode.blade.php        -- barcode weergave (img/svg)
│       │
│       ├── category/
│       │   ├── tree.blade.php           -- recursieve boom weergave
│       │   ├── card.blade.php           -- categorie kaart
│       │   └── filter-sidebar.blade.php -- collapsible filter zijbalk (producten pagina)
│       │
│       ├── home/
│       │   ├── slideshow.blade.php      -- actie-slideshow
│       │   ├── featured-products.blade.php -- uitgelichte producten sectie
│       │   └── category-grid.blade.php  -- categorieën overzicht
│       │
│       ├── address/
│       │   ├── card.blade.php           -- adres weergave kaart
│       │   └── form.blade.php           -- adres formulier (herbruikbaar)
│       │
│       └── admin/
│           ├── stat-card.blade.php      -- dashboard statistieken kaart
│           ├── export-form.blade.php    -- export filter formulier
│           └── confirm-delete.blade.php -- verwijder bevestiging modal
```

---

## 5. Routes

### `routes/web.php` — volledig plan

```php
// ── Public ─────────────────────────────────────────────────────────────────
GET  /                                          home                         HomeController@index
GET  /producten                                 products.index               ProductController@index
GET  /producten/{slug}                          products.show                ProductController@show

GET  /categorieen                               categories.index             CategoryController@index
GET  /categorieen/{slug}                        categories.show              CategoryController@show

GET  /winkelwagen                               cart.index                   CartController@index
POST /winkelwagen/toevoegen                     cart.add                     CartActionController@add
PATCH /winkelwagen/{cartItem}                   cart.update                  CartActionController@update
DELETE /winkelwagen/{cartItem}                  cart.remove                  CartActionController@remove
DELETE /winkelwagen                             cart.clear                   CartActionController@clear

// ── Auth ───────────────────────────────────────────────────────────────────
GET  /inloggen                                  login                        LoginController@show
POST /inloggen                                  login.post                   LoginController@login
POST /uitloggen                                 logout                       LoginController@logout
GET  /registreren                               register                     RegisterController@show
POST /registreren                               register.post                RegisterController@register
GET  /wachtwoord-vergeten                       password.request             PasswordResetController@showEmail
POST /wachtwoord-vergeten                       password.email               PasswordResetController@sendEmail
GET  /wachtwoord-reset/{token}                  password.reset               PasswordResetController@showReset
POST /wachtwoord-reset                          password.update              PasswordResetController@update

// ── Authenticated users ────────────────────────────────────────────────────
GET  /afrekenen                                 checkout.index               CheckoutController@index
POST /afrekenen/adres                           checkout.address             CheckoutActionController@updateAddress
POST /afrekenen/plaatsen                        checkout.store               CheckoutActionController@store
GET  /afrekenen/bedankt/{orderNumber}           checkout.thankyou            CheckoutController@thankyou

GET  /bestellingen                              orders.index                 OrderController@index
GET  /bestellingen/{orderNumber}                orders.show                  OrderController@show

GET  /profiel                                   profile.index                ProfileController@index
GET  /profiel/bewerken                          profile.edit                 ProfileController@edit
PUT  /profiel                                   profile.update               ProfileActionController@update
POST /profiel/adres                             profile.address.store        ProfileActionController@storeAddress
DELETE /profiel/adres/{address}                 profile.address.destroy      ProfileActionController@destroyAddress
POST /profiel/adres/{address}/activeren         profile.address.activate     ProfileActionController@activateAddress

// ── Admin ──────────────────────────────────────────────────────────────────
// prefix: /admin, name prefix: admin., middleware: auth + role:admin|superadmin

GET  /admin                                     admin.dashboard              DashboardController@index

// Producten
GET  /admin/producten                           admin.products.index         Admin\ProductController@index
GET  /admin/producten/aanmaken                  admin.products.create        Admin\ProductController@create
POST /admin/producten                           admin.products.store         Admin\ProductController@store
GET  /admin/producten/{product}                 admin.products.show          Admin\ProductController@show
GET  /admin/producten/{product}/bewerken        admin.products.edit          Admin\ProductController@edit
PUT  /admin/producten/{product}                 admin.products.update        Admin\ProductController@update
DELETE /admin/producten/{product}               admin.products.destroy       Admin\ProductController@destroy
GET  /admin/producten/exporteren                admin.products.export        Admin\ProductActionController@exportPage
POST /admin/producten/exporteren                admin.products.export.post   Admin\ProductActionController@export

// Categorieën
GET  /admin/categorieen                         admin.categories.index       ...
(zelfde CRUD patroon)
GET  /admin/categorieen/exporteren              admin.categories.export      ...

// Merken
GET  /admin/merken                              admin.brands.index           ...
(zelfde CRUD patroon)

// Gebruikers
GET  /admin/gebruikers                          admin.users.index            ...
POST /admin/gebruikers/{user}/wachtwoord-reset  admin.users.password-reset   Admin\UserActionController@sendPasswordReset
GET  /admin/gebruikers/exporteren               admin.users.export           ...

// Beheerders
GET  /admin/beheerders                          admin.admins.index           ...
(zelfde CRUD patroon)
GET  /admin/beheerders/exporteren               admin.admins.export          ...

// Bestellingen
GET  /admin/bestellingen                        admin.orders.index           ...
GET  /admin/bestellingen/exporteren             admin.orders.export          ...
(zelfde CRUD patroon, geen create want orders komen van klanten)

// Profiel (admin zelf)
GET  /admin/profiel/bewerken                    admin.profile.edit           ...
PUT  /admin/profiel                             admin.profile.update         ...

// Instellingen
GET  /admin/instellingen                        admin.settings.index         ...
PUT  /admin/instellingen                        admin.settings.update        ...
POST /admin/instellingen/footer-links           admin.footer-links.store     ...
PUT  /admin/instellingen/footer-links/{link}    admin.footer-links.update    ...
DELETE /admin/instellingen/footer-links/{link}  admin.footer-links.destroy   ...
```

---

## 6. Controllers

### Methode-overzicht per controller

#### `Page/Cart/CartController`
- `index()` — laad cart (sessie of DB), geef view terug met product-beschikbaarheid checks

#### `Page/Cart/CartActionController`
- `add(Request)` — product toevoegen, check stock
- `update(Request, CartItem)` — quantity aanpassen
- `remove(CartItem)` — item verwijderen
- `clear()` — winkelwagen leegmaken

#### `Page/Checkout/CheckoutController`
- `index()` — check order pagina, filter ongeldige items, toon adres keuze
- `thankyou(string $orderNumber)` — bedankpagina

#### `Page/Checkout/CheckoutActionController`
- `updateAddress(Request)` — adres kiezen/aanmaken voor order
- `store(PlaceOrderRequest)` — order aanmaken via `OrderService`, stock updaten, cart legen

#### `Page/Order/OrderController`
- `index()` — eigen orders (auth)
- `show(string $orderNumber)` — enkel order (auth, policy check)

#### `Page/Profile/ProfileController`
- `index()` — profiel overview
- `edit()` — profiel bewerken

#### `Page/Profile/ProfileActionController`
- `update(UpdateProfileRequest)` — naam/email/telefoon updaten
- `storeAddress(UpdateAddressRequest)` — nieuw adres opslaan
- `destroyAddress(Address)` — adres verwijderen (policy: niet als order er naar verwijst)
- `activateAddress(Address)` — instellen als standaard adres

#### `Page/Product/ProductController`
- `index(Request)` — producten met filters (categorie, merk, prijs, zoek), paginatie 25
- `show(string $slug)` — enkel product

#### `Page/Category/CategoryController`
- `index()` — categorieën overzicht
- `show(string $slug)` — categorie met producten (gefilterd)

#### `Page/Home/HomeController`
- `index()` — home met slideshow items, featured products, categorieën

#### `Admin/Product/ProductController`
- `index(Request)` — sorteer/filter/zoek
- `create()`, `store(StoreProductRequest)`, `show(Product)`, `edit(Product)`, `update(UpdateProductRequest, Product)`, `destroy(Product)`

#### `Admin/Product/ProductActionController`
- `exportPage(Request)` — export filter pagina
- `export(Request)` — download CSV via `ExportService`

*(zelfde patroon voor Category, Brand, User, Admin, Order)*

#### `Admin/User/UserActionController`
- `sendPasswordReset(User)` — verstuurt reset e-mail

#### `Admin/Order/OrderController`
- CRUD + status aanpassen
- Geen `create/store` (orders komen van klanten); wel `update` voor status

#### `Admin/Setting/SettingController`
- `index()` — toon instellingen + footer links

#### `Admin/Setting/SettingActionController`
- `update(UpdateSettingRequest)` — bewaar winkel gegevens
- `storeFooterLink(Request)`, `updateFooterLink(Request, FooterLink)`, `destroyFooterLink(FooterLink)`

#### `Shared/ExportController` (invokeable)
- `__invoke(Request, string $type)` — genereert CSV voor gegeven type

---

## 7. Services & Utilities

### `CartService`
```php
// Methodes:
getOrCreateCart(): Cart                      // sessie of DB
addItem(Cart, Product, int $quantity): void
updateItem(CartItem, int $quantity): void
removeItem(CartItem): void
clearCart(Cart): void
mergeSessionCartToUser(User): void           // bij login
validateCartItems(Cart): array               // geeft warnings terug
getCartTotal(Cart): float
```

### `OrderService`
```php
// Methodes:
createFromCart(User, Cart, Address): Order
updateStock(Order): void                     // na plaatsen order
generateOrderNumber(): string                // WM-2025-XXXXX
generateBarcode(string $orderNumber): string // base64/svg barcode
filterValidItems(Cart): Collection           // verwijder inactief/geen stock
```

### `ExportService`
```php
// Methodes:
exportUsers(array $filters): StreamedResponse
exportAdmins(array $filters): StreamedResponse
exportProducts(array $filters): StreamedResponse
exportCategories(array $filters): StreamedResponse
exportOrders(array $filters): StreamedResponse
```

### `ExportUtility` (geen DB context)
```php
// Methodes:
generateCsv(array $headers, array $rows): string
streamCsv(string $filename, string $content): StreamedResponse
```

### `FormatUtility` (geen DB context)
```php
// Methodes:
formatPrice(float $amount, string $currency = '€'): string
formatDate(Carbon $date, string $format = 'd-m-Y'): string
formatPercentage(float $value): string
```

---

## 8. Form Requests

| Request | Velden |
|---|---|
| `LoginRequest` | `email` (required, email), `password` (required), `remember` (boolean) |
| `RegisterRequest` | `first_name`, `last_name`, `email` (unique), `password` (confirmed, min:8), `phone` (nullable), `street`, `city`, `zip_code`, `country` |
| `UpdateProfileRequest` | `first_name`, `last_name`, `email` (unique behalve eigen), `phone` |
| `UpdateAddressRequest` | `street`, `city`, `state`, `zip_code`, `country` |
| `PlaceOrderRequest` | `address_id` (exists:addresses,id, van user), `notes` (nullable) |
| `StoreProductRequest` | `name`, `category_id`, `brand_id`, `description`, `price`, `discount_type`, `discount_value`, `stock`, `is_active`, `is_featured`, `is_sale`, `images.*` (image, max:2048) |
| `UpdateProductRequest` | zelfde als Store, alles nullable |
| `StoreCategoryRequest` | `name`, `parent_id` (nullable, exists), `description`, `image`, `is_active`, `sort_order` |
| `StoreBrandRequest` | `name`, `logo`, `is_active` |
| `StoreUserRequest` | `first_name`, `last_name`, `email`, `password`, `phone`, adresvelden |
| `UpdateUserRequest` | zelfde maar password nullable |
| `UpdateOrderRequest` | `status` (in: onbehandeld,in_behandeling,klaar,afgerond,geannuleerd), `notes` |
| `UpdateSettingRequest` | alle `shop_*` velden |

---

## 9. Blade Componenten

### Gebruik

Componenten worden aangeroepen als `<x-ui.button>`, `<x-form.input>`, etc.

### Props per kerncomponent

#### `<x-ui.button>`
```
variant: primary|secondary|danger|ghost    default: primary
size:    sm|md|lg                          default: md
type:    button|submit|reset               default: button
href:    string|null                       default: null  (maakt <a> ipv <button>)
disabled: bool                             default: false
```

#### `<x-form.input>`
```
name:      string (required)
label:     string
type:      text|email|password|number|tel  default: text
value:     mixed                           default: old()
required:  bool                            default: false
error:     string|null                     (veld naam voor @error)
placeholder: string
```

#### `<x-form.select>`
```
name:     string
label:    string
options:  array [value => label]
selected: mixed
required: bool
error:    string|null
```

#### `<x-table.index>`
```
Slots: thead, tbody
caption: string|null
```

#### `<x-table.head>`
```
column:    string        -- kolom naam voor sort URL
label:     string
sortBy:    string|null   -- huidige sort parameter
sortDir:   string|null   -- asc|desc
```

#### `<x-product.card>`
```
product: Product model
```

#### `<x-order.status-badge>`
```
status: string
```

#### `<x-ui.badge>`
```
variant: success|warning|danger|info|secondary
```

#### `<x-ui.modal>`
```
id:    string
title: string
Slot: default content, footer
```

#### `<x-category.filter-sidebar>`
```
categories: Collection
activeCategory: Category|null
activeBrand: Brand|null
brands: Collection
priceMin: float|null
priceMax: float|null
```

---

## 10. Blade Views (pages)

### Layouts

#### `layout/app.blade.php`
- `<html lang="nl">`
- `<head>` met meta, link naar `app.css`, vite
- `<x-layout.header />` (sticky nav)
- `<main class="site-content">` — **2/3 breedte, gecentreerd**
  - `@yield('content')` of `{{ $slot }}`
- `<x-layout.footer />`
- `app.js` script

#### `layout/admin.blade.php`
- Admin nav + sidebar
- Volledige breedte (geen 2/3 beperking)

#### `layout/print.blade.php`
- Kaal, alleen print CSS, voor order-afdruk

---

### Pages overzicht

#### `pages/home/index.blade.php`
- `<x-home.slideshow :items="$saleProducts" />`
- `<x-home.category-grid :categories="$categories" />`
- `<x-home.featured-products :products="$featuredProducts" />`

#### `pages/products/index.blade.php`
- Filter sidebar links (categorie, merk, prijs)
- `<x-category.filter-sidebar />`
- Zoekbalk
- `<x-product.grid :products="$products" />`
- `<x-ui.pagination :paginator="$products" />`

#### `pages/products/show.blade.php`
- `<x-product.image-gallery :images="$product->images" />`
- Breadcrumb (categorie hiërarchie)
- `<x-product.price :product="$product" />`
- `<x-product.stock-indicator :stock="$product->stock" />`
- Markdown beschrijving (`{!! $descriptionHtml !!}`)
- "In winkelwagen" formulier (met quantity)

#### `pages/cart/index.blade.php`
- `<x-cart.item-row />` per item
- `<x-cart.summary />` rechts
- Waarschuwingen voor uitverkochte/inactieve items
- "Verder naar bestellen" knop

#### `pages/checkout/index.blade.php`
- Check order overzicht (alleen geldige items)
- Waarschuwingen gefilterde items
- Adres selectie + optie nieuw adres toevoegen
- `<x-address.form />` voor nieuw adres
- "Bestelling plaatsen" knop

#### `pages/checkout/thankyou.blade.php` & `pages/orders/show.blade.php`
- `<x-order.address-block />`
- `<x-order.barcode :barcode="$order->barcode" />`
- `<x-order.item-row />` per item
- `<x-order.summary />`
- Print knop (opent `layout/print.blade.php`)

#### `pages/profile/edit.blade.php`
- Formulier persoonsgegevens
- Lijst van adressen (`<x-address.card />` per adres)
- Nieuw adres toevoegen formulier

#### `pages/auth/register.blade.php`
- Naam, email, telefoon, wachtwoord velden
- Adresgegevens sectie
- `<x-form.input />` componenten

---

### Admin pages

#### `pages/admin/dashboard/index.blade.php`
- `<x-admin.stat-card />` voor: totaal orders, omzet, gebruikers, producten
- Recente orders tabel
- Lage stock waarschuwingen

#### `pages/admin/products/index.blade.php`
- `<x-table.filter-bar />` met zoek + filters
- `<x-table.index>` met sorteerbare kolommen
- Acties: inzien, bewerken, verwijderen
- Link naar export pagina

#### `pages/admin/products/create.blade.php` & `edit.blade.php`
- `<x-form.input name="name" />`
- `<x-form.select name="category_id" />`
- `<x-form.select name="brand_id" />`
- `<x-form.markdown-editor name="description" />`
- `<x-form.price-input name="price" />`
- Korting type + waarde
- `<x-form.file-upload name="images[]" multiple />`
- `<x-form.checkbox name="is_active" />`, `is_featured`, `is_sale`

#### `pages/admin/orders/edit.blade.php`
- Alleen status + notities aanpasbaar
- Rest readonly weergave van de order

#### `pages/admin/*/export.blade.php`
- Filter formulier (zelfde velden als index filters)
- "Exporteer CSV" knop → POST → download

---

## 11. CSS & JavaScript Strategie

### Structuur

```
resources/
├── css/
│   └── app.css       -- globale CSS (nested blocks), importeert geen views-CSS
└── js/
    └── app.js        -- globale JS (nav toggle, flash dismiss, etc.)
```

### Globale CSS (`app.css`) bevat

```css
/* Reset & base */
/* CSS Custom Properties (variabelen) */
/* Typography */
/* Layout: .site-wrapper (2/3 breedte), .site-content */
/* Navigation */
/* Footer */
/* Utilities (.sr-only, .visually-hidden) */
/* Print media query */
```

### CSS per component/view

CSS staat in een `<style>` tag **binnen de component of view zelf**.

Voorbeeld `components/product/card.blade.php`:
```blade
<style>
  .product-card { ... }
  .product-card__image { ... }
  .product-card__title { ... }
  @media (max-width: 768px) {
    .product-card { ... }
  }
</style>

<div class="product-card">
  ...
</div>
```

### Kleurpalet (CSS custom properties)

```css
:root {
  --color-primary:        #c8a97e;   /* licht bruin accent */
  --color-primary-dark:   #a8875c;
  --color-primary-light:  #e8d5b7;
  --color-bg:             #fafaf8;
  --color-bg-alt:         #f2ede6;
  --color-text:           #2c2416;
  --color-text-muted:     #7a6a55;
  --color-border:         #d4c4a8;
  --color-success:        #4a7c59;
  --color-warning:        #c9a227;
  --color-danger:         #a63d2f;
  --color-info:           #3a6b8a;
  --font-primary: 'Georgia', serif;
  --font-ui: 'Segoe UI', system-ui, sans-serif;
  --border-radius: 6px;
  --shadow-sm: 0 1px 3px rgba(0,0,0,.08);
  --shadow-md: 0 4px 12px rgba(0,0,0,.12);
}
```

### JavaScript

- Geen framework, vanilla JS
- Globale JS: nav hamburger menu, flash-bericht sluiten, cart icon badge updaten
- Component JS: slideshow (in `home/slideshow.blade.php`), afbeeldingsgalerij (in `product/image-gallery.blade.php`), collapsible category tree, EasyMDE initialisatie, barcode rendering (bijv. [JsBarcode](https://github.com/lindell/JsBarcode))
- Formulier validatie: HTML5 attributes (`required`, `min`, `max`, `type="email"`) + custom JS waar nodig

---

## 12. Rollen & Autorisatie (Spatie)

### Installatie & Configuratie

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\LaravelPermission\PermissionServiceProvider"
php artisan migrate
```

### Rollen

| Rol | Omschrijving |
|---|---|
| `user` | Gewone klant, toegang tot frontend |
| `admin` | Beheert winkel via admin paneel |
| `superadmin` | Zelfde als admin + kan nooit verwijderd worden |

### User model
```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
}
```

### Middleware registratie (`bootstrap/app.php`)
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'role' => \Spatie\LaravelPermission\Middleware\RoleMiddleware::class,
    ]);
})
```

### Route beveiliging
```php
Route::middleware(['auth', 'role:admin|superadmin'])->prefix('admin')...
```

### Policy: superadmin bescherming

```php
// app/Policies/UserPolicy.php
public function delete(User $authUser, User $targetUser): bool
{
    if ($targetUser->hasRole('superadmin')) {
        return false;
    }
    return $authUser->hasRole('admin') || $authUser->hasRole('superadmin');
}
```

---

## 13. Middleware

### `EnsureIsAdmin`
Checkt of gebruiker `admin` of `superadmin` rol heeft. Redirect naar home als niet.

### `MergeSessionCart`
- Draait na login
- Pakt sessie-cart en voegt items toe aan de database-cart van de gebruiker
- Verwijdert de sessie-cart

Registratie: als post-login middleware of in `LoginController` na `Auth::login()`.

---

## 14. Providers

### `Extenders/BladeExtensionProvider`
Registreert custom Blade directive:
```php
Blade::directive('markdown', function ($expression) {
    return "<?php echo app('markdown')->convert($expression); ?>";
});
```

### `Extenders/StringExtensionProvider`
Voegt macro's toe aan Laravel `Str`:
```php
Str::macro('formatPrice', function (float $amount): string {
    return '€ ' . number_format($amount, 2, ',', '.');
});
```

### `Services/CartServiceProvider`
```php
$this->app->singleton(CartService::class);
```

### `Services/OrderServiceProvider`
```php
$this->app->singleton(OrderService::class);
```

### `Utilities/ExportUtilityProvider`
```php
$this->app->singleton(ExportUtility::class);
```

---

## 15. Helpers & Traits

### `app/Helpers/Helpers.php`
```php
if (!function_exists('format_price')) {
    function format_price(float $amount): string { ... }
}
if (!function_exists('active_route')) {
    function active_route(string $routeName): string { ... } // returns 'active' class
}
```

Registreer in `composer.json`:
```json
"autoload": {
    "files": ["app/Helpers/Helpers.php"]
}
```

### `app/Traits/HasSlug.php`
```php
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(fn($model) => $model->slug ??= Str::slug($model->name));
        static::updating(fn($model) => $model->slug = Str::slug($model->name));
    }
}
```

### `app/Traits/HasBarcode.php`
```php
trait HasBarcode
{
    public function generateBarcode(): string
    {
        // genereert barcode data op basis van order_number
    }
}
```

---

## 16. Implementatievolgorde (per sprint)

### Sprint 1 — Fundament
1. Laravel installeren + Breeze + Spatie Permissions
2. Alle migraties schrijven (nieuw schema)
3. Alle models met relaties en accessors
4. Traits: `HasSlug`, `HasBarcode`
5. Factories + Seeders (inclusief rollen/users)
6. `composer.json` autoload Helpers

### Sprint 2 — Globale layout & componenten kern
7. `app.css` met kleurpalet en globale layout
8. `layout/app.blade.php`, `layout/admin.blade.php`, `layout/print.blade.php`
9. `components/layout/header.blade.php` (sticky, zoekbalk, cart icon)
10. `components/layout/footer.blade.php` (settings + footer links)
11. `components/ui/*` (button, badge, alert, modal, pagination, breadcrumb)
12. `components/form/*` (input, select, textarea, checkbox, file-upload, markdown-editor)
13. `components/table/*` (index, head, row, actions, filter-bar)

### Sprint 3 — Frontend winkel
14. `HomeController` + home view + home componenten (slideshow, featured, category-grid)
15. `ProductController` + index/show views + product componenten
16. `CategoryController` + show view + filter-sidebar component
17. `CartService` + `CartController` + `CartActionController` + cart views
18. `MergeSessionCart` middleware

### Sprint 4 — Checkout & Orders
19. `OrderService` (create, stock update, barcode)
20. `CheckoutController` + `CheckoutActionController` + checkout views
21. `OrderController` (user-facing) + order views
22. `components/order/*`
23. Print layout voor orders

### Sprint 5 — Profiel & Auth
24. Auth controllers (login, register, password reset) — Breeze basis uitbreiden
25. `ProfileController` + `ProfileActionController` + profile views
26. `components/address/*`
27. Policies (UserPolicy, OrderPolicy)

### Sprint 6 — Admin paneel
28. Admin dashboard
29. Admin Product CRUD + `ExportService`
30. Admin Category CRUD + export
31. Admin Brand CRUD + export
32. Admin User CRUD + export + password reset e-mail
33. Admin Admin (beheerders) CRUD + export
34. Admin Order management + status updates + export
35. Admin Profiel bewerken
36. Admin Settings + footer links beheer

### Sprint 7 — Polish & Testing
37. Mobile responsiveness alle pagina's
38. HTML5 frontend validatie alle formulieren
39. Edge cases: uitverkocht, inactief product in cart/checkout
40. Barcode weergave (JsBarcode)
41. EasyMDE integratie testen
42. Fuzzy search (bijv. `LIKE %query%` of Laravel Scout)
43. CSV export alle entiteiten
44. Code review PER 3.0 conformiteit

---

## Samenvatting wijzigingen t.o.v. bestaande code

| Wat | Actie |
|---|---|
| `users` tabel | Volledig vervangen: `first_name`/`last_name`, adres via FK |
| `categories` tabel | Vervangen: `parent_id` voor hiërarchie |
| `products` tabel | Vervangen: brand FK, is_featured/is_sale, discount_type/value, SKU |
| `orders` tabel | Vervangen: address FK, NL statuses, barcode |
| `order_products` tabel | Hernoemen naar `order_items`, extra snapshot-velden |
| Nieuwe tabellen | `addresses`, `brands`, `product_images`, `footer_links`, Spatie-tabellen |
| Controllerstructuur | Volledig herindelen naar `Page/*/Controller + ActionController` + `Shared/` |
| Views structuur | Verplaatsen naar `pages/` + `components/` conform spec |
| Geen factories/seeders | Volledig nieuw aanmaken |
| Geen Spatie | Installeren + configureren + RoleSeeder |
| Routing | Uitbreiden: adressen, brands, admins-beheer, footer links |
