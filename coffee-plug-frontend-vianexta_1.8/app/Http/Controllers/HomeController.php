<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;

class HomeController extends Controller
{
  public function welcome()
  {
    return view('welcome');
  }

  public function login()
  {
    return view('login');
  }

  public function login_page()
  {
    // Don't clear login sessions when just visiting the login page
    // This was interfering with successful logins by clearing auth sessions
    // $helper = new Helper();
    // $logout = $helper->clearLoginSession();

    // Only clear error/success sessions if they're not fresh (indicating a recent login attempt)
    // This allows legitimate login errors to be displayed
    $errorSession = session('error');
    $successSession = session('success');

    error_log('HomeController::login_page - Initial session check:');
    error_log('HomeController::login_page - Error session: ' . ($errorSession ?? 'null'));
    error_log('HomeController::login_page - Success session: ' . ($successSession ?? 'null'));

    // TEMPORARILY DISABLED: Don't clear any sessions to test if that's the issue
    /*
    // If we have fresh error/success messages, don't clear them
    // They will be cleared after being displayed by the frontend
    if (empty($errorSession) && empty($successSession)) {
      // No fresh messages, safe to clear any old sessions
      session()->forget('error');
      session()->forget('success');
      error_log('HomeController::login_page - No fresh messages, cleared old sessions');
    } else {
      error_log('HomeController::login_page - Fresh messages detected, keeping sessions for display');
      error_log('HomeController::login_page - Error: ' . ($errorSession ?? 'null'));
      error_log('HomeController::login_page - Success: ' . ($successSession ?? 'null'));
    }
    */

    // Always preserve sessions for now
    error_log('HomeController::login_page - TEMPORARILY preserving all sessions for testing');
    error_log('HomeController::login_page - Preserved error: ' . ($errorSession ?? 'null'));
    error_log('HomeController::login_page - Preserved success: ' . ($successSession ?? 'null'));

    // Debug logging
    error_log('HomeController::login_page - Login page loaded');

    return view('login_page');
  }

  public function languages()
  {

    if (request()->hasCookie('language_cookie')) {
      $lang_cookie = request()->cookie('language_cookie');
      return response(view('languages'))->withCookie('');
    }

    return view('languages');
    //  return view('new_web_pages.home.new_home');
  }

  public function account_type()
  {
    return view('account_type');
  }

  public function register_step_1()
  {
    return view('register_step_1');
  }

  public function register_step_2()
  {
    $helper = new Helper();

    $countries = json_decode($helper->getCountries());

    return view('register_step_2', compact('helper', 'countries'));
  }

  public function marketplace_buyer()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product_filter = "";
    $data = $helper->generateProducts()->data;
    // dd($data);
    $menus = $helper->getProductMenus();


    return view('marketplace_buyer', compact('data', 'menus', 'helper', 'product_filter'));
  }


  public function get_product($product_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product_id = $helper->decode($product_id);
    // dd($product_id);
    $products_data = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $product_id);

    if (!isset($products_data->statusCode))
      return  redirect()->route('login_page');

    if ($products_data->statusCode == 200)
      $products_data = $products_data->data;

    return view('new_web_pages.buyer_pages.product_details', compact('helper', 'products_data'));
  }

  public function work_with_us()
  {
    return view('work_with_us');
  }
  public function join_team()
  {
    return view('join_team');
  }
  public function buyer_dashboard()
  {
    return view('buyer_dashboard');
  }
  public function recommend()
  {
    return view('recommend');
  }

  public function process()
  {
    return view('process');
  }

  public function order_history()
  {
    //  return view('order_history');
    return  redirect()->route('buyerOrderHistory');
  }

  public function account_dashboard()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $total_order_details = $helper->hitCoffeePlugGetEndpoint('order-data');
    if (isset($total_order_details->status) && $total_order_details->status == 500) {
      return  redirect()->route('login_page');
    } else {
      $prices = json_decode($this->getCoffeePrice());
      return view('dashboard.account_dashboard', compact('helper', 'prices', 'total_order_details'));
    }
  }

  public function check_passcode(Request $request)
  {
    $this->validate($request, [
      'passcode' => 'required'
    ]);
    // dd('I got here');
    $acct_code = env('WELCOME_PASSWORD');
    $press_code = env('PRESS_PASSWORD');
    // dd($acct_code);
    if ($request->passcode == $acct_code || $request->passcode == $press_code) {
      if (!empty($request->email)) {

        $helper = new Helper();
        $payload = array("email" => $request->email);
        $endPointResults = $helper->hitCoffeePlugEndpoint($payload, "subscribe-newsletter");
        // dd('I got here with ',$endPointResults);
        if ($endPointResults->statusCode == 200) {
          return view('new_web_pages.home.coffee_plug')->with('success', $endPointResults->message);
        } else {
          return view('new_web_pages.home.coffee_plug')->with('error', "Saving subscription failed");
        }
      } else {
        return view('new_web_pages.home.coffee_plug');
      }
    } else {
      return redirect()->back()->with('error', 'Sorry, Wrong Passcode Entered');
    }
  }

  public function sendInviteCode(Request $request)
  {
    $this->validate($request, [
      'email' => 'required'
    ]);
    $helper = new Helper();
    // dd($request->email);
    $pressCode = env('PRESS_PASSWORD');
    $message = "Hello there Kindly use the invitation code:" . $pressCode . " to gain access to ViaNexta site";
    $sendinvite = $helper->sendEmail($request->email, $message);
    return redirect()->back()->with('success', "Invitation code sent to your email successfully");
  }

  public function homePage()
  {
    return view('new_web_pages.home.coffee_plug');
  }


  public function getCoffeePrice()
  {
    $helper = new Helper();
    $prices = $helper->hitCoffeePlugPrice();

    return $prices;
  }

  public function priceDashboard()
  {
    $prices = json_decode($this->getCoffeePrice());

    return view('dashboard.price_dashboard', compact('prices'));
  }

  public function help()
  {
    //   $helper = new Helper();
    // $frogdata = $helper->getFrogData();
    // $frogdata = json_decode($frogdata,true);
    // $frogdata = $frogdata['data']['valid'];
    // $countries = array_keys($frogdata);
    //  dd($frogdata[$countries[0]],$countries);
    return view('help');
  }

  public function chatWithClare()
  {
    return view('chat_with_clare');
  }

  public function saveNewLetter(Request $request)
  {
    $this->validate($request, [
      'email' => 'email'
    ]);
    $helper = new Helper();
    $payload = array("email" => $request->email);
    $endPointResults = $helper->hitCoffeePlugEndpoint($payload, "subscribe-newsletter");
    //  dd($endPointResults);

    if ($endPointResults->statusCode != 200) {
      return redirect()->back()->with('error', $endPointResults->message)->withInput();
    } else {
      return redirect()->back()->with('success', $endPointResults->message);
    }
  }

  public function save_recommend(Request $request)
  {
    $this->validate($request, [
      'email' => 'required|string|email|max:255',
      'first_name' => 'string|required|max:255',
      'phone_number' => 'required|max:30',
      'recommenderEmail' => 'required|string|email|max:255'
    ]);
    $helper = new Helper();
    $payload = array(
      "farmerEmail" => $request->email,
      "farmerName" => $request->first_name,
      "farmerNumber" => $request->phone_number,
      "recommenderEmail" => $request->recommenderEmail,
      "farmerDescription" => $request->description
    );

    $endPointResults = $helper->hitCoffeePlugEndpoint($payload, "recommend-farmer");
    //  dd(json_encode($payload),$endPointResults);

    if (isset($endPointResults->statusCode) && $endPointResults->statusCode == 500) {
      return redirect()->back()->with('error', $endPointResults->message)->withInput();
    } else {
      return redirect()->back()->with('success', 'Successfully sent farmer`s recommendation!');
    }
  }

  //NEW HOMEPAGE
  public function new_home()
  {
    return view('new_web_pages.home.coffee_plug');
  }

  public function new_landing()
  {
    $helper = new Helper();

    // Get cart items count for logged-in users
    $cart_items_count = 0;
    if (session('auth_user_tokin') != null) {
      $cart_items = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
      if (!empty($cart_items) && $cart_items->statusCode == 200 && isset($cart_items->data)) {
        $cart_items_count = count($cart_items->data);
      }
    }

    return view('new_web_pages.home.new_landing_page', compact('cart_items_count'));
  }

  public function get_started()
  {
    $donnot_show_footer = true;
    return view('new_web_pages.home.get_started', compact('donnot_show_footer'));
  }

  public function our_team()
  {
    // $donnot_show_footer = true;
    return view('new_web_pages.home.our_team');
  }

  public function save_profile(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $this->validate($request, [
      'firstName' => 'required',
      'lastName' => 'required',
      'phoneNumber' => 'required'
    ]);
    $helper = new Helper();

    $payload = $request->all();
    if ($request->file('imageUrl') != null) {
      $uploadedFileUrl = cloudinary()->upload($request->file('imageUrl')->getRealPath())->getSecurePath();
      $imageUrl = urlencode($uploadedFileUrl);
      $image_array = array('imageUrl' => $imageUrl);
      $payload = array_merge($payload, $image_array);
    }

    $profile_url = session('auth_user_role') == "Buyer" ? "buyer-profile" : "supplier-profile";

    // dd($request,json_encode($payload));
    $attemptSave = $helper->hitCoffeePlugPOSTEndpoint($payload, $profile_url, "PUT");

    //  dd($attemptSave,$request,json_encode($payload));
    if (!isset($attemptSave->statusCode))
      return  redirect()->route('login_page');

    if ($attemptSave->statusCode != 200) {
      return redirect()->back()->with('error', $attemptSave->message)->withInput();
    } else {
      return redirect()->back()->with('success', 'Profile updated successful');
    }
  }

  public function reset_password(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $this->validate($request, [
      'oldPassword' => 'required',
      'newPassword' => 'required'
    ]);
    $helper = new Helper();

    $payload = array(
      "oldPassword" => $request->oldPassword,
      "newPassword" => $request->newPassword
    );

    $attemptSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "change-password", "PUT");

    if (!isset($attemptSave->statusCode))
      return  redirect()->route('login_page');

    if ($attemptSave->statusCode != 200) {
      return redirect()->back()->with('error', $attemptSave->message)->withInput();
    } else {
      return redirect()->back()->with('success', 'password changed successful');
    }
  }

  public function getWheelData()
  {
    $helper = new Helper();

    return $helper->getWheelData();
  }

  public function checkSubscription(Request $request)
  {
    $email = $request->query('email');
    
    if (!$email) {
      return response()->json([
        'success' => false,
        'message' => 'Email parameter is required'
      ], 400);
    }

    $helper = new Helper();
    $payload = array("email" => $email);
    $endPointResults = $helper->hitCoffeePlugEndpoint($payload, "check-newsletter-subscription");
    
    if (isset($endPointResults->statusCode) && $endPointResults->statusCode == 200) {
      return response()->json([
        'success' => true,
        'subscribed' => true,
        'message' => $endPointResults->message
      ]);
    } else {
      return response()->json([
        'success' => true,
        'subscribed' => false,
        'message' => 'User not subscribed to newsletter'
      ]);
    }
  }
}
