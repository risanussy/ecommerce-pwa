<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'product_id', 'total', 'quantity', 'process', 'status'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
