@extends('layouts.main')

@section('content')

<!-- Products Start -->
<div id="products">
    <div class="container">
        <div class="section-header">
            <h2>Get Your Products</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec viverra at massa sit amet ultricies
            </p>
        </div>
        <div class="row align-items-center">

            @foreach ($products as $product)
                
                <div class="col-md-3">
                    <div class="product-single">
                        <div class="product-img">
                            <a href="{{ route('single.product',['id'=>$product->id]) }}">
                                <img src="{{ asset('img/'.$product->image) }}" style="width:100px; height:100px"  alt="Product Image">
                            </a>
                        </div>
                        <div class="product-content">
                            <a href="{{ route('single.product',['id'=>$product->id]) }}"> {{ $product->name }} </a>
                            
                            @if ($product->sale_price != null)
                                <h3>${{ $product->sale_price }}</h3>                                
                                <h3 style="text-decoration: line-through;">${{ $product->price }}</h3>
                            @else
                            <h3>${{ $product->price }}</h3>                                
                            @endif

                            <form action="{{ route('add_to_cart') }}" method="POST">
                                @csrf
    
                                <input type="hidden" name="id" id="" value="{{ $product->id }}">
                                <input type="hidden" name="name" id="" value="{{ $product->name }}">
                                <input type="hidden" name="price" id="" value="{{ $product->price }}">
                                <input type="hidden" name="sale_price" id="" value="{{ $product->sale_price }}">
                                <input type="hidden" name="quantity" id="" value="1">
                                <input type="hidden" name="image" id="" value="{{ $product->image }}">
    
                                <input type="submit" name="" id="" value="Add to cart" class="btn">
    
                            </form>

                            {{-- <a class="btn" href="#">Buy Now</a> --}}
                        </div>
                    </div>
                </div>

            @endforeach
            
        </div>


        
        {{-- STYLE AND CODE FOR PAGINATION STARTS--}}
        <style>
            svg{
                width: 20px;
            }
            nav p{
                display: none;
            }
            nav .flex a{
                display: none;
            }
            nav .flex span{
                display: none;
            }
        </style>


        <div class="text-right">
            {{ $products->links() }}
        </div>

        {{-- STYLE AND CODE FOR PAGINATION ENDS--}}
    

    </div>
</div>
<!-- Products End -->



@endsection