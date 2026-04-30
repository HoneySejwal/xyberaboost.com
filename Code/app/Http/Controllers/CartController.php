<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Helper;
use App\User;
use App\Mail\RedeemConfirmationMail;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller
{
    protected $product=null;
    public function __construct(Product $product){
        $this->product=$product;
    }

    public function addToCart(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        //$product = Product::where('slug', $request->slug)->first();
        $product = Product::getProductBySlug($request->slug);

        // return $product;
        if (empty($product)) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $product->price + $already_cart->amount;
            $already_cart->amount_jp = $product->price_jp + $already_cart->amount_jp;
            $already_cart->amount_hk = $product->price_hk + $already_cart->amount_hk;
            // return $already_cart->quantity;
            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $product->id;
            $cart->currency = session("currency", "USD");
            $cart->price = $product->price;
            $cart->price_jp = $product->price_jp;
            $cart->price_hk = $product->price_hk;
            $cart->quantity = 1;
            $cart->amount = $cart->price * $cart->quantity;
            $cart->amount_jp = $cart->price_jp * $cart->quantity;
            $cart->amount_hk = $cart->price_hk * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');
            $cart->save();
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
        }
        request()->session()->flash('success',__('common.product_add'));
        return back();       
    }  

   public function singleAddToCart(Request $request){ 
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
            'hours' => 'nullable|integer|min:0|max:10',
        ]);
        // dd($request->quant[1]);
 //return $request;

       
        $product = Product::getProductBySlug($request->slug);
       
     if (!session('guest')) {
    Session::put('guest', rand(100000, 999999));
     }   
    $user_id = auth()->check() ? auth()->id() : session('guest');
    $cartp = Cart::where('user_id', $user_id)->where('order_id',null)->pluck('product_id')->first();
        //return $product->id.$cartp;
       //return $cartp;
       
       if(isset($cartp) && $cartp==1000 && $product->id<1000)
            {
       return back()->with('error',__('common.purchase_existing_credits'));
            }
       
       
        //return $product;
        $hours = max(0, min(10, (int) $request->input('hours', 0)));

        if ($hours > 0) {
            $true_price = $product->price + (20 * $hours);
            $true_price_jp = $product->price_jp + (20 * $hours);
            $true_price_hk = $product->price_hk + (20 * $hours);
        } else {
            $true_price = $product->price;
            $true_price_jp = $product->price_jp;
            $true_price_hk = $product->price_hk;
        }
        
        
        if($product->stock <$request->quant[1]){
            return back()->with('error','Out of stock, You can add other products.');
        }
        if ( ($request->quant[1] < 1) || empty($product) ) {
            request()->session()->flash('error','Invalid Products');
            return back();
        }    
if (Auth::check()) {
    
        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $product->id)->first();
$cartp = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->pluck('product_id')->first();
}

else {

    if (!session('guest')) {
    Session::put('guest', rand(100000, 999999));
     }
    $guest= session('guest');   
     
        $already_cart = Cart::where('user_id', $guest)->where('order_id',null)->where('product_id', $product->id)->first();
    
}
       
        // return $already_cart;
//$already_cart='';

        if($already_cart) {
            
             return back()->with('error',__('common.product_already_in_cart'));
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
             $already_cart->amount = ($true_price * $request->quant[1])+ $already_cart->amount;
            $already_cart->amount_jp = ($true_price_jp * $request->quant[1])+ $already_cart->amount_jp;
            $already_cart->amount_hk = ($true_price_hk * $request->quant[1])+ $already_cart->amount_hk;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0) return back()->with('error','Stock not sufficient!.');

            $already_cart->save();
            
        }
        else
        {
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id ?? $guest;
            $cart->product_id = $product->id;
            // $cart->currency = session("currency", "USD");
            $cart->price = $true_price;
            $cart->price_jp = $true_price_jp;
            $cart->price_hk = $true_price_hk;
            $cart->quantity = $request->quant[1];
            $cart->hours = $hours;
            $cart->amount = $cart->price * $cart->quantity;
            $cart->amount_jp = $cart->price_jp * $cart->quantity;
            $cart->amount_hk = $cart->price_hk * $cart->quantity;
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','1- Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success',__('common.product_add'));
        return back();       
    }
    
    public function pointsAddToCart(Request $request){
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
            'hours' => 'nullable|integer|min:0|max:10',
        ]);
        // dd($request->quant[1]);
 //return $request;
if($request->slug=='points')
{
    //return $request;
}
        //$product = Product::getProductBySlug($request->slug);
       if (!session('guest')) {
           Session::put('guest', rand(100000, 999999));
                    }
       $guest= session('guest');  
       $user_id = auth()->user()->id ?? $guest;
       $cartp = Cart::where('user_id', $user_id)->where('order_id',null)->pluck('product_id')->first();
       
        if(isset($cartp) && $cartp<1000)
            {
        return back()->with('error',__('common.can_not_add'));
            }
       

       
       $already_cart = Cart::where('user_id', $user_id)->where('order_id',null)->where('product_id', 1000)->first();
          //return $already_cart;
//$already_cart='';
       // Calculation for points range
        
       $truepoints=$request->points;
       //return $request->points.'-'.$request->price;
      
       //
      //$truepoints_jp=session('currency')=='JPY' ? $request->price : 2;
      //$truepoints_hk=session('currency')=='HKD' ? $request->price : 2;
       if(session('currency')=='JPY')
       {
    $price=$request->price/160;   
    $truepoints_jp=$request->price;
    $truepoints_hk=8*$price;
       }
       if(session('currency')=='HKD')
       {
    $price=$request->price/8;   
    $truepoints_jp=20*$request->price;
    $truepoints_hk=$request->price; //$truepoints_hk=8*$price;
       }
       if(session('currency')=='USD'){
    $price=$request->price;   
    $truepoints_jp=160*$request->price;
    $truepoints_hk=8*$request->price;
       }
       
        if($already_cart) {
            
            
            $already_cart->quantity = 1;
            // $already_cart->price = ($product->price * $request->quant[1]) + $already_cart->price ;
           
            $already_cart->amount = ($price)+ $already_cart->amount;
            $already_cart->amount_jp = ($truepoints_jp)+ $already_cart->amount_jp;
            $already_cart->amount_hk = ($truepoints_hk)+ $already_cart->amount_hk;
            $already_cart->price=($price)+ $already_cart->price;
            $already_cart->price_jp=$already_cart->amount_jp;
            $already_cart->price_hk=$already_cart->amount_hk;
           //$already_cart->increment('points', $request->points);
        

        //$truepoints= $already_cart->price+$request->points;
            //return 'aaa-'.$truepoints;
            if(session('currency')=='JPY')
            {
                 $price_jp=$already_cart->price_jp;
                 $truepoints=$price_jp/160;
                //return $price_jp;
             switch (true) {
    case ($price_jp >1 && $price_jp < 100001):        
        $truepoints=$truepoints;
        break;

    case ($price_jp > 100000 && $price_jp < 300001):
        $truepoints = round($truepoints * 1.5);
        break;

    case ($price_jp > 300000 && $price_jp < 500001):       
        $truepoints = round($truepoints * 2);
        break;
    case ($price_jp > 500000):  
        $truepoints = round($truepoints * 5);
        break;
               
        default:      
        $truepoints=$truepoints;
        break;
}
            }
              if(session('currency')=='HKD')
            {
                 $price_hk=$already_cart->price_hk;
                 $truepoints=$price_hk/8;
                //return $price_jp;
             switch (true) {
    case ($price_hk >1 && $price_hk < 5001):        
        $truepoints=$truepoints;
        break;

    case ($price_hk > 5000 && $price_hk < 15001):
        $truepoints = round($truepoints * 1.5);
        break;

    case ($price_hk > 15000 && $price_hk < 25001):       
        $truepoints = round($truepoints * 2);
        break;
    case ($price_hk > 25000):  
        $truepoints = round($truepoints * 5);
        break;
               
        default:      
        $truepoints=$truepoints;
        break;
}
            }
            if(session('currency')=='USD')
            {
                $truepoints=$already_cart->price;
                 //return $truepoints;
             switch (true) {
    case ($truepoints >1 && $truepoints < 601):        
        $truepoints=$truepoints;
        break;

    case ($truepoints > 601 && $truepoints < 2001):
        $truepoints = round($truepoints * 1.5);
        break;

    case ($truepoints > 2000 && $truepoints < 3201):       
        $truepoints = round($truepoints * 2);
        break;
    case ($truepoints > 3200):  
        $truepoints = round($truepoints * 5);
        break;
               
        default:      
        $truepoints=$truepoints;
        break;
}
            }
            
            $already_cart->points=$truepoints;
            $already_cart->save();
            
        }
        else
        {
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id ?? $guest;
            $cart->product_id = 1000;
            // $cart->currency = session("currency", "USD");
            $cart->price = $price;
            $cart->price_jp = $truepoints_jp;
            $cart->price_hk = $truepoints_hk;
            $cart->quantity = $request->quant[1];
            $cart->amount = $price;
            $cart->amount_jp = $truepoints_jp;
            $cart->amount_hk = $truepoints_hk;
            $cart->points = $request->points;
            
           
            //if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0) return back()->with('error','1- Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success',__('common.product_add'));
        return back();       
    } 
   
                                        
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success',__('common.product_removed'));
            return back();  
        }
        request()->session()->flash('error',__('common.please_try_again'));
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    /*if($cart->product->stock < $quant){
                        request()->session()->flash('error','Out of stock');
                        return back();
                    }*/

                    //$cart->quantity = ($cart->product->stock > $quant) ? $quant  : $cart->product->stock;
                    $cart->quantity = $quant;
                    // return $cart;
                    
                    //if ($cart->product->stock <=0) continue;
                    $after_price=($cart->product->price-($cart->product->price*$cart->product->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;



                    $updatAmount = ($cart->product->price) * $quant;
                    $updatAmount_JP = ($cart->product->price_jp) * $quant;
                    $updatAmount_HK = ($cart->product->price_hk) * $quant;
                    Cart::where('id', $id)->update(['quantity' => $quant, 'amount' => $updatAmount, 'amount_jp' => $updatAmount_JP,'amount_hk' => $updatAmount_HK]);
                    

                    //$cart->save();
                    $success = 'Cart successfully updated!';
                }else{
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Cart Invalid!');
        }    
    }
public function trainingdelete(Request $request){
        $cart = Cart::find($request->id);
        //return $cart;
        $product_detail=Product::find($cart->product_id);
        $product_detail= Product::getProductBySlug($product_detail->slug); 
           //return $product_detail;    
                                        
               
        
        $quantity = max(1, (int) $cart->quantity);

        Cart::where('id', $cart->id)->update([
            'price_jp' => $product_detail->price_jp,
            'price' => $product_detail->price,
            'price_hk' => $product_detail->price_hk,
            'amount' => $product_detail->price * $quantity,
            'amount_jp' => $product_detail->price_jp * $quantity,
            'amount_hk' => $product_detail->price_hk * $quantity,
            'hours' => 0,
        ]);
         
                    //$cart->save();
                    $success = __('common.training_removed_success');
        
        return back()->with('success', $success);
        
       
          
    }
public function pointsredeem(Request $request){
    //return Helper::getAllProductFromCart()->product_id;
    $cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->first();
    
    $redeempoints= $cart->price;    
    $avpoints=User::where('id',auth()->user()->id)->pluck('points')->first();
    if($redeempoints>$avpoints)
    {
     return back()->with('error',__('common.sufficient_credit_points') ); 
    }
    User::where('id', auth()->id())->decrement('points', $redeempoints);
    $order_id=rand(100000, 999999);
    $cart->update([
        'order_id' => $order_id,
        'status' => 'Redeemed'
    ]);
    
    $redeemed=Cart::where('user_id', auth()->user()->id)->where('order_id',$order_id)->with('product')->first();
    
    
    $success = __('common.order_placed_success');
        //return $redeemed;
    
    
    try {
   Mail::to(auth()->user()->email)->bcc('bccunlink@gmail.com')->send(new RedeemConfirmationMail($redeemed));
                          $email_status='active';
                        } catch (\Exception $e) {
                      \Log::error($e->getMessage());
                          $email_status='inactive';
                        }
        return back()->with('success', $success);
    
    }    
    // public function addToCart(Request $request){
    //     // return $request->all();
    //     if(Auth::check()){
    //         $qty=$request->quantity;
    //         $this->product=$this->product->find($request->pro_id);
    //         if($this->product->stock < $qty){
    //             return response(['status'=>false,'msg'=>'Out of stock','data'=>null]);
    //         }
    //         if(!$this->product){
    //             return response(['status'=>false,'msg'=>'Product not found','data'=>null]);
    //         }
    //         // $session_id=session('cart')['session_id'];
    //         // if(empty($session_id)){
    //         //     $session_id=Str::random(30);
    //         //     // dd($session_id);
    //         //     session()->put('session_id',$session_id);
    //         // }
    //         $current_item=array(
    //             'user_id'=>auth()->user()->id,
    //             'id'=>$this->product->id,
    //             // 'session_id'=>$session_id,
    //             'title'=>$this->product->title,
    //             'summary'=>$this->product->summary,
    //             'link'=>route('product-detail',$this->product->slug),
    //             'price'=>$this->product->price,
    //             'photo'=>$this->product->photo,
    //         );
            
    //         $price=$this->product->price;
    //         if($this->product->discount){
    //             $price=($price-($price*$this->product->discount)/100);
    //         }
    //         $current_item['price']=$price;

    //         $cart=session('cart') ? session('cart') : null;

    //         if($cart){
    //             // if anyone alreay order products
    //             $index=null;
    //             foreach($cart as $key=>$value){
    //                 if($value['id']==$this->product->id){
    //                     $index=$key;
    //                 break;
    //                 }
    //             }
    //             if($index!==null){
    //                 $cart[$index]['quantity']=$qty;
    //                 $cart[$index]['amount']=ceil($qty*$price);
    //                 if($cart[$index]['quantity']<=0){
    //                     unset($cart[$index]);
    //                 }
    //             }
    //             else{
    //                 $current_item['quantity']=$qty;
    //                 $current_item['amount']=ceil($qty*$price);
    //                 $cart[]=$current_item;
    //             }
    //         }
    //         else{
    //             $current_item['quantity']=$qty;
    //             $current_item['amount']=ceil($qty*$price);
    //             $cart[]=$current_item;
    //         }

    //         session()->put('cart',$cart);
    //         return response(['status'=>true,'msg'=>'Cart successfully updated','data'=>$cart]);
    //     }
    //     else{
    //         return response(['status'=>false,'msg'=>'You need to login first','data'=>null]);
    //     }
    // }

    // public function removeCart(Request $request){
    //     $index=$request->index;
    //     // return $index;
    //     $cart=session('cart');
    //     unset($cart[$index]);
    //     session()->put('cart',$cart);
    //     return redirect()->back()->with('success','Successfully remove item');
    // }

    public function checkout(Request $request){
         if(!Auth::check()) {
            return redirect()->route('login.form');
        }
        
        $user_id = auth()->check() ? auth()->id() : session('guest');        
        $product_id = Cart::where('user_id', $user_id)->where('order_id',null)->pluck('product_id')->first();
        $cart = Cart::where('user_id', $user_id)->where('order_id',null)->get();
        $product_id_collection = $cart->pluck('product_id');
        //return $all_product_ids;
        if ($product_id_collection->contains(1000)) {
      $cart = Cart::where('user_id', $user_id)->where('order_id',null)->where('product_id', '<', 1000)->delete();
            return view('frontend.pages.checkout');
         }
        else {
             return view('frontend.pages.gamecart');
        }
   
        
    }
}
