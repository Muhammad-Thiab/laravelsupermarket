<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['costumar_id',
    'product_id','counter'];
    public function user()
    {
      return $this->belongsTo(User::class);

    }
    public function product()
    {
      return $this->belongsTo(Product::class);

    }
}
