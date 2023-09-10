@extends('layouts.main')

@section('content')

<br><br><br><br>

<section class="container mt-5 my3 py5">
    <div class="container mt-2 text-center">
        <h4>Payment Page</h4>

        @if (Session::has('total') && Session::get('total') != null)
            @if (Session::has('order_id') && Session::get('order_id') != null)

                <h4 style="color: blue" class="my-5">Total to pay: ${{ Session::get('total') }}</h4>

            @endif
        @endif

        
    </div>
</section>




@endsection