# E-Commerce API Documentation 🛍️

This documentation provides details about the available endpoints, request/response formats, and authentication requirements for the E-Commerce API.

## Table of Contents
- [Authentication](#authentication)
- [Public Endpoints](#public-endpoints)
- [Protected Endpoints](#protected-endpoints)
  - [User Endpoints](#user-endpoints)
  - [Seller Endpoints](#seller-endpoints)
  - [Admin Endpoints](#admin-endpoints)

## Authentication

The API uses Laravel Sanctum for authentication. Protected routes require a Bearer token which can be obtained through the login endpoint.

Include the token in the Authorization header:
```
Authorization: Bearer <your_token>
```

## Public Endpoints

### Register User
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
    "role": "user" // Optional (default: "user") - Available roles: "user", "penjual", "admin"
}
```

**Success Response (201):**
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

### Login
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

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Login berhasil",
    "data": {
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com",
            "nohp": "081234567890",
            "role": "user"
        },
        "token": "your_access_token"
    }
}
```

## Protected Endpoints

### Products (Barang)

#### List All Products
```http
GET /api/barang
```

**Success Response (200):**
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

#### Get Product Details
```http
GET /api/barang/{id}
```

**Success Response (200):**
```json
{
    "status": "success",
    "data": {
        "id": 1,
        "nama_barang": "Product Name",
        "harga": 100000,
        "stok": 50,
        "id_penjual": 1
    }
}
```

### Seller Endpoints

#### Create Product
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

**Success Response (201):**
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

#### Update Product
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

**Success Response (200):**
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

#### Delete Product
```http
DELETE /api/barang/{id}
```

**Success Response (200):**
```json
{
    "status": "success",
    "message": "Barang telah dihapus"
}
```

### User Endpoints

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

**Success Response (201):**
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
            "id": 1,
            "nama_barang": "Product Name",
            "harga": 150000,
            "stok": 98
        },
        "user": {
            "id": 1,
            "name": "John Doe"
        }
    }
}
```

#### List User Transactions
```http
GET /api/transaksi
```

**Success Response (200):**
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
            "id": 1,
            "nama_barang": "Product Name"
        },
        "user": {
            "id": 1,
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
    "status": "selesai" // Available statuses: "proses", "selesai", "batal"
}
```

**Success Response (200):**
```json
{
    "message": "Status transaksi berhasil diupdate",
    "data": {
        "id": 1,
        "status": "selesai"
    }
}
```

#### Delete Transaction
```http
DELETE /api/transaksi/{id}
```

**Success Response (200):**
```json
{
    "message": "Transaksi berhasil dihapus"
}
```

## Error Responses

### Validation Error (422)
```json
{
    "status": "error",
    "errors": {
        "field": [
            "Error message"
        ]
    }
}
```

### Authentication Error (401)
```json
{
    "status": "error",
    "message": "Unauthenticated"
}
```

### Authorization Error (403)
```json
{
    "message": "Unauthorized"
}
```

### Not Found Error (404)
```json
{
    "status": "error",
    "message": "Not Found"
}
```

## Notes

- All protected endpoints require authentication using Bearer token
- Dates are returned in ISO 8601 format
- All monetary values are in IDR (Indonesian Rupiah)
- The API will return appropriate HTTP status codes for success and error responses
