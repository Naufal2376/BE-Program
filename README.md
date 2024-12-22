# 🛍️ E-Commerce API Documentation

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)

A RESTful API for an e-commerce platform built with Laravel, featuring user authentication, product management, and transaction processing.

## 📋 Table of Contents
- [Requirements](#-requirements)
- [Installation](#-installation)
- [Authentication](#-authentication)
- [API Endpoints](#-api-endpoints)
  - [Auth Endpoints](#auth-endpoints)
  - [Product Endpoints](#product-endpoints)
  - [Transaction Endpoints](#transaction-endpoints)

## 🔧 Requirements
- PHP >= 8.0
- Composer
- MySQL
- Laravel 9.x

## 🚀 Installation

1. Clone the repository
```bash
git clone https://github.com/Naufal2376/BE-Program.git
```

2. Install dependencies
```bash
composer install
```

3. Create and configure .env file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations
```bash
php artisan migrate
```

6. Install Sanctum
```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

7. Start the server
```bash
php artisan serve
```

## 🔐 Authentication

This API uses Laravel Sanctum for authentication. Include the token in the Authorization header:
```
Authorization: Bearer {your-token}
```

## 📡 API Endpoints

### Auth Endpoints

#### Register User
```http
POST /api/register
```

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "nohp": "081234567890",
    "role": "user" // Optional: "user", "penjual", or "admin"
}
```

**Response (201):**
```json
{
    "status": "success",
    "message": "Registrasi berhasil",
    "data": {
        "name": "John Doe",
        "email": "john@example.com",
        "nohp": "081234567890",
        "role": "user"
    }
}
```

#### Login
```http
POST /api/login
```

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
    "message": "Login berhasil",
    "data": {
        "user": {
            "name": "John Doe",
            "email": "john@example.com",
            "role": "user"
        },
        "token": "your-access-token"
    }
}
```

### Product Endpoints

#### Get All Products
```http
GET /api/barang
```

**Response (200):**
```json
{
    "status": "success",
    "data": [
        {
            "id": 1,
            "nama_barang": "Product Name",
            "harga": 100000,
            "stok": 50,
            "id_penjual": 1
        }
    ]
}
```

#### Create Product (Seller/Admin Only)
```http
POST /api/barang
```

**Request Body:**
```json
{
    "nama_barang": "New Product",
    "harga": 150000,
    "stok": 100
}
```

**Response (201):**
```json
{
    "status": "success",
    "data": {
        "nama_barang": "New Product",
        "harga": 150000,
        "stok": 100,
        "id_penjual": 1
    }
}
```

#### Update Product (Seller/Admin Only)
```http
PUT /api/barang/{id}
```

**Request Body:**
```json
{
    "nama_barang": "Updated Product",
    "harga": 200000,
    "stok": 75
}
```

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "nama_barang": "Updated Product",
        "harga": 200000,
        "stok": 75,
        "id_penjual": 1
    }
}
```

#### Delete Product (Seller/Admin Only)
```http
DELETE /api/barang/{id}
```

**Response (200):**
```json
{
    "status": "success",
    "message": "Barang telah dihapus"
}
```

### Transaction Endpoints

#### Create Transaction
```http
POST /api/transaksi
```

**Request Body:**
```json
{
    "barang_id": 1,
    "jumlah": 2
}
```

**Response (201):**
```json
{
    "message": "Transaksi berhasil dibuat",
    "data": {
        "user_id": 1,
        "barang_id": 1,
        "jumlah": 2,
        "total_harga": 300000,
        "status": "proses",
        "barang": {
            "nama_barang": "Product Name",
            "harga": 150000
        },
        "user": {
            "name": "John Doe"
        }
    }
}
```

#### Get User Transactions
```http
GET /api/transaksi
```

**Response (200):**
```json
[
    {
        "id": 1,
        "user_id": 1,
        "barang_id": 1,
        "jumlah": 2,
        "total_harga": 300000,
        "status": "proses",
        "barang": {
            "nama_barang": "Product Name",
            "harga": 150000
        },
        "user": {
            "name": "John Doe"
        }
    }
]
```

#### Update Transaction Status
```http
PUT /api/transaksi/{id}/status
```

**Request Body:**
```json
{
    "status": "selesai" // Options: "proses", "selesai", "batal"
}
```

**Response (200):**
```json
{
    "message": "Status transaksi berhasil diupdate",
    "data": {
        "id": 1,
        "status": "selesai"
    }
}
```

## 🔒 Role-Based Access Control

The API implements three user roles:
- **User**: Can view products and manage their own transactions
- **Seller**: Can manage their own products
- **Admin**: Has full access to all endpoints

## ⚠️ Error Responses

**Validation Error (422):**
```json
{
    "status": "error",
    "errors": {
        "field": ["Error message"]
    }
}
```

**Authentication Error (401):**
```json
{
    "status": "error",
    "message": "Unauthorized"
}
```

**Not Found Error (404):**
```json
{
    "status": "error",
    "message": "Resource not found"
}
```

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details
