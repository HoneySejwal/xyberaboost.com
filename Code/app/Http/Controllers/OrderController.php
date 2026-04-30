<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Shipping;
use App\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;
use App;
use App\Mail\OrderConfirmationMail;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.order.index')->with('orders',$orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'first_name'=>'string|required',
            'last_name'=>'string',
            'address1'=>'string|required',
            'address2'=>'string|nullable',
            'coupon'=>'nullable|numeric',
            'phone'=>'numeric|required',
            'city' => 'required|string',
            'post_code' => 'required|string',
            'email'=>'string|required',
            'state' => 'required|string',
            'country' => 'required|not_in:0,""',
            'captcha' => 'required|captcha'
        ]);
         //return $request->all();

        if(empty(Cart::where('user_id',auth()->user()->id)->where('order_id',null)->first())){
            request()->session()->flash('error','Cart is Empty !');
            return back();
        }
        
        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-'.strtoupper(Str::random(10));
        $order_data['user_id'] = $request->user()->id;
        $order_data['shipping_id'] = $request->shipping;
        $shipping = Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        $currency = session("currency");
      

        if($currency == "USD") {
            $order_data['sub_total'] = Helper::totalCartPrice();
        }
        else if($currency == "JPY") {
            $order_data['sub_total_jp'] = Helper::totalCartPrice();
        }
        else if($currency == "HKD") {
            $order_data['sub_total_hk'] = Helper::totalCartPrice();
        }
        $order_data['quantity']=Helper::cartCount();

        $order_data['currency'] = session("currency");

        if(session('coupon')){
            $order_data['coupon']=session('coupon')['value'];
        }
        if($request->shipping){
            if(session('coupon')) {
                if($currency == "USD") {
                    $order_data['total_amount'] = Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
                }
                else if($currency == "JPY") {
                    $order_data['total_amount_jp'] = Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
                }
                else if($currency == "HKD") {
                    $order_data['total_amount_hk'] = Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
                }

                $order_data['total_amount'] = Helper::totalCartPrice()+$shipping[0]-session('coupon')['value'];
            }
            else{
                if($currency == "USD") {
                    $order_data['total_amount'] = Helper::totalCartPrice()+$shipping[0];
                }
                else if($currency == "JPY") {
                    $order_data['total_amount_jp'] = Helper::totalCartPrice()+$shipping[0];
                }
                else if($currency == "HKD") {
                    $order_data['total_amount_hk'] = Helper::totalCartPrice()+$shipping[0];
                }

                $order_data['total_amount'] = Helper::totalCartPrice()+$shipping[0];
            }
        }
        else{
            if(session('coupon')) {
                if($currency == "USD") {
                    $order_data['total_amount'] = Helper::totalCartPrice()-session('coupon')['value'];
                }
                else if($currency == "JPY") {
                    $order_data['total_amount_jp'] = Helper::totalCartPrice()-session('coupon')['value'];
                }
                else if($currency == "HKD") {
                    $order_data['total_amount_hk'] = Helper::totalCartPrice()-session('coupon')['value'];
                }

                $order_data['total_amount'] = Helper::totalCartPrice()-session('coupon')['value'];
            }
            else{
                if($currency == "USD") {
                    $order_data['total_amount'] = Helper::totalCartPrice();
                }
                else if($currency == "JPY") {
                    $order_data['total_amount_jp'] = Helper::totalCartPrice();
                }
                else if($currency == "HKD") {
                    $order_data['total_amount_hk'] = Helper::totalCartPrice();
                }

                $order_data['total_amount'] = Helper::totalCartPrice();
            }
        }
        // return $order_data['total_amount'];
        $order_data['status']="New";
        $order_data['payment_method'] = 'credit_card';
        $order_data['payment_status'] = 'Pending';
        $order->fill($order_data);
        $status = $order->save();
        if($order) {
            // dd($order->id);
            $users=User::where('role','admin')->first();
            $details=[
                'title'=>'New order created',
                'actionURL'=>route('order.show', $order->id),
                'fas'=>'fa-file-alt'
            ];

            Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);


            $order_info = Order::find($order->id);
		  
            $country = $order_info['country'];
            $email = $order_info['email'];
            $amount = $order_info['total_amount'];
            $currency = session("currency", "USD");
            $address_1 = $order_info["address1"];
            $phone = $order_info['phone'];
            $city = $order_info['country'];
            $postcode = $order_info['post_code'];
            $zone = $order_info['country'];
            $invoice_ref = 'ORD-'.strtoupper(uniqid());
            $merchant_ip = $_SERVER['REMOTE_ADDR'];
            $visit_ip = "127.0.0.1";
            $comment = "Payment from ecshop-marketing.com";

            $cData = array();
			$cData['number'] = (request('card_number') != null)? request('card_number') : "";
			$cData['number'] = str_replace(" ", "", $cData['number']);
            $cData['expiry_month'] = request('expiry_month');
			$cData['expiry_year'] = request('expiry_year');

            if(trim(request('cvv')) == "") {
				request()->session()->flash('error','Invalid CVC');
                return back();
			}
			else {
			    $cData['cvc'] = (request('cvv') != null)? request('cvv') : "";
			}

            $cData['name'] = (request('name') != null) ? request('name') : "";
			$cData['card_type'] = (request('card_type') != null)? request('card_type') : "";

            $url = env('PAYMENT_URL'); 
            if(session("currency") == "USD") {
                $merchantID = env('USD_DASMID');
                $secret_key = env('SECRET_KEY');
            }
            else if(session("currency") == "JPY") {
                $merchantID = env('JPY_DASMID');
                $secret_key = env('SECRET_KEY');
            }

            $headers = array(
                "Authorization: BASIC ".env('SECRET_KEY'),
                'x-api-key: '.env('X_API_KEY'),
                "Content-Type: application/json"
            );

            $card = array(
                    "cvc" => $cData['cvc'],
                    "expiry_month" => $cData['expiry_month'],
                    "expiry_year" => $cData['expiry_year'],
                    "name" => $cData['name'],
                    "number" => $cData['number']
                );

            $billing_address = array(
                                "country" => $country,
                                "email" => $email,
                                "address1" => $address_1,
                                "phone_number" => $phone,
                                "city" => $city,
                                "state" => $zone,
                                "postal_code" => $postcode
                            );

            $shipping_address = array(
                                "country" => $country,
                                "email" => $email,
                                "address1" => $address_1,
                                "phone_number" => $phone,
                                "city" => $city,
                                "state" => $zone,
                                "postal_code" => $postcode
                            );

            $return_url = array(
                        "webhook_url" => env('WEBSITE_URL')."/cart/payment?payment_status=webhook&oid=".$order->id,
                        "success_url" => env('WEBSITE_URL')."/cart/payment?payment_status=success&oid=".$order->id,
                        "decline_url" => env('WEBSITE_URL')."/cart/payment?payment_status=failed&oid=".$order->id,
                    );


            $post_vals = array(
                "amount" => $amount,
                "currency" => $currency,
                "card" => $card,
                "merchant_txn_ref" => "TOWAGAMEORD".$order->id,
                "customer_ip" => $visit_ip,
                "merchant_id" => $merchantID,
                "return_url" => $return_url,
                "billing_address" => $billing_address,
                "shipping_address" => $shipping_address,
                "time_zone" => "Asia/Kuala_Lumpur"
            );

            $post_data = json_encode($post_vals);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl,CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

            $curl_response = curl_exec($curl);

            curl_close ($curl);

            $result = json_decode($curl_response);

            /*print "<pre>";
            print $url."<br>";
            print_r($post_data);
            print_r($headers);
            print_r($result);
            exit();*/

            //Check result is exist and message key is exist and message value is Forbidden
            if($result && isset($result->message)) {
                if($result->message === "Forbidden") {
                    return redirect('/cart/payment?payment_status=forbidden&oid=' . $order->id . '&transaction_id=')->with('order', $order);
                }
            }

            if($result && count(get_object_vars($result)) > 1) {
				if($result->success) {
                    //session()->forget('cart');
                    //session()->forget('coupon');

                    if (!empty($result->redirect_url)) {
               
                        
                        return redirect()->away($result->redirect_url);
                    }
                    else { 
                         //$orderInfo = Order::where('user_id', auth()->user()->id)->where('id', $order->id)->first();
                //$v=Cart::where('order_id', $orderInfo->id)->first(); 
                        //$points=$v->points;
                        //if($v->product_id==1){
                //User::where('id', auth()->id())->increment('points', $points);
                    //}
                        return redirect("/cart/payment?payment_status=success&oid=".$order->id."&transaction_id=".$result->transaction_details->id);
                    }
				}
				else {
                    return redirect("/cart/payment?payment_status=failed&oid=".$order->id."&transaction_id=".$result->transaction_details->id)->with('order', $order);
				}
			} else {
				return redirect("/cart/payment?payment_status=failed&oid=".$order->id."&transaction_id=");
			}
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order=Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order',$order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order=Order::find($id);
        return view('backend.order.edit')->with('order',$order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order=Order::find($id);
        $this->validate($request,[
            'status'=>'required|in:new,process,delivered,cancel'
        ]);
        $data=$request->all();
        // return $request->status;
        if($request->status=='delivered'){
            foreach($order->cart as $cart){
                $product=$cart->product;
                // return $product;
                $product->stock -=$cart->quantity;
                $product->save();
            }
        }
        $status=$order->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated order');
        }
        else{
            request()->session()->flash('error','Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order=Order::find($id);
        if($order){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Order Successfully deleted');
            }
            else{
                request()->session()->flash('error','Order can not deleted');
            }
            return redirect()->route('order.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack(){
        return view('frontend.pages.order-track');
    }

    public function productTrackOrder(Request $request){
        // return $request->all();
        $order=Order::where('user_id',auth()->user()->id)->where('order_number',$request->order_number)->first();
        if($order){
            if($order->status=="new"){
            request()->session()->flash('success','Your order has been placed. please wait.');
            return redirect()->route('home');

            }
            elseif($order->status=="process"){
                request()->session()->flash('success','Your order is under processing please wait.');
                return redirect()->route('home');
    
            }
            elseif($order->status=="delivered"){
                request()->session()->flash('success','Your order is successfully delivered.');
                return redirect()->route('home');
    
            }
            else{
                request()->session()->flash('error','Your order canceled. please try again');
                return redirect()->route('home');
    
            }
        }
        else{
            request()->session()->flash('error','Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request){
        $order=Order::getAllOrder($request->id);
        // return $order;
        $file_name=$order->order_number.'-'.$order->first_name.'.pdf';
        // return $file_name;
        $points=Cart::where('order_id', $request->id)->pluck('points')->first(); 
        $pdf=PDF::loadview('backend.order.pdf',compact('order','points'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $items=Order::with(['cart_info'])->whereYear('created_at',$year)->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->cart_info->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
