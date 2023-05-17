<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','price','category_id','brand_id','supplier_id','author_id','description','qty','qty_buy','public_date','size','cover','page','status','type','sale_price','start_date','end_date'];
    protected $table = "products";

    public function image() {
        return $this->morphMany(Media::class, 'imageable');
    }
}
