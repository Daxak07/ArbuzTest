<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

     protected $fillable = ['address', 'phone', 'delivery_day', 'delivery_period', 'status'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_product', 'order_id', 'product_id')->withPivot('quantity');
    }

    public function deliveryPeriod()
    {
        return $this->belongsTo(DeliveryPeriod::class);
    }
    public function getTotalWeight()
    {
        return $this->products->sum(function ($product) {
            return $product->pivot->quantity * $product->weight;
        });
    }
}
