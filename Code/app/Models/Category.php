<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title','slug','summary','photo','status','is_parent','parent_id','added_by','catgenres'];

    public function parent_info(){
        return $this->hasOne('App\Models\Category','id','parent_id');
    }
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function products() {

        $currentLocale = App::getLocale();

        $currency = session('currency');

        if($currentLocale == "ja") {
            if($currency == "JPY") {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title_jp as title',
                    'summary_jp as summary',
                    'description_jp as description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description_jp as extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
            else if($currency == "HKD") {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title_jp as title',
                    'summary_jp as summary',
                    'description_jp as description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description_jp as extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
            else {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title_jp as title',
                    'summary_jp as summary',
                    'description_jp as description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description_jp as extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
        }
        else {
            //return $this->hasMany('App\Models\Product','cat_id','id')->where('status','active');

            if($currency == "JPY") {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title',
                    'summary',
                    'description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
            else if($currency == "HKD") {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title',
                    'summary',
                    'description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
            else {
                return $this->hasMany('App\Models\Product','cat_id','id')->select(
                    'id',
                    'title',
                    'summary',
                    'description',
                    'slug',
                    'photo',
                    'stock',
                    'size',
                    'condition',
                    'status',
                    'price as price',
                    'price_jp as price_jp',
                    'price_hk as price_hk',
                    'discount',
                    'is_featured',
                    'extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'created_at',
                    'updated_at'
                    )->where('status','active');
            }
        }
    }
    public function sub_products(){
        return $this->hasMany('App\Models\Product','child_cat_id','id')->where('status','active');
    }
    public static function getProductByCat($slug){
        // dd($slug);
        return Category::with('products')->where('slug',$slug)->first();
        // return Product::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getProductBySubCat($slug){
        // return $slug;
        return Category::with('sub_products')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
