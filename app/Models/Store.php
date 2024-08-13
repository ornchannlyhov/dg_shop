<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'stores';

    protected $primaryKey = 'store_id';

    public $timestamps = true;

    protected $fillable = [
        'store_name',
        'store_description',
        'logo',
        'seller_id',
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'store_id');
    }
    
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'seller_id');
    }
}
