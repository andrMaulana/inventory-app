<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * fillable
     */
    protected $fillable = ['user_id', 'product_id', 'quantity', 'status'];

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
