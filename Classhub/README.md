# Bogate Phone Store

A PHP project that stores phone products in arrays and displays them as a searchable catalog with product images and detail pages.

## Required features covered

| Requirement | Where |
|---|---|
| Display a collection of records | `index.php` (product grid), `record.php` (product detail) |
| Organize information using PHP arrays | `data/records.php` (array of associative arrays) |
| Use PHP functions | `includes/functions.php` (search, filter, count, format, render, helpers) |
| Apply string functions | `format_name`, `format_brand`, `shorten_text`, `record_code`, `e` (`htmlspecialchars`), search in `search_records` |
| Present with HTML and CSS | `includes/header.php`, `includes/footer.php`, `assets/css/style.css` |
| Organized files + GitHub | Folder structure below, submitted as a GitHub repository |

## String functions used

`strtolower`, `strtoupper`, `ucwords`, `trim`, `strlen`, `substr`, `rtrim`, `str_pad`, `strpos`, `strcasecmp`, `htmlspecialchars`.

## Run it (XAMPP)

1. Copy the project folder into `C:\xampp\htdocs\` (e.g. `bogate`).
2. Start Apache in the XAMPP Control Panel.
3. Open `http://localhost/bogate/` (or `http://localhost/Classhub/` if running from this folder).

## Folder structure

```
.
├── index.php            catalog page with search and brand filter
├── record.php           product detail page
├── data/
│   └── records.php      product records array
├── includes/
│   ├── functions.php    helper/processing/display functions
│   ├── header.php       page header/layout top
│   └── footer.php       page footer/layout bottom
├── assets/
│   └── css/style.css    styles
└── images/              product images
```

## Add a product

Add a new array entry to `data/records.php` and place its image file in `images/`, then set the `image` field to that filename.

## Submit to GitHub

```
git init
git add .
git commit -m "Bogate Phone Store project"
git branch -M main
git remote add origin https://github.com/YOUR-USERNAME/bogate-phone-store.git
git push -u origin main
```
