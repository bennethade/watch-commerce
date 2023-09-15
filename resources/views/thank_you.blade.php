@extends('layouts.main')

@section('content')

<br><br><br><br>

<section class="container mt-5 my3 py5">
    <div class="container mt-2 text-center">
        <h4>Thatnk You!</h4>

        
            @if (Session::has('order_id') && Session::get('order_id') != null)

                <h4 style="color: blue" class="my-5">Order ID: {{ Session::get('order_id') }}</h4>

                <p>Please keep order ID in a safe place for future reference</p>

                
            @endif


    
        
                
    </div>
</section>
        
        
        
        
        
        
        
        
@endsection