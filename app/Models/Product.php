<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Costumar;
use App\Models\Category;
use App\Models\Like;
class Product extends Model
{
    use SoftDeletes;
    protected $dates=['deleted_at'];
    use HasFactory;

    protected $table = "projects";

    protected $fillable = [

        'name',
        'expiry_date',
        'photo',
        'quantity',
        'price',
        'social',
        'category_id',

    ];
    protected $hidden = [
        'updated_at',
        'created_at',
        'category_id'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);

    }
    public function category()
    {
      return $this->belongsTo(Category::class);

    }
    public function comment()
    {
      return $this->hasMany(Comment::class);

    }
    public function view()
    {
      return $this->hasMany(View::class);

    }

    public function like()
    {

      return $this->hasMany(Like::class);

    }
    public function product()
    {
      return $this->belongsTo(Category::class);

    }
}
