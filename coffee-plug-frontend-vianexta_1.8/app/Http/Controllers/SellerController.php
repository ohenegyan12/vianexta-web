<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class SellerController extends Controller
{
  public function sellers_product_preview()
  {
    return view('new_web_pages.seller_pages.sellers_product_preview');
  }

  public function sellers_add_product()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();

    return view('new_web_pages.seller_pages.seller_add_product', compact('helper'));
  }

  public function sellers_landing()
  {
    $helper = new Helper();
    // $products = array();
    // $products = $helper->generateProducts();
    // if($products->statusCode==200)
    //   $products = $products->data;

    $countries = json_decode($helper->getCountries());
    return view('new_web_pages.seller_pages.seller_landing', compact('helper', 'countries'));
  }

  public function sellers_dashboard_home()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $dashboard_data = array();
    $supplier_orders = array();
    $analytics_data = array();
    //     $total_order_details = $helper->hitCoffeePlugGetEndpoint('order-data');

    //     if(isset($total_order_details->status) && $total_order_details->status ==500){
    //       return  redirect()->route('login_page');
    //     }else{
    $prices = json_decode($helper->hitCoffeePlugPrice());
    if ($prices->statusCode != 200)
      $prices = $this->defaultPrice();

    $dashboard_orders = $helper->hitCoffeePlugGetEndpoint('supplier-order-data');
    if (!isset($dashboard_orders->statusCode))
      return  redirect()->route('login_page');

    if ($dashboard_orders->statusCode == 200)
      $dashboard_data = $dashboard_orders->data;

    $getorders = $helper->hitCoffeePlugGetEndpoint('supplier-total-orders');
    // dd($getorders);
    if (isset($getorders->statusCode) && $getorders->statusCode == 200)
      $supplier_orders = $getorders->data;

    $analytics = $helper->hitCoffeePlugGetEndpoint('buyer-monthly-analytics');
    if (isset($analytics->statusCode) && $analytics->statusCode == 200)
      $analytics_data = $analytics->data;

    // dd($analytics_data);

    $prices = $prices->data;
    return view('new_web_pages.seller_pages.seller_dashboard_home', compact('helper', 'prices', 'dashboard_data', 'supplier_orders', 'analytics_data'));
    //     }
    // return view('new_web_pages.seller_pages.seller_dashboard_home');
  }

  public function sellers_product_page()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $products = array();

    $prices = json_decode($helper->hitCoffeePlugPrice());
    if ($prices->statusCode != 200)
      $prices = $this->defaultPrice();
    else
      $prices = $prices->data;

    $supplier_id = session('auth_user_id');
    $products = $helper->hitCoffeePlugGetEndpoint('stock-postings-by-supplier/' . $supplier_id);
    // dd($products);
    if (isset($products->statusCode) && $products->statusCode == 200)
      $products = $products->data;

    return view('new_web_pages.seller_pages.seller_product_page', compact('products', 'helper', 'prices'));
  }

  public function sellers_order_details($order_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $order_details = array();
    $order_id = $helper->decode($order_id);
    $order_details = $helper->hitCoffeePlugGetEndpoint('total-order-details?totalOrderId=' . $order_id);
    //  dd($order_data);
    if (!isset($order_details->statusCode))
      return  redirect()->route('login_page');

    if ($order_details->statusCode == 200)
      $order_details = $order_details->data;

    $roasters = $helper->hitCoffeePlugGetEndpoint('roasters');
    // dd($products);
    if (isset($roasters->statusCode) && $roasters->statusCode == 200)
      $roasters = $roasters->data;

    // dd($order_details);
    $donnot_show_footer = true;
    return view('new_web_pages.seller_pages.seller_order_details', compact('helper', 'order_id', 'order_details', 'roasters'));
  }

  public function sellers_save_product(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }

    $this->validate($request, [
      'isSpecialty' => 'required|in:Commercial,Specialty',
      'coffeeType' => 'required|in:Arabica,Robusta',
      'variety' => 'required|string|max:255',
      'process' => 'required|string|max:255',
      'aroma' => 'required|string|max:255',
      'quantityPosted' => 'required|integer|min:1',
      'bagWeight' => 'required|numeric|min:0.1',
      'bagPrice' => 'required|numeric|min:0.01',
      'description' => 'required|string|min:10',
      'productType' => 'required|in:green,roasted_single_origin,roasted_blend,whole_sale_brand',
      'imageUrl' => 'nullable'
    ]);

    $helper = new Helper();
    $quality = "0";
    $specialty = $request->isSpecialty == "Commercial" ? "false" : "true";

    if (!empty($request->quality))
      $quality = $request->quality;


    // Handle image upload
    $imageUrl = null;
    if ($request->hasFile('imageUrl')) {
      $uploadedFileUrl = cloudinary()->upload($request->file('imageUrl')->getRealPath())->getSecurePath();
      $imageUrl = $uploadedFileUrl;
    } elseif ($request->imageUrl && str_starts_with($request->imageUrl, 'data:image')) {
      // Handle base64 image data from dropzone
      $uploadedFileUrl = cloudinary()->upload($request->imageUrl)->getSecurePath();
      $imageUrl = $uploadedFileUrl;
    }

    // Structure SCA score components as nested object
    $scaScoreComponents = array(
      "fragrance" => (int) $request->fragrance,
      "flavor" => (int) $request->flavor,
      "aftertaste" => (int) $request->aftertaste,
      "acidity" => (int) $request->acidity,
      "body" => (int) $request->body,
      "balance" => (int) $request->balance,
      "sweetness" => (int) $request->sweetness,
      "cleanCup" => (int) $request->clean_cup,
      "uniformity" => (int) $request->uniformity
    );

    $payload = array(
      "description" => $request->description,
      "imageUrl" => $imageUrl,
      "quantityPosted" => (int) $request->quantityPosted,
      "bagWeight" => (float) $request->bagWeight,
      "bagPrice" => (float) $request->bagPrice,
      "variety" => $request->variety,
      "coffeeType" => $request->coffeeType,
      "process" => $request->process,
      "quality" => $quality,
      "aroma" => $request->aroma,
      "isSpecialty" => $specialty === "true",
      "producedBy" => session('auth_user_id'),
      "productType" => $request->productType,
      "scaScoreComponents" => $scaScoreComponents
    );

    // dd($request,json_encode($payload));
    if ($request->save_type == "edit") {
      $payload = array_merge($payload, ['id' => $request->stock_id]);
      $attemptSave = $helper->hitCoffeePlugPOSTEndpoint($payload, "stock-posting", "PUT");
    } else {
      $attemptSave = $helper->hitCoffeePlugEndpoint($payload, "stock-posting");
    }

    //  dd($attemptSave,$request,json_encode($payload));
    if (!isset($attemptSave->statusCode))
      return  redirect()->route('login_page');

    if ($attemptSave->statusCode != 200) {
      return redirect()->back()->with('error', $attemptSave->message)->withInput();
    } else {
      return redirect()->route('sellersProductPage')->with('success', 'product saved successful');
    }
  }

  public function defaultPrice()
  {
    return '{"statusCode":500,"message":"Successfully retrieved the coffee price","data":{"arabica":{"dateTime":"","currency":"USD","coffeeType":"Arabica","price":0.0,"unit":"per lb","closingPrice":null},"robusta":{"dateTime":"","currency":"USD","coffeeType":"Robusta","price":0.00,"unit":"per lb","closingPrice":null}}}';
  }

  public function sellers_account_page()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();

    $data = $helper->hitCoffeePlugGetEndpoint('supplier-profile');
    $countries = json_decode($helper->getCountries());

    if (!isset($data->statusCode))
      return  redirect()->route('login_page');
    if ($data->statusCode == 200)
      $data = $data->data;

    // dd($data);
    $donnot_show_footer = true;
    return view('new_web_pages.seller_pages.seller_account_page', compact('donnot_show_footer', 'helper', 'data', 'countries'));
  }

  public function delete_product($product_id)
  {
    $helper = new Helper();

    $stock_posting_id = $helper->decode($product_id);
    $attemptItemSave = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $stock_posting_id, 'DELETE');
    // dd($attemptItemSave);
    if ($attemptItemSave != true) {
      return redirect()->back()->with('error', 'Deleting product failed')->withInput();
    } else {
      return redirect()->route('sellersProductPage')->with('success', 'Product deleted successfully');
    }
  }

  public function deactivate_product($product_id)
  {
    $helper = new Helper();

    $stock_posting_id = $helper->decode($product_id);
    $attemptItemSave = $helper->hitCoffeePlugGetEndpoint('deactivate-stock-posting/' . $stock_posting_id, 'PUT');
    // dd($attemptItemSave);
    if ($attemptItemSave != true) {
      return redirect()->back()->with('error', 'Deactivating product failed')->withInput();
    } else {
      return redirect()->route('sellersProductPage')->with('success', 'Product deactivated successfully');
    }
  }

  public function reactivate_product($product_id)
  {
    $helper = new Helper();

    $stock_posting_id = $helper->decode($product_id);
    $attemptItemSave = $helper->hitCoffeePlugGetEndpoint('reactivate-stock-posting' . $stock_posting_id, 'PUT');
    // dd($attemptItemSave);
    if ($attemptItemSave != true) {
      return redirect()->back()->with('error', 'Reactivating product failed')->withInput();
    } else {
      return redirect()->route('sellersProductPage')->with('success', 'Product reactivated successfully');
    }
  }

  public function sellers_edit_product($product_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product = array();
    $product_id = $helper->decode($product_id);
    // dd($product_id);
    $products_data = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $product_id);

    if (!isset($products_data->statusCode))
      return  redirect()->route('login_page');

    if ($products_data->statusCode == 200)
      $product = $products_data->data;

    return view('new_web_pages.seller_pages.edit_product', compact('helper', 'product'));
  }

  public function sellers_view_product($product_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $product = array();
    $product_id = $helper->decode($product_id);
    // dd($product_id);
    $products_data = $helper->hitCoffeePlugGetEndpoint('stock-posting/' . $product_id);

    if (!isset($products_data->statusCode))
      return  redirect()->route('login_page');

    if ($products_data->statusCode == 200)
      $product = $products_data->data;

    return view('new_web_pages.seller_pages.view_product', compact('helper', 'product'));
  }


  public function roasters_list_page()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $roasters = array();


    $supplier_id = session('auth_user_id');
    $roasters = $helper->hitCoffeePlugGetEndpoint('roasters');
    // dd($roasters);
    if (isset($roasters->statusCode) && $roasters->statusCode == 200)
      $roasters = $roasters->data;
    // $roasters = array(array('id'=>1,'name'=>'Henry Roaster','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //                   array('id'=>2,'name'=>'Elixr Coffee Roasters','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //                 array('id'=>3,'name'=>'La Colombe Coffee Roasters','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //               array('id'=>4,'name'=>'Vibrant Coffee Roasters & Bakery','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active')); 
    // dd($roasters);
    return view('new_web_pages.admin_pages.roaster_list', compact('helper', 'roasters'));
  }

  public function caffees_list_page()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $profiles = array();


    $supplier_id = session('auth_user_id');
    $profiles = $helper->hitCoffeePlugGetEndpoint('cafes');
    // dd($products);
    if (isset($profiles->statusCode) && $profiles->statusCode == 200)
      $profiles = $profiles->data;
    //  dd($profiles);
    // $profiles = array(array('id'=>1,'name'=>'Lombard Cafe','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //                   array('id'=>2,'name'=>'KFar Cafe Philadelphi','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //                 array('id'=>3,'name'=>'Café Tolia','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active'),
    //               array('id'=>3,'name'=>'Cafe Ole','phone'=>'233544508686','email'=>'henryiller@gmail.com','status'=>'Active')); 

    return view('new_web_pages.admin_pages.caffees_list', compact('helper', 'profiles'));
  }

  public function retailers_list_page()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $profiles = array();


    $supplier_id = session('auth_user_id');

    $profiles = array(
      array('id' => 1, 'name' => 'Lombard Cafe', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 2, 'name' => 'K`Far Cafe Philadelphi', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 3, 'name' => 'Café Tolia', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 3, 'name' => 'Cafe Ole', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active')
    );

    return view('new_web_pages.admin_pages.retailers_list', compact('helper', 'profiles'));
  }

  public function producers_list_page()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $profiles = array();


    $supplier_id = session('auth_user_id');

    $profiles = array(
      array('id' => 1, 'name' => 'Lombard Cafe', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 2, 'name' => 'K`Far Cafe Philadelphi', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 3, 'name' => 'Café Tolia', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active'),
      array('id' => 3, 'name' => 'Cafe Ole', 'phone' => '233544508686', 'email' => 'henryiller@gmail.com', 'status' => 'Active')
    );

    return view('new_web_pages.admin_pages.producers_list', compact('helper', 'profiles'));
  }

  public function coffee_suppliers_list_page()
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }

    $helper = new Helper();

    // For the page view, we don't need to fetch data here since it will be loaded via AJAX
    // The DataTable will handle the data fetching through the API endpoint

    return view('new_web_pages.admin_pages.coffee_suppliers_list', compact('helper'));
  }

  public function roast_orders()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $supplier_orders = array();
    $roasters = array();

    $supplier_id = session('auth_user_id');
    $getorders = $helper->hitCoffeePlugGetEndpoint('supplier-total-orders');
    // dd($getorders);
    if (isset($getorders->statusCode) && $getorders->statusCode == 200)
      $supplier_orders = $getorders->data;

    return view('new_web_pages.admin_pages.roast_orders', compact('helper', 'supplier_orders'));
  }

  public function asigned_roast_orders()
  {

    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $data = array();

    $supplier_id = session('auth_user_id');
    $getorders = $helper->hitCoffeePlugGetEndpoint('supplier-total-orders');
    // dd($getorders);
    if (isset($getorders->statusCode) && $getorders->statusCode == 200)
      $supplier_orders = $getorders->data;

    $roasters = json_decode($helper->getRoasters());


    return view('new_web_pages.admin_pages.asigned_orders', compact('helper', 'supplier_orders', 'roasters', 'data'));
  }

  public function roaster_pending_orders($roaster_id)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }
    $helper = new Helper();
    $supplier_orders = array();

    $supplier_id = session('auth_user_id');
    $getorders = $helper->hitCoffeePlugGetEndpoint('supplier-total-orders');

    if (isset($getorders->statusCode) && $getorders->statusCode == 200)
      $supplier_orders = $getorders->data;

    $roasters = json_decode($helper->getRoasters());

    return view('new_web_pages.admin_pages.asigned_orders', compact('helper', 'supplier_orders', 'roasters'));
  }

  public function asign_order_to_roaster(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return  redirect()->route('login_page');
    }

    $this->validate($request, [
      'roaster_id' => 'required'
    ]);

    $helper = new Helper();

    $payload = array(
      "lotOrderId" => (int)$request->order_id,
      "supplierId" => (int)$request->roaster_id
    );

    // dd($request,json_encode($payload));

    $attemptSave = $helper->hitCoffeePlugEndpoint($payload, "assign-roast-order");

    //  dd($attemptSave,$request,json_encode($payload));
    if (!isset($attemptSave->statusCode))
      return  redirect()->route('login_page');

    if ($attemptSave->statusCode != 200) {
      return redirect()->back()->with('error', $attemptSave->message)->withInput();
    } else {
      return redirect()->route('roasterOrdersListPage')->with('success', $attemptSave->message);
    }
  }

  public function delivery_quotes(Request $request)
  {
    if (session('auth_user_tokin') == null) {
      return redirect()->route('login_page');
    }

    $helper = new Helper();
    $orderId = $request->get('orderId');
    $weight = $request->get('weight');
    $length = $request->get('length');
    $height = $request->get('height');
    $insuranceAmount = $request->get('insuranceAmount');
    $quotes = [];
    $sender = null;
    $receiver = null;
    $error = null;

    if ($orderId && $weight && $length && $height && $insuranceAmount) {
      // Prepare payload for delivery quotes API
      $payload = [
        "orderId" => (int)$orderId,
        "totalWeight" => (float)$weight,
        "length" => (float)$length,
        "height" => (float)$height,
        "insuranceAmount" => (float)$insuranceAmount
      ];

      // Make API call to get delivery quotes
      $response = $helper->hitCoffeePlugEndpoint($payload, 'delivery-quotes');

      if (isset($response->statusCode) && $response->statusCode == 200) {
        $quotes = $response->data->quotes ?? [];
        $sender = $response->data->sender ?? null;
        $receiver = $response->data->receiver ?? null;
        
        // Sort quotes by totalAmount (best value/lowest price first)
        usort($quotes, function($a, $b) {
          $priceA = floatval($a->totalAmount);
          $priceB = floatval($b->totalAmount);
          return $priceA <=> $priceB;
        });
        
        // Debug: Log the response structure
        \Log::info('Delivery Quotes API Response', [
          'quotes_count' => count($quotes),
          'sender' => $sender,
          'receiver' => $receiver,
          'response_structure' => json_encode($response)
        ]);
      } else {
        $error = $response->message ?? 'Failed to get delivery quotes';
        \Log::error('Delivery Quotes API Error', [
          'response' => $response,
          'payload' => $payload
        ]);
      }
    }

    return view('new_web_pages.admin_pages.delivery_quotes', compact('helper', 'quotes', 'orderId', 'weight', 'length', 'height', 'insuranceAmount', 'sender', 'receiver', 'error'));
  }
}
