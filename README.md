# Dokumentasi API

## Gambaran Umum
API ini menyediakan endpoint untuk autentikasi pengguna dan manajemen barang dalam sistem toko. API diamankan dengan Laravel Sanctum untuk endpoint yang terproteksi.

## Model

### Model User (Pengguna)
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

### Model Barang
```php
protected $fillable = [
    'id',
    'nama_barang',
    'harga',
    'stok',
    'id_penjual'
];
```

## Endpoint Autentikasi

### Registrasi Pengguna
```http
POST /api/register

Body Request:
{
    "name": "string",
    "email": "string",
    "password": "string",
    "nohp": "numeric",
    "role": "string|opsional"
}

Aturan Validasi:
- name: wajib diisi, string, maksimal 255 karakter
- email: wajib diisi, string, format email, harus unik di tabel users
- password: wajib diisi, string, minimal 6 karakter
- nohp: wajib diisi, numerik
- role: opsional

Response 201:
{
    "message": "Registrasi user berhasil"
}
```

### Login
```http
POST /api/login

Body Request:
{
    "email": "string",
    "password": "string"
}

Aturan Validasi:
- email: wajib diisi, string, format email
- password: wajib diisi, string

Response 200:
{
    "token": "string_token_akses"
}

Response 401 (Kredensial tidak valid):
{
    "error": "email atau password salah"
}
```

## Endpoint Terproteksi (Memerlukan Autentikasi)
Semua endpoint ini memerlukan token Bearer yang valid di header Authorization:
```http
Authorization: Bearer {token_anda}
```

### Mendapatkan Semua Barang
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

### Membuat Barang Baru
```http
POST /api/barang

Body Request:
{
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric"
}

Aturan Validasi:
- nama_barang: wajib diisi, string, maksimal 255 karakter
- harga: wajib diisi, numerik
- stok: wajib diisi, numerik

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

### Mendapatkan Detail Barang
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
    "message": "Data barang tidak ditemukan"
}
```

### Mengupdate Barang
```http
PUT /api/barang/{id}

Body Request:
{
    "nama_barang": "string",
    "harga": "numeric",
    "stok": "numeric"
}

Aturan Validasi:
- nama_barang: wajib diisi, string, maksimal 255 karakter
- harga: wajib diisi, numerik
- stok: wajib diisi, numerik

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
    "message": "Data barang tidak ditemukan"
}
```

### Menghapus Barang
```http
DELETE /api/barang/{id}

Response 200:
{
    "message": "Barang telah dihapus"
}

Response 404:
{
    "message": "Data barang tidak ditemukan"
}
```

## Rute API
```php
// Rute publik
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rute terproteksi
Route::middleware('auth:sanctum')->group(function () {
    Route::get('barang', [BarangController::class, 'index']);
    Route::post('barang', [BarangController::class, 'store']);
    Route::get('barang/{id}', [BarangController::class, 'show']);
    Route::put('barang/{id}', [BarangController::class, 'update']);
    Route::delete('barang/{id}', [BarangController::class, 'destroy']);
});
```

## Fitur Keamanan
1. Autentikasi menggunakan Laravel Sanctum
2. Validasi input untuk semua endpoint
3. Rute terproteksi yang memerlukan autentikasi
4. Enkripsi password menggunakan Laravel Hash
5. Validasi keunikan email
6. Penanganan error yang tepat

## Relasi Database
- Setiap Barang terhubung dengan User (penjual) melalui foreign key `id_penjual`
- User dapat memiliki banyak data Barang

## Penanganan Error
API mengembalikan kode status HTTP yang sesuai:
- 200: Operasi berhasil
- 201: Berhasil membuat data baru
- 401: Tidak terotentikasi
- 404: Data tidak ditemukan
- 422: Error validasi
