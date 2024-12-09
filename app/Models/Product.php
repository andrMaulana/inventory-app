<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'supplier_id', 'name', 'slug', 'description', 'quantity','image', 'unit'
    ];

    /**
    * relation categories
    */

    public function category() {
        return $this->belongsTo(Category::class);
    }

    /**
    * relation suppliers
    */

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    /**
    t* relation cstock
    */

    public function stock(){
        return $this->hasOne(Stock::class);
    }

    /**
    * relation sctocks
    */

    public function stocks(){
        return $this->hasMany(Stock::class);
}

}
