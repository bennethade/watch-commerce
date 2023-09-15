<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function index()
    {

        $products = Product::limit(4)->get();
        // $products = DB::table('products')->limit(4)->get();
        return view('index',['products' => $products]);
    }

    public function single_product(Request $request, $id)
    {
        $product_array = Product::where('id',$id)->get();
        // $product_array = DB::table('products')->where('id',$id)->get();
        return view('single_product',['product_array'=>$product_array]);
    }


    public function products()
    {
        $products = Product::paginate(20);
        // $products = DB::table('products')->get();
        return view('products',['products' => $products]);
    }








}
