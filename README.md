# 🛒 Snack Well E-Commerce

**Developer:** Heiner Alcala-Salas  
**Languages:** PHP, MySQL, HTML, CSS  
**Platform:** Custom-built website (not based on any CMS)

---

## 📋 Overview

Snack Well is a fully functional e-commerce website for healthy snacks, designed with PHP and MySQL. The site includes all core features of a modern online store — such as user login, a shopping cart, product catalog, checkout flow, and admin product management — along with a responsive design using Bootstrap.

This project demonstrates both frontend and backend integration and showcases real-world e-commerce functionality.

---

## 🧩 Features

### 🛍️ Customer Side
- View product catalog with snack categories (bars, cereals, etc.)
- Add items to cart and update quantities
- Checkout with customer information capture
- View order confirmation page
- Access personal order history and update account details
- Submit and view customer testimonials

### 🔐 Admin Panel
- Secure admin login
- Add/edit/remove products
- Update product stock, description, and pricing
- Manage user testimonials

---

## 🛠️ Tech Stack

- **Frontend:** HTML, CSS, Bootstrap, JavaScript
- **Backend:** PHP (procedural), MySQL
- **Database:** phpMyAdmin/MySQL (with foreign key relationships)
- **Hosting Ready:** Tested on local XAMPP and cPanel
- **Payment Flow:** Simulated with PayPal Sandbox integration

---

## 📁 Folder Structure (Simplified)

```
snack-well-ecommerce/
├── admin/               # Admin-only pages
├── assets/              # Images, logos, etc.
├── includes/            # Shared files: DB config, auth, headers
├── cart/                # Cart logic
├── checkout/            # Checkout and order placement
├── customer/            # Customer dashboard, history
├── index.php            # Homepage
├── product-details.php  # Individual product view
├── order-confirmation.php
├── testimonial.php
└── ...
```

---

## 🚀 How to Run

### Requirements:
- Local server (e.g., XAMPP or MAMP)
- MySQL for database
- Import provided `.sql` database file into phpMyAdmin

### Setup Instructions:
1. Place files inside your local `htdocs/` directory
2. Start Apache and MySQL from XAMPP
3. Open `localhost/snack-well-ecommerce/` in your browser
4. Create or login with test accounts to begin using the site

---

## 🌟 Educational Purpose

This project was created for a PHP and web development course. It demonstrates:
- User sessions
- E-commerce logic
- CRUD operations in PHP
- MySQL table design
- Responsive layout

---

## 📫 Contact

**Heiner Alcala-Salas**  
📧 Email: Eduardo_mex92@Outlook.com
