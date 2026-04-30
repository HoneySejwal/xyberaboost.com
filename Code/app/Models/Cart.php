<?php

namespace App\Models;
use App;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['user_id','product_id','order_id','quantity', 'amount', 'amount_jp', 'currency', 'price', 'price_jp', 'status'];
    
    // public function product(){
    //     return $this->hasOne('App\Models\Product','id','product_id');
    // }
    // public static function getAllProductFromCart(){
    //     return Cart::with('product')->where('user_id',auth()->user()->id)->get();
    // }
    public function product()
    {
        // return $this->belongsTo(Product::class, 'product_id');

        $currentLocale = App::getLocale();

        if($currentLocale == "ja") {
            // return $this->hasOne('App\Models\Category', 'id', 'cat_id')
            // ->select(['id', 'title_jp as title']);
            return $this->belongsTo(Product::class, 'product_id')
            ->select(['id','title_jp as title','slug','stock', 'photo', 'price_jp as price']);
            return $this->belongsTo(Product::class, 'product_id');
        }
        else {
            return $this->belongsTo(Product::class, 'product_id');
        }
    }
    // public function product()
    // {
    //     return $this->belongsTo(Product::class, 'product_id');
    // }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
