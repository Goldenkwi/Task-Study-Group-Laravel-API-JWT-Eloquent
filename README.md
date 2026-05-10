# Laravel Study Group API

REST API Laravel dengan JWT Auth, CRUD, Pagination, Search, dan Relasi Model.

---

## Stack

- Laravel 13
- PHP 8.2+
- MySQL
- JWT Auth (`tymon/jwt-auth`)

---

# Instalasi

```bash
git clone <repo-url>
cd laravel-studygroup-api

composer install

cp .env.example .env
```

## `.env`

```env
APP_NAME=laravel-studygroup-api
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-studygroup-api
DB_USERNAME=root
DB_PASSWORD=

AUTH_GUARD=api
```

---

# Generate Key

```bash
php artisan key:generate
php artisan jwt:secret
```

---

# Migration & Seeder

```bash
php artisan migrate
php artisan db:seed
```

Atau:

```bash
php artisan migrate:fresh --seed
```

---

# Run Server

```bash
php artisan serve
```

Base URL:

```txt
http://localhost:8000/api
```

---

# Auth Header

```http
Authorization: Bearer {token}
```

---

# Seeder Data

## Categories

| ID | Name |
|---|---|
| 1 | Elektronik |
| 2 | Pakaian |
| 3 | Makanan & Minuman |
| 4 | Olahraga |

## Products

| ID | Name |
|---|---|
| 1 | Laptop Gaming ASUS |
| 2 | iPhone 15 Pro |
| 3 | Samsung Galaxy S24 |
| 4 | Kaos Polos Cotton |
| 5 | Kemeja Flannel |
| 6 | Mie Instan Goreng |
| 7 | Sepatu Running Nike |

---

# API Endpoints

## Auth

| Method | Endpoint |
|---|---|
| POST | `/api/register` |
| POST | `/api/login` |
| POST | `/api/logout` 🔒 |
| POST | `/api/refresh` 🔒 |
| GET | `/api/user` 🔒 |

---

## Categories

| Method | Endpoint |
|---|---|
| GET | `/api/categories` |
| POST | `/api/categories` 🔒 |
| GET | `/api/categories/{id}` |
| PUT | `/api/categories/{id}` 🔒 |
| DELETE | `/api/categories/{id}` 🔒 |

### Query Params

| Param | Example |
|---|---|
| search | `?search=elektronik` |
| include | `?include=products` |
| per_page | `?per_page=5` |

---

## Products

| Method | Endpoint |
|---|---|
| GET | `/api/products` |
| POST | `/api/products` 🔒 |
| GET | `/api/products/{id}` |
| PUT | `/api/products/{id}` 🔒 |
| DELETE | `/api/products/{id}` 🔒 |

### Query Params

| Param | Example |
|---|---|
| search | `?search=laptop` |
| include | `?include=category` |
| per_page | `?per_page=5` |

---

# Request Examples

## Register

```http
POST /api/register
```

```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```

---

## Login

```http
POST /api/login
```

```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

---

## Create Category

```http
POST /api/categories
```

```json
{
    "name": "Elektronik",
    "description": "Kategori elektronik"
}
```

---

## Create Product

```http
POST /api/products
```

```json
{
    "name": "Laptop Gaming",
    "description": "Laptop gaming",
    "price": 15000000,
    "stock": 10,
    "internal_note": "Supplier A",
    "category_id": 1
}
```

---

# Response Error

## 401

```json
{
    "status": "error",
    "message": "Unauthorized"
}
```

## 404

```json
{
    "status": "error",
    "message": "Data tidak ditemukan"
}
```

## 422

```json
{
    "status": "error",
    "message": "Validation error"
}
```

---

# Postman

```txt
Import file JSON collection ke Postman.
```

🔒 = Bearer Token Required
