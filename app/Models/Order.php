<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'store_id', 'total_amount', 'status'];
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}

