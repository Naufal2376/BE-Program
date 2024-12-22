# 🛍️ Laravel E-commerce API

A robust RESTful API built with Laravel for managing an e-commerce platform with multiple user roles, product management, and transaction processing.

## 📋 Features

- User Authentication & Authorization
- Multiple User Roles (Admin, Seller, User)
- Product Management
- Transaction Processing
- Role-based Access Control

## 🔑 Authentication

The API uses Laravel Sanctum for authentication. All authenticated routes require a Bearer token.

### Register User

```http
POST /api/register
```

**Request Body:**
```json
{
    "name": "string",
    "email": "string",
    "password": "string",
    "nohp": "string",
    "role": "user|penjual|admin" (optional)
}
```

**Response (201):**
```json
{
    "status": "success",
    "message": "Registrasi berhasil",
    "data": {
        "name": "string",
        "email": "string",
        "nohp": "string",
        "role": "string"
    }
}
```

### Login

```http
POST /api/login
```

**Request Body:**
```json
{
    "email": "string",
    "password": "string"
}
```

**Response (200):**
```json
{
    "status": "success",
    "message": "Login berhasil",
    "data": {
        "user": {
            "name": "string",
            "email": "string",
            "role": "string"
        },
        "token": "string"
    }
}
```

## 📦 Products (Barang)

### List All Products

```http
GET /api/barang
```

**Response (200):**
```json
{
    "status": "success",
    "data": [
        {
            "id": "integer",
            "nama_barang": "string",
            "harga": "integer",
            "stok": "integer",
            "id_penjual": "integer"
        }
    ]
}
```

### Create Product (Seller/Admin Only)

```http
POST /api/barang
```

**Request Body:**
```json
{
    "nama_barang": "string",
    "harga": "integer",
    "stok": "integer"
}
```

**Response (201):**
```json
{
    "status": "success",
    "data": {
        "id": "integer",
        "nama_barang": "string",
        "harga": "integer",
        "stok": "integer",
        "id_penjual": "integer"
    }
}
```

### Update Product (Seller/Admin Only)

```http
PUT /api/barang/{id}
```

**Request Body:**
```json
{
    "nama_barang": "string",
    "harga": "integer",
    "stok": "integer"
}
```

**Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": "integer",
        "nama_barang": "string",
        "harga": "integer",
        "stok": "integer",
        "id_penjual": "integer"
    }
}
```

### Delete Product (Seller/Admin Only)

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

## 💰 Transactions (Transaksi)

### Create Transaction

```http
POST /api/transaksi
```

**Request Body:**
```json
{
    "barang_id": "integer",
    "jumlah": "integer"
}
```

**Response (201):**
```json
{
    "message": "Transaksi berhasil dibuat",
    "data": {
        "id": "integer",
        "user_id": "integer",
        "barang_id": "integer",
        "jumlah": "integer",
        "total_harga": "integer",
        "status": "string",
        "barang": {
            "id": "integer",
            "nama_barang": "string",
            "harga": "integer"
        },
        "user": {
            "id": "integer",
            "name": "string"
        }
    }
}
```

### Update Transaction Status

```http
PUT /api/transaksi/{id}/status
```

**Request Body:**
```json
{
    "status": "proses|selesai|batal"
}
```

**Response (200):**
```json
{
    "message": "Status transaksi berhasil diupdate",
    "data": {
        "id": "integer",
        "status": "string"
    }
}
```

## 🔒 Authorization Rules

### User Roles
- **Admin**: Full access to all endpoints
- **Seller**: Can manage their own products
- **User**: Can view products and manage their own transactions

### Role-specific Access
1. **Admin**
   - Full access to all endpoints
   - Can view all transactions
   - Can manage all products

2. **Seller**
   - Can create/update/delete their own products
   - Can view all products
   - Cannot access transaction endpoints

3. **User**
   - Can view all products
   - Can create and manage their own transactions
   - Cannot manage products

## 🚀 Getting Started

1. Clone the repository
2. Install dependencies:
   ```bash
   composer install
   ```
3. Configure your `.env` file
4. Run migrations:
   ```bash
   php artisan migrate
   ```
5. Generate application key:
   ```bash
   php artisan key:generate
   ```
6. Start the server:
   ```bash
   php artisan serve
   ```

## 💻 Technical Details

- **Authentication**: Laravel Sanctum
- **Database**: MySQL
- **PHP Version**: 8.0+
- **Laravel Version**: 9.0+

## ⚠️ Error Responses

The API returns appropriate HTTP status codes and error messages:

- `400`: Bad Request
- `401`: Unauthorized
- `403`: Forbidden
- `404`: Not Found
- `422`: Validation Error
- `500`: Server Error

Example error response:
```json
{
    "status": "error",
    "message": "Error message here"
}
```

## 🔄 Database Relationships

- `User` has many `Transaksi`
- `Transaksi` belongs to `User` and `Barang`
- `Barang` belongs to `User` (as seller)

## 📝 Notes

- All authenticated routes require a valid Bearer token
- Pagination is not implemented but can be added if needed
- The API uses JSON responses exclusively
- All dates are in UTC timezone
