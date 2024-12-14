<?php

namespace App\Models;

use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasScope;

    /**
     * fillable
     */
    protected $fillable = ['user_id', 'invoice'];

    /**
     * relation users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * relation transaction details
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
