<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();

        // Event setelah data restock dibuat
        static::created(function ($restock) {
            $restock->updateProductStock();
        });
    }

    /**
     * Update stok produk setelah restock.
     */
    public function updateProductStock()
    {
        $product = $this->product;
        if ($product) {
            $product->increment('stock_quantity', $this->quantity);
        }
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class, 'category_id', 'id');
    }
}
