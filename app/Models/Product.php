<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Models\User;
use App\Models\Category;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'category_id',
        'created_by',
        'name',
        'description',
        'price',
        'stock_quantity',
        'status',
    ];

    public function owner() {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function order_items() {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeOnlyActive($query) {
        return $query->where('status', 'active');
    }

}
