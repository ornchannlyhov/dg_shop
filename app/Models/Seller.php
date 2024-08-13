<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Seller extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $primaryKey = 'seller_id';
    public $incrementing = true;
    protected $fillable = ['seller_name', 'seller_email','seller_phoneNumber','user_id','store_id'];

    public function store()
    {
        return $this->hasMany(Store::class, 'seller_id');
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    
}
