<?php

namespace App\Models;

use App\Exceptions\InternalException;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $fillable = ['title', 'description', 'price', 'stock'];

    protected $casts =['product'];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('Менее инвентарь не должен быть меньше 0');
        }

        return $this->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('Плюс инвентарь не должен быть меньше 0');
        }
        $this->increment('stock', $amount);
    }
}
