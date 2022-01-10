<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Product;

class User extends Model
{
    use HasFactory, HasApiTokens;

    protected $table = "users";

    protected $fillable = [
        "name",
        "email",
        "password",
        "phone_no"
    ];

    public $timestamps = false;
    public function like()
    {
        return $this->hasOne(Like::class);
    }

    public function comment()
    {
      return $this->hasMany(Comment::class);

    }

    public function product()
    {
      return $this->hasMany(Product::class);

    }


}
