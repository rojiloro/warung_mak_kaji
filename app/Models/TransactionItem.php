<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class TransactionItem extends Model
{
    protected $fillable=[
        'transaction_id',
        'product_id',
        'qty',
        'subtotal'
    ];

    public function product()
    {
        return $this->belongsTo(
            Product::class
        );
    }
}
