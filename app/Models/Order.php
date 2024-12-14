<?php

namespace App\Models;

use App\Enums\OrderStatus;
use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, HasScope;

    /**
     * fillable
     */
    protected $fillable = ['user_id', 'product_id', 'quantity', 'status'];

    /**
     * casts
     */
    protected $casts = [
        'status' => OrderStatus::class,
    ];


    /**
     * relation users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relation products
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
