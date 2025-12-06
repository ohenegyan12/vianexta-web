<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Log;

class BuyerController extends Controller
{
  public function buyers_landing()
  {
    $helper = new Helper();
    $products = array();
    $suppliers = array();
    $dummy_images = $this->dummySupplierImages();

    $fetch_suppliers = $helper->hitCoffeePlugGetEndpoint('suppliers');
    if ($fetch_suppliers->statusCode == 200)
      $suppliers = $fetch_suppliers->data;

    //  dd($dummy_images[0]);

    $fetch_products = $helper->generateProducts();
    if ($fetch_products->statusCode == 200)
      $products = $fetch_products->data;
    //  dd($dummy_images);
    $countries = json_decode($helper->getCountries());

    return view('new_web_pages.buyer_pages.buyers_landing', compact('helper', 'products', 'countries', 'suppliers', 'dummy_images'));
  }

  public function buyer_market_place()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product_filter = "";
    $data = array();
    $filter_params = array();
    $stock_params = array();
    $data = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=green');

    $get_stock_params = $helper->hitCoffeePlugGetEndpoint('filter-options-stock-postings');
    // dd($data);
    if (!isset($data->statusCode))
      return  redirect()->route('login_page');

    if ($data->statusCode == 200)
      $data = $data->data;

    $menus = $helper->getProductMenus();
    $cirtifications = $helper->getCirtifications();
    if (!empty($get_stock_params) && $get_stock_params->statusCode == 200)
      $stock_params = $get_stock_params->data;

    //  dd($cirtifications[1]['name']);
    // dd($data);

    return view('new_web_pages.buyer_pages.buyer_market_place', compact('data', 'menus', 'helper', 'product_filter', 'stock_params', 'filter_params', 'cirtifications'));
    // return view('new_web_pages.buyer_pages.buyer_market_place');
  }
  public function buyer_whole_market_place()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product_filter = "";
    $data = array();

    $data = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=whole_sale_brand');

    // dd($data);
    if (!isset($data->statusCode))
      return  redirect()->route('login_page');

    if ($data->statusCode == 200)
      $data = $data->data;

    // $brands = $helper->getBrands();
    $brands = $helper->hitCoffeePlugGetEndpoint('whole_sale_brands');
    if (isset($brands->statusCode) && $brands->statusCode == 200)
      $brands = $brands->data;
    // dd($brands);
    return view('new_web_pages.buyer_pages.buyer_whole_market_place', compact('data', 'helper', 'brands'));
  }
  public function buyer_brand_market_place($brand_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product_filter = "";
    $data = array();
    $brand_id = $helper->decode($brand_id);
    $filter_params = array();
    $stock_params = array();
    $data = $helper->hitCoffeePlugGetEndpoint('stock-postings-by-supplier/' . $brand_id);
    // dd($data);
    if (!isset($data->statusCode))
      return  redirect()->route('login_page');

    if ($data->statusCode == 200)
      $data = $data->data;

    return view('new_web_pages.buyer_pages.buyer_brand_market_place', compact('data', 'helper', 'product_filter'));
  }

  public function product_details()
  {
    return view('new_web_pages.buyer_pages.product_details');
  }

  public function shoping_cart()
  {
    return view('new_web_pages.buyer_pages.shoping_cart');
  }

  public function farmer_profile(Request $request)
  {
    $helper = new Helper();

    $supplier_data = json_decode($helper->decryptData($request->supplier_data));
    //  dd($supplier_data);
    return view('new_web_pages.buyer_pages.farmer_profile', compact('helper', 'supplier_data'));
  }

  public function buyer_order_tracking($order_id)
  {
    if (session('auth_user_tokin') == null) {
      return redirect()->route('login_page');
    }
    $helper = new Helper();
    $order_list = array();
    $order_id = $helper->decode($order_id);
    $order_data = $helper->hitCoffeePlugGetEndpoint('get-order-status?lotOrderId=' . $order_id);
    //  dd($order_data);
    if (!isset($order_data->statusCode))
      return  redirect()->route('login_page');

    if ($order_data->statusCode == 200)
      $order_data = $order_data->data;

    $donnot_show_footer = true;
    return view('new_web_pages.buyer_pages.order_tracking', compact('helper', 'donnot_show_footer', 'order_data'));
  }

  public function buyer_account_page()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();

    $products = array();
    $products = $helper->hitCoffeePlugGetEndpoint('most-popular-stock-postings');
    $countries = json_decode($helper->getCountries());

    if (!isset($products->statusCode))
      return  redirect()->route('login_page');

    if ($products->statusCode == 200)
      $products = $products->data;

    $data = $helper->hitCoffeePlugGetEndpoint('buyer-profile');
    if ($data->statusCode == 200)
      $data = $data->data;

    $donnot_show_footer = true;
    return view('new_web_pages.buyer_pages.buyer_account_page', compact('donnot_show_footer', 'helper', 'data', 'products', 'countries'));
  }

  public function buyer_profile_endpoint()
  {
    if (session('auth_user_tokin') == null) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    $helper = new Helper();
    $data = $helper->hitCoffeePlugGetEndpoint('buyer-profile');

    if ($data->statusCode == 200) {
      return response()->json($data);
    } else {
      return response()->json(['error' => 'Failed to fetch profile'], 500);
    }
  }

  public function buyer_order_history()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $orders = array();
    $total_order_details = $helper->hitCoffeePlugGetEndpoint('order-data');
    // dd($total_order_details);
    if (isset($total_order_details->status) && $total_order_details->status == 500) {
      return  redirect()->route('login_page');
    } else {
      $order_list = $helper->hitCoffeePlugGetEndpoint('order-lists');
      // dd($order_list);

      // Initialize orders as empty array
      $orders = array();

      // Check if order_list is an object with data property
      if ($order_list && is_object($order_list) && isset($order_list->statusCode) && $order_list->statusCode == 200) {
        $orders = $order_list->data;
      } elseif (is_array($order_list)) {
        // Log error if we got an array instead of object
        Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
          'url' => 'order-lists',
          'return_type' => gettype($order_list),
          'return_value' => $order_list
        ]);
      } elseif ($order_list && is_object($order_list) && isset($order_list->error) && $order_list->error) {
        // Handle error objects
        Log::error('hitCoffeePlugGetEndpoint returned error object', [
          'url' => 'order-lists',
          'statusCode' => $order_list->statusCode ?? 'unknown',
          'message' => $order_list->message ?? 'unknown error'
        ]);
      }

      $total_order_details = $total_order_details->data;

      $donnot_show_footer = true;
      return view('new_web_pages.buyer_pages.buyer_order_history', compact('helper', 'donnot_show_footer', 'orders', 'total_order_details'));
    }
  }

  public function buyer_wishlist()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $cart_items = array();
    $cart_items_response = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
    // dd($cart_items);
    // if(!isset($products->statusCode))
    //  return  redirect()->route('login_page');

    // Check if cart_items_response is an object with data property
    if ($cart_items_response && is_object($cart_items_response) && isset($cart_items_response->statusCode) && $cart_items_response->statusCode == 200) {
      $cart_items = $cart_items_response->data;
    } elseif (is_array($cart_items_response)) {
      // Log error if we got an array instead of object
      Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
        'url' => 'all-cart-items',
        'return_type' => gettype($cart_items_response),
        'return_value' => $cart_items_response
      ]);
    }

    $donnot_show_footer = true;
    return view('new_web_pages.buyer_pages.buyer_wishlist', compact('donnot_show_footer', 'cart_items', 'helper'));
  }

  public function buyer_dashboard()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $analytics_data = array();
    $total_order_details = $helper->hitCoffeePlugGetEndpoint('order-data');
    // dd($total_order_details);
    if (isset($total_order_details->status) && $total_order_details->status == 500) {
      return  redirect()->route('login_page');
    } else {

      $prices = json_decode($helper->hitCoffeePlugPrice());
      if ($prices->statusCode != 200)
        $prices = $this->defaultPrice();

      $analytics = $helper->hitCoffeePlugGetEndpoint('buyer-monthly-analytics');
      if ($analytics && is_object($analytics) && isset($analytics->statusCode) && $analytics->statusCode == 200) {
        $analytics_data = $analytics->data;
      } elseif (is_array($analytics)) {
        // Log error if we got an array instead of object
        Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
          'url' => 'buyer-monthly-analytics',
          'return_type' => gettype($analytics),
          'return_value' => $analytics
        ]);
      }

      // dd($total_order_details);


      $total_order_details = $total_order_details->data;
      $prices = $prices->data;
      $donnot_show_footer = true;
      return view('new_web_pages.buyer_pages.buyer_dashboard', compact('helper', 'prices', 'total_order_details', 'donnot_show_footer', 'analytics_data'));
    }
    // $donnot_show_footer = true;
    // return view('new_web_pages.buyer_pages.buyer_dashboard_new',compact('donnot_show_footer'));
  }


  public function defaultPrice()
  {
    return '{"statusCode":500,"message":"Successfully retrieved the coffee price","data":{"arabica":{"dateTime":"","currency":"USD","coffeeType":"Arabica","price":0.0,"unit":"per lb","closingPrice":null},"robusta":{"dateTime":"","currency":"USD","coffeeType":"Robusta","price":0.00,"unit":"per lb","closingPrice":null}}}';
  }

  public function buyer_checkout()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    // dd(config('paypal'));
    $helper = new Helper();
    $cart_items = array();
    $price_breakdown = array();
    $profile_data = array();

    $cart_items_response = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
    $fetch_price_breakdown_response = $helper->hitCoffeePlugGetEndpoint("get-cart-price-breakdown");

    // Fetch buyer profile data for prepopulating billing form
    $profile_response = $helper->hitCoffeePlugGetEndpoint('buyer-profile');
    if ($profile_response && is_object($profile_response) && isset($profile_response->statusCode) && $profile_response->statusCode == 200) {
      $profile_data = $profile_response->data;
    } elseif (is_array($profile_response)) {
      Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
        'url' => 'buyer-profile',
        'return_type' => gettype($profile_response),
        'return_value' => $profile_response
      ]);
    }

    if ($cart_items_response && is_object($cart_items_response) && isset($cart_items_response->statusCode) && $cart_items_response->statusCode == 200) {
      $cart_items = $cart_items_response->data;
    } elseif (is_array($cart_items_response)) {
      Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
        'url' => 'all-cart-items',
        'return_type' => gettype($cart_items_response),
        'return_value' => $cart_items_response
      ]);
    }

    if ($fetch_price_breakdown_response && is_object($fetch_price_breakdown_response) && isset($fetch_price_breakdown_response->statusCode) && $fetch_price_breakdown_response->statusCode == 200) {
      $price_breakdown = $fetch_price_breakdown_response->data;
    } elseif (is_array($fetch_price_breakdown_response)) {
      Log::warning('hitCoffeePlugGetEndpoint returned array instead of object', [
        'url' => 'get-cart-price-breakdown',
        'return_type' => gettype($fetch_price_breakdown_response),
        'return_value' => $fetch_price_breakdown_response
      ]);
    }

    // Check if cart_items is empty or null and redirect if so
    if (empty($cart_items) || !is_array($cart_items) || count($cart_items) < 1) {
      $helper->resetCart();
      return redirect()->route('buyer_market_place')->with('error', 'Your cart is empty. Please add items before checkout.');
    }

    $donnot_show_footer = true;
    // dd($cart_items);
    return view('new_web_pages.buyer_pages.buyer_checkout', compact('donnot_show_footer', 'cart_items', 'helper', 'price_breakdown', 'profile_data'));
  }


  public function buyer_order_details($order_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $transactions = array();
    $order_id = $helper->decode($order_id);

    // $payload = array('totalOrderId'=>$order_id);
    $order_data = $helper->hitCoffeePlugGetEndpoint('get-lot-order-from-total?totalOrderId=' . $order_id);
    // $order_data=$helper->hitCoffeePlugEndpoint($payload,"get-lot-order-from-total");
    //  dd($order_data);
    if (!isset($order_data->statusCode))
      return redirect()->route('login_page');

    if ($order_data->statusCode == 200)
      $transactions = $order_data->data;
    $purchase_title = "Order #" . $order_id;

    $donnot_show_footer = true;
    return view('new_web_pages.buyer_pages.buyer_order_details', compact('helper', 'donnot_show_footer', 'transactions', 'purchase_title'));
  }


  public function buyer_wizard_success($quantity, $stockpostingid)
  {
    $helper = new Helper();

    // Save quantity to session if not already set
    if (!session('num_of_bags')) {
      session(['num_of_bags' => $quantity]);
    }

    // Set default bag image if not already set
    if (!session('bag_image')) {
      session(['bag_image' => asset('images/buyer/winwin.png')]);
    }

    $donnot_show_footer = true;
    $default_winwin_logo = asset('images/buyer/winwin.png');

    if (session('roast') != NULL && session('roast') == "yes") {
      $payload = array(
        "stockPostingId" =>  (int) session('product'),
        "numBags" =>  (int) session('num_of_bags'),
        "isRoast" => true,
        "roastType" => session('roast_type'),
        "grindType" => session('grind_type'),
        "bagSize" => session('bag_size'),
        "bagImage" => session('bag_image') != null ? session('bag_image') : ''
      );

      // Log the payload for debugging
      // dd(json_encode($payload));
      // $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "cart-item", "PUT");
      $attemptItemSave = $helper->hitCoffeePlugEndpoint($payload, "cart-item");

      if (!isset($attemptItemSave->statusCode))
        return  redirect()->route('login_page');
      // dd($attemptItemSave);
      if (!isset($attemptItemSave->statusCode) && $attemptItemSave->statusCode != 200) {
        return redirect()->back()->with('error', 'Adding Item to cart failed')->withInput();
      } else {

        // $donnot_show_footer = true;
        // return view('new_web_pages.buyer_pages.buyer_wizard_success', compact('helper', 'donnot_show_footer'));
        return redirect()->route('buyer_cart');
      }
    } else {
      // dd('no roast');
      return redirect()->route('buyer_cart');
    }
  }

  public function buyer_order_option_set($option, $value)
  {
    session([$option => $value]);
    echo "session created for " . $option . " with value: " . $value;
  }

  public function dummySupplierImages()
  {

    $imgs = array(
      "asset('images/seller/farms/1.png')",
      "asset('images/seller/farms/2.png')",
      "asset('images/seller/farms/3.png')",
      'https://cdn.discordapp.com/attachments/1072084741358092379/1240268119927164928/justcoby_coffee_farm_photography_48533e3f-a923-4e6f-a685-a9e5e89f72c7.png?ex=6645f132&is=66449fb2&hm=62809796f138c7ac2986f929a16e007b224ec0f7381fcacc3a4aad5a8ffe54e8&',
      'https://cdn.discordapp.com/attachments/1072084741358092379/1240268376908107826/justcoby_coffee_farm_photography_a65a3a37-b665-4bcb-9885-4e7249b751fe.png?ex=6645f170&is=66449ff0&hm=2028ff3fbcba74db6f6f20d6085f20599b9434c9ceec4890c3a1d79c99a25cf6&',
      'https://cdn.discordapp.com/attachments/1072084741358092379/1240268410756136960/justcoby_coffee_farm_photography_7b4f7fbf-1169-4272-9c24-8ee7b4ca07d7.png?ex=6645f178&is=66449ff8&hm=c414b8620c1adac5b2d611b5a8b1fffe45fc6af7973daa10d318279ad2a8dee7&',
      'https://cdn.discordapp.com/attachments/1072084741358092379/1240268909765066762/justcoby_coffee_farm_photography_30733e9e-48d8-439a-8567-fad80941ac1d.png?ex=6645f1ef&is=6644a06f&hm=543cef6ae6910da41155bb8f61e1b27a4e0471e37a33d46b457aa09c2c141fca&'
    );

    return $imgs;
  }


  // public function buyer_upload_bag_logo(Request $request)
  // {
  //   $imageUrl = asset('images/buyer/winwin.png');
  //   // dd($request->file());
  //   if ($request->file('bag_image') != null) {
  //     $uploadedFileUrl = cloudinary()->upload($request->file('bag_image')->getRealPath())->getSecurePath();
  //     $imageUrl = urlencode($uploadedFileUrl);
  //     session(['bag_image' => $imageUrl]);
  //   }

  //   $helper = new Helper();

  //   $stockPostingId = $helper->decode($request->stockPostingId);

  //   $num_of_bags = $helper->decode($request->num_of_bags);

  //   $donnot_show_footer = true;


  //   if (session('roast') != NULL && session('roast') == "yes") {
  //     $payload = array(
  //       "stockPostingId" => $stockPostingId,
  //       "numBags" => $num_of_bags,
  //       "isRoast" => true,
  //       "roastType" => session('roast_type'),
  //       "grindType" => session('grind_type'),
  //       "bagSize" => session('bag_size'),
  //       "bagImage" => $imageUrl
  //     );
  //     // dd($payload);
  //     $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "cart-item", "PUT");

  //     if (!isset($attemptItemSave->statusCode))
  //       return  redirect()->route('login_page');
  //     // dd($attemptItemSave);
  //     if (!isset($attemptItemSave->statusCode) && $attemptItemSave->statusCode != 200) {
  //       return redirect()->back()->with('error', 'Adding Item to cart failed')->withInput();
  //     } else {

  //       $donnot_show_footer = true;
  //       return view('new_web_pages.buyer_pages.buyer_wizard_success', compact('helper', 'donnot_show_footer'));
  //     }
  //   } else {
  //     return route('buyer_cart');
  //   }
  // }
  public function buyer_upload_bag_logo(Request $request)
  {
    $imageUrl = asset('images/buyer/winwin.png');

    if ($request->file('file') != null) {
      $uploadedFileUrl = cloudinary()->upload($request->file('file')->getRealPath())->getSecurePath();
      $imageUrl = urlencode($uploadedFileUrl);
      session(['bag_image' => $imageUrl]);
    }

    $helper = new Helper();

    // $stockPostingId = $helper->decode($request->stockPostingId);

    // $num_of_bags = $helper->decode($request->num_of_bags);

    $payload = array(
      "stockPostingId" => session('product'),
      "numBags" => session('num_of_bags'),
      "isRoast" => true,
      "roastType" => session('roast_type'),
      "grindType" => session('grind_type'),
      "bagSize" => session('bag_size'),
      "bagImage" => $imageUrl
    );
    // dd($payload);
    // $attemptItemSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "cart-item", "PUT");

    // if (!isset($attemptItemSave->statusCode))
    //   return response()->json(['error' => 'return to login']);
    // // dd($attemptItemSave);
    // if (!isset($attemptItemSave->statusCode) && $attemptItemSave->statusCode != 200) {
    //   return response()->json(['error' => 'Adding Item to cart failed']);
    // } else {
    //   return response()->json(['success' => 'Uplaod success']);
    // }

    return response()->json(['success' => 'Uplaod success']);
  }

  public function get_bag_image_url()
  {
    $bagImage = session('bag_image', '');
    return response()->json(['bagImage' => $bagImage]);
  }

  public function buyer_logo_success_upload()
  {
    $helper = new Helper();
    $donnot_show_footer = true;
    return view('new_web_pages.buyer_pages.buyer_wizard_success', compact('helper', 'donnot_show_footer'));
  }

  public function buyer_new_wizard()
  {
    error_log('BuyerController::buyer_new_wizard - Method called');
    error_log('BuyerController::buyer_new_wizard - auth_user_tokin: ' . (session('auth_user_tokin') ?? 'null'));
    error_log('BuyerController::buyer_new_wizard - auth_user_role: ' . (session('auth_user_role') ?? 'null'));
    error_log('BuyerController::buyer_new_wizard - auth_user_id: ' . (session('auth_user_id') ?? 'null'));

    if (session('auth_user_tokin') == null) {
      error_log('BuyerController::buyer_new_wizard - No auth token, redirecting to login');
      return  redirect()->route('login_page');
    }

    error_log('BuyerController::buyer_new_wizard - Authentication successful, proceeding with method');

    $helper = new Helper();
    $donnot_show_footer = true;
    $product_filter = "";
    $data = array();
    $filter_params = array();
    $stock_params = array();
    $winwin_products = array();
    // $data = $helper->generateProducts();

    $get_stock_params = $helper->hitCoffeePlugGetEndpoint('filter-options-stock-postings');

    $cirtifications = $helper->getCirtifications();
    if (!empty($get_stock_params) && $get_stock_params->statusCode == 200)
      $stock_params = $get_stock_params->data;

    $fetch_products = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=roasted_single_origin');
    $winwin_products = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=roasted_blend');

    if (!isset($fetch_products->statusCode))
      return  redirect()->route('login_page');

    if ($fetch_products->statusCode == 200)
      $products = $fetch_products->data;

    if ($winwin_products->statusCode == 200)
      $winwin_products = $winwin_products->data;


    $num_of_bags = 1;
    $stockPostingId = 1;

    // dd($products);

    return view('new_web_pages.buyer_pages.buyer_order_wizard', compact('helper', 'donnot_show_footer', 'products', 'num_of_bags', 'stockPostingId', 'cirtifications', 'stock_params', 'winwin_products'));
  }

  public function new_buyer_wizard()
  {

    if (session('auth_user_tokin') == null) {
      return redirect()->route('login_page');
    }

    $helper = new Helper();
    $donnot_show_footer = true;
    $product_filter = "";
    $data = array();
    $filter_params = array();
    $stock_params = array();
    $winwin_products = array();

    // Get filter options
    $get_stock_params = $helper->hitCoffeePlugGetEndpoint('filter-options-stock-postings');
    $cirtifications = $helper->getCirtifications();

    if (!empty($get_stock_params) && $get_stock_params->statusCode == 200) {
      $stock_params = $get_stock_params->data;
    }

    // Get different product types for the wizard
    $roasted_single_origin = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=roasted_single_origin');
    $roasted_blend = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=roasted_blend');
    $green_beans = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=green');
    $wholesale_brands = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=whole_sale_brand');

    // Initialize products arrays
    $products = [];
    $winwin_products = [];
    $green_products = [];
    $wholesale_products = [];

    // dd($roasted_single_origin);
    // if (!isset($roasted_single_origin->statusCode)) {
    //   return redirect()->route('login_page');
    // }

    if (isset($roasted_single_origin->statusCode) && $roasted_single_origin->statusCode == 200) {
      $products = $roasted_single_origin->data;
    }

    if (isset($roasted_blend->statusCode) && $roasted_blend->statusCode == 200) {
      $winwin_products = $roasted_blend->data;
    }

    if (isset($green_beans->statusCode) && $green_beans->statusCode == 200) {
      $green_products = $green_beans->data;
    }

    if (isset($wholesale_brands->statusCode) && $wholesale_brands->statusCode == 200) {
      $wholesale_products = $wholesale_brands->data;
    }

    $num_of_bags = 1;
    $stockPostingId = 1;

    // Get cart items count
    $cart_items = $helper->hitCoffeePlugGetEndpoint("all-cart-items");
    $cart_items_count = 0;

    if (!empty($cart_items) && $cart_items->statusCode == 200 && isset($cart_items->data)) {
      $cart_items_count = count($cart_items->data);
    }



    // dd($wholesale_products);

    return view('new_web_pages.buyer_pages.wizard.new_buyer_wizard', compact(
      'helper',
      'donnot_show_footer',
      'products',
      'winwin_products',
      'green_products',
      'wholesale_products',
      'num_of_bags',
      'stockPostingId',
      'cirtifications',
      'stock_params',
      'cart_items_count'
    ));
  }

  public function get_wizard_products(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    $helper = new Helper();
    $productType = $request->input('productType', 'roasted_single_origin');
    $page = $request->input('page', 1);
    $perPage = 12;

    // Debug logging
    Log::info('get_wizard_products called', [
      'productType' => $productType,
      'page' => $page,
      'request_data' => $request->all()
    ]);

    // Get products based on type
    $response = $helper->hitCoffeePlugGetEndpoint('stock-postings?productType=' . $productType);

    Log::info('API response received', [
      'statusCode' => $response->statusCode ?? 'null',
      'hasData' => isset($response->data),
      'dataCount' => isset($response->data) ? count($response->data) : 0
    ]);

    if (!isset($response->statusCode) || $response->statusCode != 200) {
      Log::error('API request failed', [
        'statusCode' => $response->statusCode ?? 'null',
        'response' => $response
      ]);
      return response()->json(['error' => 'Failed to fetch products'], 500);
    }

    $allProducts = $response->data;

    // Manual pagination
    $total = count($allProducts);
    $offset = ($page - 1) * $perPage;
    $products = array_slice($allProducts, $offset, $perPage);

    $hasMore = ($offset + $perPage) < $total;

    $result = [
      'products' => $products,
      'hasMore' => $hasMore,
      'currentPage' => $page,
      'totalPages' => ceil($total / $perPage),
      'total' => $total
    ];

    Log::info('Returning paginated results', [
      'total' => $total,
      'currentPage' => $page,
      'totalPages' => ceil($total / $perPage),
      'productsCount' => count($products)
    ]);

    return response()->json($result);
  }

  public function test_wizard_endpoint(Request $request)
  {
    return response()->json([
      'message' => 'Test endpoint working',
      'request_data' => $request->all(),
      'timestamp' => now()
    ]);
  }

  public function save_wholesale_selections(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    $bagSize = $request->input('bagSize');
    $quantity = $request->input('quantity');
    $amount = $request->input('amount');

    // Store in session
    session([
      'wholesale_bag_size' => $bagSize,
      'wholesale_quantity' => $quantity,
      'wholesale_amount' => $amount
    ]);

    Log::info('Wholesale selections saved', [
      'bagSize' => $bagSize,
      'quantity' => $quantity,
      'amount' => $amount
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Wholesale selections saved successfully'
    ]);
  }

  public function save_selected_wholesale_product(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }

    $productId = $request->input('productId');
    $productName = $request->input('productName');
    $bagPrice = $request->input('bagPrice');
    $quantityLeft = $request->input('quantityLeft');
    $variety = $request->input('variety');
    $coffeeType = $request->input('coffeeType');
    $process = $request->input('process');
    $quality = $request->input('quality');
    $aroma = $request->input('aroma');

    // Store in session
    session([
      'selected_wholesale_product_id' => $productId,
      'selected_wholesale_product_name' => $productName,
      'selected_wholesale_bag_price' => $bagPrice,
      'selected_wholesale_quantity_left' => $quantityLeft,
      'selected_wholesale_variety' => $variety,
      'selected_wholesale_coffee_type' => $coffeeType,
      'selected_wholesale_process' => $process,
      'selected_wholesale_quality' => $quality,
      'selected_wholesale_aroma' => $aroma
    ]);

    Log::info('Selected wholesale product saved', [
      'productId' => $productId,
      'productName' => $productName,
      'bagPrice' => $bagPrice,
      'quantityLeft' => $quantityLeft,
      'variety' => $variety,
      'coffeeType' => $coffeeType,
      'process' => $process,
      'quality' => $quality,
      'aroma' => $aroma
    ]);

    return response()->json([
      'success' => true,
      'message' => 'Selected wholesale product saved successfully'
    ]);
  }

  public function proxyImage(Request $request)
  {
    $imageUrl = $request->input('url');

    if (!$imageUrl) {
      return response()->json(['error' => 'Image URL is required'], 400);
    }

    try {
      // Validate URL
      if (!filter_var($imageUrl, FILTER_VALIDATE_URL)) {
        return response()->json(['error' => 'Invalid URL'], 400);
      }

      // Get image content
      $imageContent = file_get_contents($imageUrl);

      if ($imageContent === false) {
        return response()->json(['error' => 'Failed to fetch image'], 500);
      }

      // Get image info
      $imageInfo = getimagesizefromstring($imageContent);
      $mimeType = $imageInfo['mime'] ?? 'image/jpeg';

      // Return image with proper headers
      return response($imageContent, 200)
        ->header('Content-Type', $mimeType)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Cache-Control', 'public, max-age=86400'); // Cache for 24 hours

    } catch (\Exception $e) {
      Log::error('Image proxy error: ' . $e->getMessage());
      return response()->json(['error' => 'Failed to proxy image'], 500);
    }
  }
}
