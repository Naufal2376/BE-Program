<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'nohp',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function isUser(): Attribute
    {
        return new Attribute(
            get: fn () => $this->role === 'user',
        );
    }

    public function isPenjual(): Attribute
    {
        return new Attribute(
            get: fn () => $this->role === 'penjual',
        );
    }

    public function isAdmin(): Attribute
    {
        return new Attribute(
            get: fn () => $this->role === 'admin',
        );
    }
}