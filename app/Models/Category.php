<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * fillable
     */
    protected $fillable = ['name', 'slug', 'image'];

		/**
		*	relation products
		*/
        public function products()
        {
            return $this->hasMany(Product::class);
        }
}
