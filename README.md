# Laravel API Documentation

## Overview
This API provides endpoints for managing a store's inventory, products, and transactions. The API is secured with authentication and includes input validation for all endpoints.

## Technology Stack
- PHP 8.1
- Laravel 10.x
- MySQL 8.0
- Laravel Sanctum (for authentication)
- Laravel Validation

## Authentication
All endpoints require authentication using Laravel Sanctum. To authenticate:

1. First, obtain an API token:
```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

2. Use the token in subsequent requests:
```http
Authorization: Bearer {your_token}
```

## Models

### Product
```php
class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
```

### Category
```php
class Category extends Model
{
    protected $fillable = [
        'name',
        'description'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
```

### Transaction
```php
class Transaction extends Model
{
    protected $fillable = [
        'user_id',
        'total_amount',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }
}
```

## Controllers

### ProductController
Handles product-related operations:
- List all products
- Show single product
- Create product
- Update product
- Delete product

### CategoryController
Manages product categories:
- List all categories
- Show single category
- Create category
- Update category
- Delete category

### TransactionController
Handles purchase transactions:
- Create new transaction
- List user transactions
- Show transaction details
- Update transaction status

## API Endpoints

### Products

#### List Products
```http
GET /api/products

Response 200:
{
    "data": [
        {
            "id": 1,
            "name": "Product Name",
            "description": "Product Description",
            "price": 99.99,
            "stock": 100,
            "category_id": 1,
            "created_at": "2024-12-22T10:00:00Z",
            "updated_at": "2024-12-22T10:00:00Z"
        }
    ],
    "meta": {
        "current_page": 1,
        "total": 50,
        "per_page": 15
    }
}
```

#### Create Product
```http
POST /api/products
Content-Type: application/json

Request:
{
    "name": "New Product",
    "description": "Product Description",
    "price": 99.99,
    "stock": 100,
    "category_id": 1
}

Response 201:
{
    "data": {
        "id": 1,
        "name": "New Product",
        "description": "Product Description",
        "price": 99.99,
        "stock": 100,
        "category_id": 1,
        "created_at": "2024-12-22T10:00:00Z",
        "updated_at": "2024-12-22T10:00:00Z"
    }
}
```

### Categories

#### List Categories
```http
GET /api/categories

Response 200:
{
    "data": [
        {
            "id": 1,
            "name": "Category Name",
            "description": "Category Description",
            "created_at": "2024-12-22T10:00:00Z",
            "updated_at": "2024-12-22T10:00:00Z"
        }
    ]
}
```

### Transactions

#### Create Transaction
```http
POST /api/transactions
Content-Type: application/json

Request:
{
    "items": [
        {
            "product_id": 1,
            "quantity": 2
        }
    ]
}

Response 201:
{
    "data": {
        "id": 1,
        "total_amount": 199.98,
        "status": "pending",
        "items": [
            {
                "product_id": 1,
                "quantity": 2,
                "unit_price": 99.99
            }
        ],
        "created_at": "2024-12-22T10:00:00Z"
    }
}
```

## Request Validation

### ProductRequest
```php
class ProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ];
    }
}
```

### TransactionRequest
```php
class TransactionRequest extends FormRequest
{
    public function rules()
    {
        return [
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1'
        ];
    }
}
```

## Error Handling

The API returns standard HTTP status codes and JSON error responses:

```json
{
    "error": {
        "message": "Error message here",
        "code": "ERROR_CODE",
        "details": {}
    }
}
```

Common status codes:
- 400: Bad Request (validation errors)
- 401: Unauthorized
- 403: Forbidden
- 404: Not Found
- 422: Unprocessable Entity
- 500: Internal Server Error

## API Routes
```php
// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    // Product routes
    Route::apiResource('products', ProductController::class);
    
    // Category routes
    Route::apiResource('categories', CategoryController::class);
    
    // Transaction routes
    Route::apiResource('transactions', TransactionController::class);
});

// Authentication routes
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
```

## Setup Instructions

1. Clone the repository
2. Copy `.env.example` to `.env` and configure your database
3. Run migrations: `php artisan migrate`
4. Install dependencies: `composer install`
5. Generate application key: `php artisan key:generate`
6. Run the server: `php artisan serve`

## Security Measures

1. **Authentication**: Using Laravel Sanctum for token-based authentication
2. **Input Validation**: All requests are validated using Form Request classes
3. **CORS Protection**: Configured in `config/cors.php`
4. **Rate Limiting**: API routes are rate-limited
5. **SQL Injection Protection**: Using Laravel's query builder and Eloquent ORM
6. **XSS Protection**: Laravel's built-in XSS protection
7. **CSRF Protection**: Enabled for web routes

## Testing

Run the test suite:
```bash
php artisan test
```

## License
MIT License
