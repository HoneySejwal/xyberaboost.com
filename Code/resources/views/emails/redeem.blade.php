<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="x-apple-disable-message-reformatting">
<title>Order Confirmation</title>
  <link href="https://fonts.googleapis.com/css?family=Nunito+Sans:200,300,400,600,700" rel="stylesheet">    
<style>
html, body {
    margin: 0 auto !important;
    padding: 0 !important;
    height: 100% !important;
    width: 100% !important;
    background: #f1f1f1;
}
* {
    -ms-text-size-adjust: 100%;
    -webkit-text-size-adjust: 100%;
}
div[style*="margin: 16px 0"] { margin: 0 !important; }
table, td { mso-table-lspace: 0pt !important; mso-table-rspace: 0pt !important; }
table { border-spacing: 0 !important; border-collapse: collapse !important; table-layout: fixed !important; margin: 0 auto !important; }
img { -ms-interpolation-mode:bicubic; }
a { text-decoration: none; }
*[x-apple-data-detectors], .unstyle-auto-detected-links *, .aBn {
    border-bottom: 0 !important; cursor: default !important; color: inherit !important;
    text-decoration: none !important; font-size: inherit !important; font-family: inherit !important;
    font-weight: inherit !important; line-height: inherit !important;
}
.a6S { display: none !important; opacity: 0.01 !important; }
.im { color: inherit !important; }
img.g-img + div { display: none !important; }

/* Responsive fix for iPhones */
@media only screen and (max-width: 414px) {
    u ~ div .email-container { min-width: 100% !important; }
}

/* ==== THEME STYLES ==== */
.primary-bg { background: #BDE3C3 !important; }
.bg_white { background: #ffffff; }
.bg_black { background: #000000; }
.email-section { padding: 10px 20px; }

.btn {
    padding: 8px 20px; display: inline-block; border-radius: 5px;
    font-weight: bold; letter-spacing: 0.5px;
}
.btn-primary { background: #BDE3C3; color: #000 !important; }
.btn-black { background: #000; color: #fff !important; }

h1,h2,h3,h4,h5,h6 {
    font-family: 'Nunito Sans', Arial, sans-serif; color: #000; margin-top: 0;
}
body {
    font-family: 'Nunito Sans', Arial, sans-serif;
    font-size: 15px; line-height: 1.8; color: rgba(0,0,0,.6);
}
.logo h1 { margin: 0; }
.logo h1 a { color: #000; font-size: 20px; font-weight: 700; }
.navigation li {
    list-style: none; display: inline-block; margin-left: 10px;
    font-size: 13px; font-weight: 600;
}
.navigation li a { color: rgba(0,0,0,.6); }

.pricing {
    border: 1px solid #BDE3C3;
    padding: 1.5em;
    border-radius: 6px;
    text-align: left;
    background: #bde3c338;
}
.pricing p { margin: 8px 0; font-size: 14px; color: #333; }
.pricing p strong { width:150px;}

.footer { color: rgba(255,255,255,.8); }
.footer a { color: #fff; text-decoration: underline; }
</style>
</head>

<body style="margin:0; padding:0; background-color:#f1f1f1;">
<center style="width:100%; background-color:#f1f1f1;">
  <div style="max-width:600px; margin:0 auto;" class="email-container">
    <!-- HEADER -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" class="bg_white" style="padding:20px;">
      <tr>
        <td width="40%" class="logo" style="text-align:left;padding: 0px 10px !important;">
          <h1><a href="{{ env('WEBSITE_URL') }}">{{ env('APP_NAME') }}</a></h1>
        </td>
        <td width="60%" style="text-align:right;padding: 0px 10px !important;">
          <ul class="navigation" style="margin:0; padding:0;">
            <li><a href="{{ env('WEBSITE_URL') }}">Home</a></li>
            <li><a href="{{ env('WEBSITE_URL') }}/about-us">About</a></li>
            <li><a href="{{ env('WEBSITE_URL') }}/contact">Contact</a></li>
            <li><a href="{{ env('WEBSITE_URL') }}/user/login">Login</a></li>
          </ul>
        </td>
      </tr>
    </table>

    <!-- HERO SECTION -->
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td class="hero bg_white">
          <table role="presentation" width="100%">
            <tr>
             
              <td width="100%" class="primary-bg" style="text-align:left; padding:25px;">
                <h1>Game Redeemed</h1>
                <p>Order #{{ $order->order_id }}</p>
                <p><a href="{{ env('WEBSITE_URL') }}" class="btn btn-black">Visit us</a></p>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>

    <!-- BODY CONTENT -->
    <table role="presentation" width="100%" class="bg_white" cellspacing="0" cellpadding="0" border="0">
      <tr>
        <td class="email-section" style="text-align:center;">
          <h2>Hey Gamer,</h2>
            <p>You did it! Your points have been successfully spent, and your game boosting order is officially live. Time to sit back, relax, and watch your ranks, stats, and skills level up like a pro.</p>
          
        </td>
      </tr>


      <tr>
        <td class="email-section" style="text-align:center;">
          <h2>Here's the lowdown on your order::</h2>
          <div class="pricing">
              <h4>Boosting Service Details</h4>
              <p><strong>Service Purchased:</strong> {{$order->product->title}}</p>
              <!--
              <p><strong>Current Rank/Level:</strong> [If applicable]</p>
              <p><strong>Target Rank/Level:</strong> [If applicable]</p>
              -->
              <p><strong>Points Spent:</strong> {{$order->price}}</p>
              <p><strong>Order ID:</strong> {{$order->order_id}}</p>
            <p><strong>Order Date:</strong> {{ $order->created_at->format('D d M, Y') }}</p>
           
            <!--
            <p style="text-align:center; margin-top:20px;">
              <a href="{{ env('WEBSITE_URL') }}/user/order/show/{{$order['id']}}" class="btn btn-primary">View Detail</a>
            </p>
            -->
          </div>
        </td>
      </tr>
        <tr>
        <td style="text-align:center;">
        
            <p style="margin:10px 0 0;padding:10px;text-align:left;">Your points have already been added to your account — no waiting around. Jump in anytime and use them on your favourite boosting services.<br><br>
                    Got questions? Need help? Just hit reply or reach out to our support team — we’ve got your back.<br><br>Thanks for rolling with us. Now sit back, relax, and watch those stats go up.
</p>
            <p>GG and good luck,<br>
      {{env('MAIL_FROM_NAME')}} <br>Customer Support Team</p>
            
          <p style="margin:10px 0 0;padding:10px;">If you need any help, email us at 
            <a href="mailto:{{ env('MAIL_FROM_ADDRESS') }}">{{ env('MAIL_FROM_ADDRESS') }}</a>.
          </p>
        </td>
      </tr>
    </table>

    

  </div>
</center>
</body>
</html>
