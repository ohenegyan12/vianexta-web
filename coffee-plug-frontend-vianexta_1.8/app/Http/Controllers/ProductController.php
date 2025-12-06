<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class ProductController extends Controller
{

   public function filter_product(Request $request)
   {
      if (session('auth_user_tokin') == null) {
         return  redirect()->route('login_page');
      }
      $helper = new Helper();
      $this->validate($request, [
         'product_filter' => 'required'
      ]);
      $product_filter = "";
      $data = array();
      $menus = $helper->getProductMenus();
      $filter_params = array();
      $stock_params = array();

      $cirtifications = $helper->getCirtifications();
      $product_filter = urlencode($request->product_filter);
      $data = $helper->hitCoffeePlugGetEndpoint('stock-postings-search-all?searchQuery=' . $product_filter);
      $get_stock_params = $helper->hitCoffeePlugGetEndpoint('filter-options-stock-postings');
      //   dd($data);
      if ($data->statusCode == 200)
         $data = $data->data;

      if (!empty($get_stock_params) && $get_stock_params->statusCode == 200)
         $stock_params = $get_stock_params->data;

      return view('new_web_pages.buyer_pages.buyer_market_place', compact('helper', 'data', 'menus', 'product_filter', 'stock_params', 'filter_params', 'cirtifications'));
   }

   public function filter_multi_product(Request $request)
   {
      if (session('auth_user_tokin') == null) {
         return  redirect()->route('login_page');
      }
      $helper = new Helper();
      // $this->validate($request, [
      //     'product_filter' => 'required'
      // ]);
      $product_filter = "";
      $data = array();
      $filter_params = array();
      $menus = $helper->getProductMenus();
      $stock_params = array();

      if (!empty($request->country)) {
         $product_filter = $product_filter . "originCountry=" . urlencode($request->country) . "&";
         $filter_params = array_merge($filter_params, array('originCountry' => $request->country));
      }
      if (!empty($request->process)) {
         $product_filter = $product_filter . "process=" . urlencode($request->process) . "&";
         $filter_params = array_merge($filter_params, array('process' => $request->process));
      }
      if ($request->quality != "") {
         $quality = $this->filter_quality_bounds(urlencode($request->quality));
         $product_filter = $product_filter . $quality . "&";
         $filter_params = array_merge($filter_params, array('quality' => $request->quality));
      }
      if (!empty($request->coffeeType)) {
         $isSpecialty = 'false';
         if ($request->coffeeType == "Specialty") {
            $isSpecialty = 'true';
         }
         $product_filter = $product_filter . "isSpecialty=" . $isSpecialty . "&";
         $filter_params = array_merge($filter_params, array('coffeeType' => $request->coffeeType));
      }
      if (!empty($request->variety)) {
         $product_filter = $product_filter . "variety=" . urlencode($request->variety) . "&";
         $filter_params = array_merge($filter_params, array('variety' => $request->variety));
      }
      if (!empty($request->species)) {
         $product_filter = $product_filter . "coffeeType=" . urlencode($request->species) . "&";
         $filter_params = array_merge($filter_params, array('species' => $request->species));
      }

      //   dd($product_filter,$request);
      if (empty($product_filter))
         return redirect()->back()->with('error', 'No filter parameter has been selected');

      // $product_filter = urlencode($product_filter);
      $data = $helper->hitCoffeePlugGetEndpoint('stock-postings?' . $product_filter);
      $get_stock_params = $helper->hitCoffeePlugGetEndpoint('filter-options-stock-postings');
      // dd($data,$product_filter);
      $cirtifications = $helper->getCirtifications();
      if (!empty($data) && $data->statusCode == 200)
         $data = $data->data;
      if (!empty($get_stock_params) && $get_stock_params->statusCode == 200)
         $stock_params = $get_stock_params->data;
      // else
      // return redirect()->back()->with('error','No filter parameter has been selected');

      $product_filter = "";
      return view('new_web_pages.buyer_pages.buyer_market_place', compact('helper', 'data', 'menus', 'product_filter', 'filter_params', 'stock_params', 'cirtifications'));
   }

   public function filter_quality_bounds($bound)
   {
      $quality_bound = "";

      if ($bound == "90-100") {
         $quality_bound = "qualityScoreLowerBound=90&qualityScoreUpperBound=100";
      } else if ($bound == "85-89") {
         $quality_bound = "qualityScoreLowerBound=85&qualityScoreUpperBound=89";
      } else if ($bound == "80-84") {
         $quality_bound = "qualityScoreLowerBound=80&qualityScoreUpperBound=84";
      } else {
         $quality_bound = "qualityScoreLowerBound=0&qualityScoreUpperBound=83";
      }

      return $quality_bound;
   }


   public function filter_multi_product_json(Request $request)
   {
      $helper = new Helper();

      $product_filter = "";
      $filtered_products = "";
      $data = array();
      $filter_params = array();

      if (!empty($request->country)) {
         $product_filter = $product_filter . "originCountry=" . urlencode($request->country) . "&";
         $filter_params = array_merge($filter_params, array('originCountry' => $request->country));
      }
      if (!empty($request->process)) {
         $product_filter = $product_filter . "process=" . urlencode($request->process) . "&";
         $filter_params = array_merge($filter_params, array('process' => $request->process));
      }
      if ($request->quality != "") {
         $quality = $this->filter_quality_bounds(urlencode($request->quality));
         $product_filter = $product_filter . $quality . "&";
         $filter_params = array_merge($filter_params, array('quality' => $request->quality));
      }
      if (!empty($request->coffeeType)) {
         $isSpecialty = 'false';
         if ($request->coffeeType == "Specialty") {
            $isSpecialty = 'true';
         }
         $product_filter = $product_filter . "isSpecialty=" . $isSpecialty . "&";
         $filter_params = array_merge($filter_params, array('coffeeType' => $request->coffeeType));
      }
      if (!empty($request->variety)) {
         $product_filter = $product_filter . "variety=" . urlencode($request->variety) . "&";
         $filter_params = array_merge($filter_params, array('variety' => $request->variety));
      }
      if (!empty($request->species)) {
         $product_filter = $product_filter . "coffeeType=" . urlencode($request->species) . "&";
         $filter_params = array_merge($filter_params, array('species' => $request->species));
      }

      //   dd($product_filter,$request);
      if (empty($product_filter))
         $filtered_products = "";

      // $product_filter = urlencode($product_filter);
      $data = $helper->hitCoffeePlugGetEndpoint('stock-postings?' . $product_filter);
      // dd($data,$product_filter);
      if (!empty($data) && $data->statusCode == 200) {
         $data = $data->data;
         foreach ($data as $datum) {
            $filtered_products = "";
         }
         $filtered_products = $data;
      }
   }
}
