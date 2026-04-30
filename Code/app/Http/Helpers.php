<?php

use App\Models\Message;
use App\Models\Category;
use App\Models\Product;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
use Illuminate\Support\Str;

// use Auth;
class Helper
{
    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }

    public static function getHeaderCategory()
    {
        $category = new Category();
        // dd($category);
        $menu = $category->getAllParentWithChild();

        if ($menu) {
?>

            <li>
                <a href="javascript:void(0);">Category<i class="ti-angle-down"></i></a>
                <ul class="dropdown border-0 shadow">
                    <?php
                    foreach ($menu as $cat_info) {
                        if ($cat_info->child_cat->count() > 0) {
                    ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a>
                                <ul class="dropdown sub-dropdown border-0 shadow">
                                    <?php
                                    foreach ($cat_info->child_cat as $sub_menu) {
                                    ?>
                                        <li><a href="<?php echo route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]); ?>"><?php echo $sub_menu->title; ?></a></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </li>
                        <?php
                        } else {
                        ?>
                            <li><a href="<?php echo route('product-cat', $cat_info->slug); ?>"><?php echo $cat_info->title; ?></a></li>
                    <?php
                        }
                    }
                    ?>
                </ul>
            </li>
<?php
        }
    }

    public static function productCategoryList($option = 'all')
    {
        $currentLocale = App::getLocale();
        $currency = session("currency", "USD");

        if ($option = 'all') {

            if($currentLocale == "ja") {
                return Category::select('id', 'title_jp as title', 'slug', 'summary_jp as summary', 'photo', 'status')->where('status','active')->orderBy('id', 'DESC')->get();
            }

            return Category::where('status','active')->orderBy('id', 'DESC')->get();
        }
        return Category::where('status','active')->has('products')->orderBy('id', 'DESC')->get();
    }

    public static function productCountByCategory($categoryID)
    {
        return Product::where("cat_id", $categoryID)->count();
    }

    public static function postTagList($option = 'all')
    {
        if ($option = 'all') {
            return PostTag::orderBy('id', 'desc')->get();
        }
        return PostTag::has('posts')->orderBy('id', 'desc')->get();
    }

    public static function postCategoryList($option = "all")
    {
        if ($option = 'all') {
            return PostCategory::orderBy('id', 'DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
             $user_id = session('guest'); 
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        }
    }
    // relationship cart with product
    public function product()
    {
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public static function getAllProductFromCart($user_id = null)
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            $cartProduct = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();

            $currency = session("currency", "USD");

            $i = 0;
            foreach($cartProduct as $key => $product) {
                if($currency == "JPY") {
                    $cartProduct[$i]["price"] = $cartProduct[$i]["price_jp"];
                    $cartProduct[$i]["amount"] = $cartProduct[$i]["amount_jp"];
                }
                else if($currency == "HKD") {
                    $cartProduct[$i]["price"] = $cartProduct[$i]["price_hk"];
                    $cartProduct[$i]["amount"] = $cartProduct[$i]["amount_hk"];
                }
                $i = $i + 1;
            }

            return $cartProduct;

        } else {
            // if ($user_id == "") $user_id = 0;
             $user_id = session('guest'); 
             $cartProduct = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();

            $currency = session("currency", "USD");

            $i = 0;
            foreach($cartProduct as $key => $product) {
                if($currency == "JPY") {
                    $cartProduct[$i]["price"] = $cartProduct[$i]["price_jp"];
                    $cartProduct[$i]["amount"] = $cartProduct[$i]["amount_jp"];
                }
                else if($currency == "HKD") {
                    $cartProduct[$i]["price"] = $cartProduct[$i]["price_hk"];
                    $cartProduct[$i]["amount"] = $cartProduct[$i]["amount_hk"];
                }
                $i = $i + 1;
            }

            return $cartProduct;

        }
        
       
    }

    public static function getRandomProduct($totalProduct = "5")
    {
        $currentLocale = App::getLocale();
        $currency = session("currency", "USD");

        if($currentLocale == "ja") {
            if($currency == "USD") {
                $products = Product::select(
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
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
            else if($currency == "HKD") {
                $products = Product::select(
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
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
            else {
                $products = Product::select(
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
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
        }
        else {
            //return Product::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();

            if($currency == "USD") {
                $products = Product::select(
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
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
            else if($currency == "HKD") {
                $products = Product::select(
                    'id',
                    'title',
                    'summary',
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
                    'extra_description',
                    'cat_id',
                    'child_cat_id',
                    'brand_id',
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
            else {
                $products = Product::select(
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
                    'genres',
                    'created_at',
                    'updated_at'
                    );
            }
        }

        $products = $products->where('status','active')->paginate($totalProduct);

        return $products;
    }
    // Total amount cart
    public static function totalCartPrice($user_id = '')
    {
        $currency = session("currency", "USD");

        if (Auth::check()) {
             $user_id = auth()->user()->id;
            }
            else {
                 $user_id = session('guest'); 
            }

            if($currency == "JPY") {
                return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount_jp');
            }
            else if($currency == "HKD") {
                return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount_hk');
            }

            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('amount');
        // } else {
        //     return 0;
        // }
    }

    public static function totalCartQuantity($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
          $user_id= session('guest'); 
       return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        }
    }

    // Wishlist Count
    public static function wishlistCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    public static function getAllProductFromWishlist($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;
            return Wishlist::with('product')->where('user_id', $user_id)->where('cart_id', null)->get();
        } else {
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id = '')
    {
        $currency = session("currency", "USD");

        if (Auth::check()) {
            if ($user_id == "") $user_id = auth()->user()->id;

            if($currency == "JPY") {
                return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount_jp');
            }
            else if($currency == "HKD") {
                return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount_hk');
            }

            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        } else {
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id, $user_id)
    {
        $order = Order::find($id);
        dd($id);
        if ($order) {
            $shipping_price = (float)$order->shipping->price;
            $order_price = self::orderPrice($id, $user_id);
            return number_format((float)($order_price + $shipping_price), 2, '.', '');
        } else {
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth()
    {
        $month_data = Order::where('status', 'delivered')->get();
        // return $month_data;
        $price = 0;
        foreach ($month_data as $data) {
            $price = $data->cart_info->sum('price');
        }
        return number_format((float)($price), 2, '.', '');
    }

    public static function shipping()
    {
        return Shipping::orderBy('id', 'DESC')->get();
    }

    public static function getCurrencySymbol($currency) {
        $symbols = [
            'USD' => '$',
            'JPY' => '¥',
            'HKD' => 'HK$',
        ];

        return $symbols[$currency] ?? $currency;
    }
    
    public static function getProductPriceByCurrency($currency, $product) {
        if($currency == "USD") {
            return number_format($product->price, 2);
        }
        else if($currency == "JPY") {
            return number_format($product->price_jp, 0);
        }
        else if($currency == "HKD") {
            return number_format($product->price_hk, 2);
        }
    }
    
    public static function getTotalOrder() {
        $currency = session("currency", "USD");

        if (Auth::check()) {
            
            $user_id = auth()->user()->id;

            return Order::where('user_id', $user_id)->count('id');
        } else {
            return 0;
        }
    }
}



if (!function_exists('generateUniqueSlug')) {
    /**
     * Generate a unique slug for a given title and model.
     *
     * @param string $title
     * @param string $modelClass
     * @return string
     */
    function generateUniqueSlug($title, $modelClass)
    {
        $slug = Str::slug($title);
        $count = $modelClass::where('slug', $slug)->count();

        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }

        return $slug;
    }
}

?>