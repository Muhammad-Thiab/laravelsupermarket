<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['comment','costumar_id','product_id'];

     public function user()
     {
       return $this->belongsTo(User::class);

     }

    public function product()
    {
      return $this->belongsTo(Product::class);

    }

  //  public $appends= ['created','name'];

    public function getNameAttribute()
    {
        return $this->user->name;
   }
public function   getCreatedAttribute()
{
 //   return $this->ceated_at->diffForHumans();
}
   protected $hidden = [
    'updated_at',
    'created_at',
    'id',
    'user'
  ];

}
