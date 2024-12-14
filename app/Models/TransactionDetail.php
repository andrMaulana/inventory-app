<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    /**
     * fillable
     */
    protected $fillable = ['transaction_id', 'product_id', 'quantity'];

    /**
     * relation transactions
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * relation products
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
