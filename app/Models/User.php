<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

use App\Models\Product;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
        'provider_id',
        'provider_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public $appends = [
        'name'
    ];

    protected $guard_name = ['admin', 'web'];

    public function getNameAttribute() {
        return $this->attributes['first_name'];
    }

    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function reviews() {
        return $this->hasMany(Review::class);
    }

    public function scopeOnlyVendors($query) {
        return $query->where('role', 'vendor');
    }

    public function scopeExceptUsers($query) {
        return $query->where('role', '!=', 'user');
    }

}
