<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $fillable = ['shop_name', 'shop_description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
