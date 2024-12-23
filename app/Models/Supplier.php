<?php

namespace App\Models;

use App\Traits\HasScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory, HasScope;

    /**
     * fillable
     */
    protected $fillable = ['name', 'telp', 'address'];
}
