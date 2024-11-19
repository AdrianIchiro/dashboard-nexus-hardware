<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restock extends Model
{
    protected $guarded = ['id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
