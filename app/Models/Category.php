<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    public function products() {
        return $this->hasMany(Product::class);
    }

    public function scopeOnlyActive($query) {
        return $query->where('status', 'active');
    }
}
