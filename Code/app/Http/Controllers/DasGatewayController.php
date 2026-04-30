<?php

namespace App\Http\Controllers;
use Srmklive\PayPal\Services\ExpressCheckout;
use Illuminate\Http\Request;
use NunoMaduro\Collision\Provider;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
use DB;
use App\User;
class DasGatewayController extends Controller
{
    public function payment(Request $request) {
        $order_data = $request->all();
 
        $cart = Cart::where('user_id',auth()->user()->id)->where('order_id', $order_data["oid"])->get()->toArray();
       
        $data = [];
       
        // return $cart;
        $data['items'] = array_map(function ($item) use($cart) {
            $name=Product::where('id',$item['product_id'])->pluck('title');
            return [
                'name' =>$name ,
                'price' => $item['price'],
                'desc'  => 'Thank you for using credit card',
                'qty' => $item['quantity']
            ];
        }, $cart);
 
        $data['invoice_id'] = 'ORD-'.strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.failed');
 
        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }
 
        $data['total'] = $total;

        $orderInfo = Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->first();
 
 //return $orderInfo->id;
        $v=Cart::where('order_id', $orderInfo->id)->first();
        //return $v->product_id;
        //$points=Product::where('id', $v->product_id)->pluck('duration')->first();
        $points=$v->points;
       //return $points;
        if($order_data["payment_status"] === "forbidden") {
            Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->update(["payment_status" => "Failed", "trans_id" => $order_data["transaction_id"], "status" => "Payment Failed"]);
            return view('frontend.pages.order-failed')->with('order', $order_data)->with('orderInfo', $orderInfo);
        }
        else {

            if($order_data["transaction_id"] == null) {
                Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->update(["payment_status" => "Failed", "trans_id" => $order_data["transaction_id"], "status" => "Payment Failed"]);
                return view('frontend.pages.order-failed')->with('order', $order_data)->with('orderInfo', $orderInfo);
            }


            //Get Transaction Status
            $url = env("PAYMENT_STATUS_URL")."/".$order_data["transaction_id"];
    
            $headers = array(
                "Authorization: BASIC ".env('SECRET_KEY'),
                'x-api-key: '.env('X_API_KEY'),
                "Content-Type: application/json"
            );
    
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    
            $curl_response = curl_exec($curl);
            curl_close ($curl);
            $result = json_decode($curl_response);

            //print "<pre>";
            //print $url."<br>";
            //print_r($headers);
            //print_r($result);
            //exit();

            if($result && isset($result->message)) {
                if($result->message === "Forbidden") {
                    Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->update([
                        "payment_status" => "Failed",
                        "trans_id" => $order_data["transaction_id"],    "status" => "Payment Failed"
                    ]);
                    return view('frontend.pages.order-failed')->with('order', $order_data)->with('orderInfo', $orderInfo);
                }
            }
    
            if($result->success) {
            //auth()->user()->email 'gulshanlegal11@gmail.com';
                try {
   Mail::to(auth()->user()->email)->bcc('bccunlink@gmail.com')->send(new OrderConfirmationMail($orderInfo,$points));
                          $email_status='active';
                        } catch (\Exception $e) {
                      \Log::error($e->getMessage());
                          $email_status='inactive';
                        }
                
                
                Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->update([
                    "payment_status" => "Completed", 
                    "trans_id" => $order_data["transaction_id"],
                    "status" => "Completed"
                ]);
                //User::where('id', auth()->user()->id)->update([
                //   "points" => $points,
                //   ]);
                // Define a key unique to this product/item
$sessionKey = $order_data["transaction_id"];
if($v->product_id == 1000 && !session()->has($sessionKey)) {
   
    User::where('id', auth()->id())->increment('points', $points);
    session()->put($sessionKey, $sessionKey);
}               
                else {
                
                //User::where('id', auth()->id())->decrement('points', $points);
                }
                return view('frontend.pages.order-success')->with('transaction_id', $order_data["transaction_id"])->with('orderInfo', $orderInfo);
            }
            else {
                Order::where('user_id', auth()->user()->id)->where('id', $order_data["oid"])->update(["payment_status" => "Failed", "trans_id" => $order_data["transaction_id"], "status" => "Payment Failed"]);
                return view('frontend.pages.order-failed')->with('order', $order_data)->with('orderInfo', $orderInfo);
            }
        }
    }

   
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function cancel()
    {
        dd('Your payment is canceled. You can create cancel page here.');
    }
  
    /**
     * Responds with a welcome message with instructions
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        $order_data = $request->all();
        dd($order_data);
        return view('frontend.pages.order-success')->with('order', $order_data);
    }

    public function failed(Request $request)
    {
        $order_data = $request->all();
        return view('frontend.pages.order-failed')->with('order', $order_data);
    }
}
