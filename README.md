# API Documentation

## Overview
This API provides endpoints for user authentication and managing items (barang) in a store system. The API is secured with Laravel Sanctum authentication for protected endpoints.

## Models

### User Model
```php
protected $fillable = [
    'id',
    'name',
    'email',
    'password',
    'nohp',
    'role'
];
```

### Barang Model
```php
protected $fillable = [
    'id',
    'nama_barang',
    'harga',
    'stok',
    'id_penjual'
];
```

## Authentication Endpoints

### Register User
```http
POST /api/register

Request Body:
{
    "name": "string",
    "email": "string",
    "password": "string",
    "nohp": "numeric",
    "role": "string|optional"
}

Validation Rules:
- name: required, string, max:255
- email: required, string, email, unique in users table
- password: required, string, min:6
- nohp: required, numeric
- role: optional

Response 201:
{
    "message": "Registrasi user berhasil"
}
```

### Login
```http
POST /api/login

Request Body:
{
    "email": "string",
    "password": "string"
}

Validation Rules:
- email: required, string, email
- password: required, string

Response 200:
{
    "token": "access_token_string"
}

Response 401 (Invalid credentials):
{
    "error": "email atau password salah"
}
```

## Protected Endpoints (Requires Authentication)
All these endpoints require a valid Bearer token in the Authorization header:
```http
Authorization: Bearer {your_token}
```

### Get All Barang
```http
GET /api/barang

Response 200:
[
    {
        "id": "integer",
        "nama_barang": "string",
        "harga": "numeric",
        "stok": "numeric",
        "id_penjual": "integer",
        "created_at": "timestamp",
        "updated_at": "timestamp"
    }
]
```

### Create Barang
```http
POST /api/barang

Request Body:
{
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric"
}

Validation Rules:
- nama_barang: required, string, max:255
- harga: required, numeric
- stok: required, numeric

Response 201:
{
    "id": "integer",
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric",
    "id_penjual": "integer",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}
```

### Get Single Barang
```http
GET /api/barang/{id}

Response 200:
{
    "id": "integer",
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric",
    "id_penjual": "integer",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}

Response 404:
{
    "message": "No query results for model [App\\Models\\Barang] {id}"
}
```

### Update Barang
```http
PUT /api/barang/{id}

Request Body:
{
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric"
}

Validation Rules:
- nama_barang: required, string, max:255
- harga: required, numeric
- stok: required, numeric

Response 200:
{
    "id": "integer",
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric",
    "id_penjual": "integer",
    "created_at": "timestamp",
    "updated_at": "timestamp"
}

Response 404:
{
    "message": "No query results for model [App\\Models\\Barang] {id}"
}
```

### Delete Barang
```http
DELETE /api/barang/{id}

Response 200:
{
    "message": "Barang telah dihapus"
}

Response 404:
{
    "message": "No query results for model [App\\Models\\Barang] {id}"
}
```

## API Routes
```php
// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('barang', [BarangController::class, 'index']);
    Route::post('barang', [BarangController::class, 'store']);
    Route::get('barang/{id}', [BarangController::class, 'show']);
    Route::put('barang/{id}', [BarangController::class, 'update']);
    Route::delete('barang/{id}', [BarangController::class, 'destroy']);
});
```

## Security Features
1. Authentication using Laravel Sanctum
2. Input validation for all endpoints
3. Protected routes requiring authentication
4. Password hashing using Laravel's Hash facade
5. Email uniqueness validation
6. Proper error handling and status codes

## Database Relationships
- Each Barang belongs to a User (penjual) through the `id_penjual` foreign key
- Users can have multiple Barang records

## Error Handling
The API returns appropriate HTTP status codes:
- 200: Successful operation
- 201: Successfully created
- 401: Unauthorized
- 404: Resource not found
- 422: Validation error
