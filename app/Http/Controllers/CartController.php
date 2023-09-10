<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cart()
    {
        return view('cart');
    }


    public function add_to_cart(Request $request)
    {
        //If we have a cart in session
        if($request->session()->has('cart'))
        {
            $cart = $request->session()->get('cart');  // ['id' => [], '2' => [product information], '3' => []]

            $products_array_ids = array_column($cart, 'id'); //[4,34,21]   Array of product IDs that has already been added to cart.

            $id = $request->input('id');  //54     This line collects a single product id as an input

            //Add product to cart if the single product id does not exist in the above array
            if(!(in_array($id, $products_array_ids)))
            {
                $name = $request->input('name');
                $image = $request->input('image');
                $price = $request->input('price');  ///Original price
                $quantity = $request->input('quantity');
                $sale_price = $request->input('sale_price');  ///Discounted price

                if($sale_price != null){
                    $price_to_charge = $sale_price;
                }else{
                    $price_to_charge = $price;
                }

                $product_array = array(
                    'id' => $id,
                    'name' => $name,
                    'image' => $image,
                    'price' => $price_to_charge,
                    'quantity' => $quantity
                );

                $cart[$id] = $product_array;
                $request->session()->put('cart', $cart);


            }
            //product is already in cart
            else
            {
                echo "<script>alert('Product is already in cart');</script>";
            }

            $this->calculateTotalCart($request);   ///calling the function below to keep calculating the total before the return line

            return view('cart');


        
            //if we dont have a cart in session        
        }else{ 
            
            $cart = array();

            $id = $request->input('id');  //54     This line collects a single product id as an input
            $name = $request->input('name');
            $image = $request->input('image');
            $price = $request->input('price');  ///Original price
            $quantity = $request->input('quantity');
            $sale_price = $request->input('sale_price');  ///Discounted price

            if($sale_price != null){
                $price_to_charge = $sale_price;
            }else{
                $price_to_charge = $price;
            }

            $product_array = array(
                'id' => $id,
                'name' => $name,
                'image' => $image,
                'price' => $price_to_charge,
                'quantity' => $quantity
            );

            $cart[$id] = $product_array;
            $request->session()->put('cart', $cart);

            $this->calculateTotalCart($request);   ///calling the function below to keep calculating the total before the return line

            return view('cart');

        }

    }



    public function calculateTotalCart(Request $request)
    {
        $cart = $request->session()->get('cart');
        $total_price = 0;
        $total_quantity = 0;

        foreach($cart as $id => $product)
        {
            $product = $cart[$id];
            $price = $product['price'];
            $quantity = $product['quantity'];

            $total_price = $total_price + ($price * $quantity);
            $total_quantity = $total_quantity + $quantity;
        }

        $request->session()->put('total', $total_price);
        $request->session()->put('quantity', $total_quantity);
        

    }


    // The below form is to remove an item from cart
    public function remove_from_cart(Request $request)
    {
        if($request->session()->has('cart')){
            $id = $request->input('id');
            $cart = $request->session()->get('cart'); //This line is an array []

            unset($cart[$id]);

            $request->session()->put('cart', $cart);

            $this->calculateTotalCart($request);
        }

        return view('cart');
         
    }


    public function edit_product_quantity(Request $request)
    {
        if($request->session()->has('cart'))
        {
            $product_id = $request->input('id');
            $product_quantity = $request->input('quantity');

            if($request->has('decrease_product_quantity_btn')){
                $product_quantity = $product_quantity - 1;

            }else if($request->has('increase_product_quantity_btn')){
                $product_quantity = $product_quantity + 1;

            }else{

            }

            if($product_quantity <= 0){
                $this->remove_from_cart($request);
            }

            $cart = $request->session()->get('cart'); //This line is an array

            if(array_key_exists($product_id, $cart))
            {
                $cart[$product_id]['quantity'] = $product_quantity;

                $request->session()->put('cart', $cart);

                $this->calculateTotalCart($request);
            }
        }

        return view('cart');
    }



    public function checkout()
    {
        return view('checkout');
    }



    public function place_order(Request $request)
    {
        if($request->session()->has('cart')){

            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $city = $request->input('city');
            $address = $request->input('address');

            $cost = $request->session()->get('total');
            $status = "not paid";
            $date = date('Y-m-d');

            $cart = $request->session()->get('cart');


            $order_id = DB::table('orders')->insertGetId([  //The insertGetId inserts the above requested fields into the db and then gets the id for future reference
                            'name' => $name,
                            'email' => $email,
                            'phone' => $phone,
                            'city' => $city,
                            'address' => $address,
                            'cost' => $cost,
                            'status' => $status,
                            'date' => $date,
                        ], 'id');

            foreach($cart as $id => $product){
                $product = $cart[$id];
                $product_id = $product['id'];
                $product_name = $product['name'];
                $product_price = $product['price'];
                $product_quantity = $product['quantity'];
                $product_image = $product['image'];

                DB::table('order_items')->insert([
                                    'order_id' => $order_id,
                                    'product_id' => $product_id,
                                    'product_name' => $product_name,
                                    'product_price' => $product_price,
                                    'product_quantity' => $product_quantity,
                                    'product_image' => $product_image,
                                    'order_date' => $date,
                ]);


            }


            $request->session()->put('order_id', $order_id);

            return view('payment');




        }else{
            return redirect('/');
        }
    }



































}
