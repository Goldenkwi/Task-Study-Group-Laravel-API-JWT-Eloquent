# Laravel Study Group API 
# JSON import postman include in here so use it for test

REST API dengan JWT Auth, CRUD Resource, dan Relational Model.

---

## Tech Stack

- Laravel 13
- MySQL
- JWT Auth (`tymon/jwt-auth`)
- PHP 8.2+

---

## Setup & Instalasi

### 1. Clone & Install Dependencies
```bash
git clone <repo-url>
cd laravel-studygroup-api
composer install
```

### 2. Konfigurasi `.env`
```bash
cp .env.example .env
```

Edit `.env`:
```env
APP_NAME=laravel-studygroup-api
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel-studygroup-api
DB_USERNAME=root
DB_PASSWORD=

JWT_SECRET=        # diisi otomatis setelah php artisan jwt:secret
AUTH_GUARD=api
```

### 3. Generate Key & JWT Secret
```bash
php artisan key:generate
php artisan jwt:secret
```

### 4. Jalankan Migrasi
```bash
php artisan migrate
```

### 5. Jalankan Seeder (opsional, untuk data dummy)
```bash
php artisan db:seed
```

Atau migrate + seeder sekaligus:
```bash
php artisan migrate:fresh --seed
```

### 6. Jalankan Server
```bash
php artisan serve
```

Server berjalan di `http://localhost:8000`

---

## Struktur Database

### Tabel `users`
| Kolom | Tipe |
|---|---|
| id | bigint |
| name | varchar |
| email | varchar (unique) |
| password | varchar |
| timestamps | - |

### Tabel `categories`
| Kolom | Tipe |
|---|---|
| id | bigint |
| name | varchar |
| description | varchar (nullable) |
| timestamps | - |

### Tabel `products`
| Kolom | Tipe |
|---|---|
| id | bigint |
| name | varchar |
| description | text (nullable) |
| price | integer |
| stock | integer (default 0) |
| internal_note | text |
| category_id | FK → categories.id |
| timestamps | - |

---

## Relasi

- `Category` **hasMany** `Product`
- `Product` **belongsTo** `Category`

---

## Seeder

Project ini menyediakan data dummy untuk testing.

### Data Categories (4 data)
| ID | Name | Description |
|---|---|---|
| 1 | Elektronik | Produk elektronik dan gadget |
| 2 | Pakaian | Pakaian pria dan wanita |
| 3 | Makanan & Minuman | Produk makanan dan minuman |
| 4 | Olahraga | Peralatan dan pakaian olahraga |

### Data Products (7 data)
| ID | Name | Price | Category |
|---|---|---|---|
| 1 | Laptop Gaming ASUS | 15.000.000 | Elektronik |
| 2 | iPhone 15 Pro | 20.000.000 | Elektronik |
| 3 | Samsung Galaxy S24 | 14.000.000 | Elektronik |
| 4 | Kaos Polos Cotton | 75.000 | Pakaian |
| 5 | Kemeja Flannel | 150.000 | Pakaian |
| 6 | Mie Instan Goreng | 3.500 | Makanan & Minuman |
| 7 | Sepatu Running Nike | 1.200.000 | Olahraga |

### Cara Menjalankan Seeder
```bash
# Seeder saja (tanpa hapus data yang ada)
php artisan db:seed

# Fresh migration + seeder (hapus semua data lalu seed ulang)
php artisan migrate:fresh --seed
```

---

## API Endpoints

### Base URL
```
http://localhost:8000/api
```

### Auth Header (untuk endpoint protected)
```
Authorization: Bearer {token}
```

---

## Auth

### POST `/api/register`
Daftarkan user baru dan dapatkan token JWT.

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "status": "success",
    "message": "User created successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "authorization": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "type": "bearer"
    }
}
```

---

### POST `/api/login`
Login dan dapatkan token JWT.

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "status": "success",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "authorization": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "type": "bearer"
    }
}
```

**Response gagal (401):**
```json
{
    "status": "error",
    "message": "unauthorized"
}
```

---

### POST `/api/logout` 🔒
Logout dan invalidate token.

**Response (200):**
```json
{
    "status": "success",
    "message": "Successfully logged out"
}
```

---

### POST `/api/refresh` 🔒
Refresh token JWT.

**Response (200):**
```json
{
    "status": "success",
    "user": { ... },
    "authorization": {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
        "type": "bearer"
    }
}
```

---

### GET `/api/user` 🔒
Ambil data user yang sedang login.

**Response (200):**
```json
{
    "status": "success",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

---

## Categories

### GET `/api/categories`
Ambil semua kategori dengan pagination.

**Query Params:**
| Param | Contoh | Keterangan |
|---|---|---|
| search | `?search=elektronik` | Filter by name/description |
| include | `?include=products` | Load products dalam category |
| per_page | `?per_page=5` | Jumlah item per halaman (default 10) |

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Elektronik",
                "description": "Kategori elektronik",
                "products_count": 3,
                "created_at": "2026-05-10T02:00:00.000000Z",
                "updated_at": "2026-05-10T02:00:00.000000Z"
            }
        ],
        "per_page": 10,
        "total": 1
    }
}
```

---

### GET `/api/categories/{id}`
Ambil detail category. Tambah `?include=products` untuk load products-nya.

**Response dengan `?include=products`:**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Elektronik",
        "products_count": 2,
        "products": [
            {
                "id": 1,
                "name": "Laptop",
                "price": 10000000,
                "stock": 5
            }
        ]
    }
}
```

---

### POST `/api/categories` 🔒
Buat category baru.

**Request Body:**
```json
{
    "name": "Elektronik",
    "description": "Kategori produk elektronik"
}
```

**Response (201):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Elektronik",
        "description": "Kategori produk elektronik",
        "created_at": "2026-05-10T02:00:00.000000Z",
        "updated_at": "2026-05-10T02:00:00.000000Z"
    }
}
```

---

### PUT `/api/categories/{id}` 🔒
Update category.

**Request Body (semua opsional):**
```json
{
    "name": "Elektronik & Gadget",
    "description": "Update deskripsi"
}
```

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Elektronik & Gadget",
        "description": "Update deskripsi"
    }
}
```

---

### DELETE `/api/categories/{id}` 🔒
Hapus category. Gagal jika masih ada product.

**Response sukses (200):**
```json
{
    "status": "success",
    "message": "Category deleted successfully"
}
```

**Response gagal (422):**
```json
{
    "status": "error",
    "message": "Category masih digunakan oleh 3 product"
}
```

---

## Products

### GET `/api/products`
Ambil semua produk dengan pagination.

**Query Params:**
| Param | Contoh | Keterangan |
|---|---|---|
| search | `?search=laptop` | Filter by name/description |
| include | `?include=category` | Load relasi category |
| per_page | `?per_page=5` | Jumlah item per halaman (default 10) |

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "name": "Laptop Gaming",
                "description": "Laptop untuk gaming",
                "price": 15000000,
                "stock": 10,
                "internal_note": "Supplier A",
                "category_id": 1,
                "category": {
                    "id": 1,
                    "name": "Elektronik"
                }
            }
        ],
        "per_page": 10,
        "total": 1
    }
}
```

---

### GET `/api/products/{id}`
Ambil detail product. Tambah `?include=category` untuk load category-nya.

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Laptop Gaming",
        "price": 15000000,
        "stock": 10,
        "category": {
            "id": 1,
            "name": "Elektronik"
        }
    }
}
```

---

### POST `/api/products` 🔒
Buat product baru. `category_id` harus valid.

**Request Body:**
```json
{
    "name": "Laptop Gaming",
    "description": "Laptop untuk gaming",
    "price": 15000000,
    "stock": 10,
    "internal_note": "Supplier A",
    "category_id": 1
}
```

**Response (201):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Laptop Gaming",
        "price": 15000000,
        "category": {
            "id": 1,
            "name": "Elektronik"
        }
    }
}
```

---

### PUT `/api/products/{id}` 🔒
Update product. Semua field opsional.

**Request Body:**
```json
{
    "price": 14000000,
    "stock": 8
}
```

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "name": "Laptop Gaming",
        "price": 14000000,
        "stock": 8
    }
}
```

---

### DELETE `/api/products/{id}` 🔒
Hapus product.

**Response (200):**
```json
{
    "status": "success",
    "message": "Product deleted successfully"
}
```

---

## Error Responses

### 401 Unauthorized
```json
{
    "status": "error",
    "message": "Unauthorized"
}
```

### 404 Not Found
```json
{
    "status": "error",
    "message": "Data tidak ditemukan"
}
```

### 422 Validation Error
```json
{
    "status": "error",
    "message": "Validation error",
    "errors": {
        "name": ["The name field is required."],
        "category_id": ["The selected category id is invalid."]
    }
}
```

---

## Endpoint Summary

| Method | Endpoint | Auth | Keterangan |
|---|---|---|---|
| POST | `/api/register` | ❌ | Register user |
| POST | `/api/login` | ❌ | Login user |
| POST | `/api/logout` | ✅ | Logout |
| POST | `/api/refresh` | ✅ | Refresh token |
| GET | `/api/user` | ✅ | Data user login |
| GET | `/api/categories` | ❌ | List categories |
| POST | `/api/categories` | ✅ | Buat category |
| GET | `/api/categories/{id}` | ❌ | Detail category |
| PUT | `/api/categories/{id}` | ✅ | Update category |
| DELETE | `/api/categories/{id}` | ✅ | Hapus category |
| GET | `/api/products` | ❌ | List products |
| POST | `/api/products` | ✅ | Buat product |
| GET | `/api/products/{id}` | ❌ | Detail product |
| PUT | `/api/products/{id}` | ✅ | Update product |
| DELETE | `/api/products/{id}` | ✅ | Hapus product |

🔒 = Butuh `Authorization: Bearer {token}`
