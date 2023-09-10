@extends('layouts.main')

@section('content')


@foreach ($product_array as $product)
    

 <!-- Products Start -->
 <div id="products">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="product-single">
                    <div class="product-img">
                        <img src="{{ asset('img/'.$product->image) }}" alt="Product Image">
                    </div>
                    <div class="product-content">
                        <h2>{{ $product->name }}</h2>
                        
                        @if ($product->sale_price != null)
                                <h3>${{ $product->sale_price }}</h3>                                
                                <h3 style="text-decoration: line-through;">${{ $product->price }}</h3>
                        @else
                        <h3>${{ $product->price }}</h3>                                
                        @endif
                        
                        <p>{{ $product->description }}</p>
                        <p>{{ $product->category }} - {{ $product->type }}</p>

                        {{-- THIS FORM IS FOR ADDING A PRODUCT TO CART --}}
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

                    </div>
                </div>
            </div>
          
        </div>

    </div>
</div>
<!-- Products End -->

@endforeach


@endsection 