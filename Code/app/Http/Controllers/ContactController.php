<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMail;
use App\Mail\ContactUserMail;

class ContactController extends Controller
{
    public function sendContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'subject' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required',
            'message' => 'required',  
             'captcha' => 'required|captcha'
        ]);

        $data = $request->all();

        $admin = env('MAIL_FROM_ADDRESS');
         //$admin = 'gulshanlegal11@gmail.com';
        //Mail::to($data["email"])->send(new ContactMail($data));
        try {
   Mail::to($admin)->send(new ContactMail($data));
         Mail::to($request->email)->send(new ContactUserMail($data));
                         
                        } catch (\Exception $e) {
                      \Log::error($e->getMessage());
                         
                        }
         

        return redirect('contact')->with('success', __('common.message_sent_successfully'));
    }
}
