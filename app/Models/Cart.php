<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    /**
     * fillable
     */
    protected $fillable = ['user_id', 'product_id', 'quantity'];

    /**
     * user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
