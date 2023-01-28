@extends('frontend.master')

@section('content')
<!-- ======================= Top Breadcrubms ======================== -->
<div class="gray py-3">
    <div class="container">
        <div class="row">
            <div class="colxl-12 col-lg-12 col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Support</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- ======================= Top Breadcrubms ======================== -->


<!-- ======================= Product Detail ======================== -->
@if (App\Models\Cart::where('customer_id', Auth::guard('customerlogin')->id())->count() == 0)
    <!-- ======================= Product Detail ======================== -->
    <section class="middle">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-12 col-md-10 col-lg-8 col-xl-6 text-center">

                    <!-- Icon -->
                    <div class="p-4 d-inline-flex align-items-center justify-content-center circle bg-light-success text-secondary mx-auto mb-4"><img width="100" src="https://cdn-icons-png.flaticon.com/512/102/102661.png" alt=""></div>
                    <!-- Heading -->
                    <h2 class="mb-5 ft-bold">Your Cart is Empty!</h2>
                    <!-- Text -->
                    <!-- Button -->
                    <a class="btn btn-dark" href="{{ url('/') }}">Back To Shop</a>
                </div>
            </div>

        </div>
    </section>
    <!-- ======================= Product Detail End ======================== -->
@else
<section class="middle">
    <div class="container">

        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                <div class="text-center d-block mb-5">
                    <h2>Shopping Cart</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="col-12 col-lg-7 col-md-12">
                <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x mb-4">
                    @php
                        $subtotal = 0;
                    @endphp
                    @foreach ($carts as $cart)
                    <li class="list-group-item">
                        <div class="row align-items-center">
                            <div class="col-3">
                                <!-- Image -->
                                <a href="product.html"><img src="{{ asset('uploads/product/preview') }}/{{ $cart->rel_to_product->preview }}" alt="..." class="img-fluid"></a>
                            </div>
                            <div class="col d-flex align-items-center justify-content-between">
                                <div class="cart_single_caption pl-2">
                                    <h4 class="product_title fs-md ft-medium mb-1 lh-1">{{ $cart->rel_to_product->product_name }}</h4>
                                    <p class="mb-1 lh-1"><span class="text-dark">Size: {{ $cart->rel_to_size->size_name }}</span></p>
                                    <p class="mb-3 lh-1"><span class="text-dark">Color: {{ $cart->rel_to_color->color_name }}</span></p>
                                    <h4 class="fs-md ft-medium mb-3 lh-1">TK {{ $cart->rel_to_product->after_discount }}</h4>
                                    <select class="mb-2 custom-select w-auto" name="quantity[{{ $cart->id }}]">
                                        <option value="1" {{ ($cart->quantity == 1)?'selected':'' }}>1</option>
                                        <option value="2" {{ ($cart->quantity == 2)?'selected':'' }}>2</option>
                                        <option value="3" {{ ($cart->quantity == 3)?'selected':'' }}>3</option>
                                        <option value="4" {{ ($cart->quantity == 4)?'selected':'' }}>4</option>
                                        <option value="5" {{ ($cart->quantity == 5)?'selected':'' }}>5</option>
                                    </select>
                                </div>
                                <div class="fls_last"><a href="{{ route('cart.remove', $cart->id) }}" class="close_slide gray"><i class="ti-close"></i></a></div>
                            </div>
                        </div>
                    </li>
                    @php
                        $subtotal += $cart->rel_to_product->after_discount*$cart->quantity;
                    @endphp
                    @endforeach
                </ul>

                <div class="row align-items-end justify-content-between mb-10 mb-md-0">
                    <div class="col-12 col-md-auto mfliud">
                        <button class="btn stretched-link borders">Update Cart</button>
                    </div>
                    </form>
                    <div class="col-12 col-md-7">
                        <!-- Coupon -->
                        <form class="mb-7 mb-md-0" action="" method="GET">
                            @csrf
                            <label class="fs-sm ft-medium text-dark">Coupon code:</label>
                            <div class="row form-row">
                                <div class="col">
                                    <input class="form-control" value="{{@$_GET['coupon']}}" name="coupon" type="text" placeholder="Enter coupon code*">
                                </div>
                                <div class="col-auto">
                                    <button class="btn btn-dark" type="submit">Apply</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                @if ($message)
                    <div class="alert alert-warning mt-3">{{ $message }}</div>
                @endif
            </div>

            <div class="col-12 col-md-12 col-lg-4">
                <div class="card mb-4 gray mfliud">
                    <div class="card-body">
                    <ul class="list-group list-group-sm list-group-flush-y list-group-flush-x">
                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Subtotal</span> <span class="ml-auto text-dark ft-medium">TK {{ $subtotal }}</span>
                        </li>
                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        <span>Discount</span> <span class="ml-auto text-dark ft-medium">- {{ ($type == 1)?$subtotal*$discount/100:$discount }} TK</span>
                        </li>
                        <li class="list-group-item d-flex text-dark fs-sm ft-regular">
                        @php
                            if($type == 1){
                               $total = $subtotal - ($subtotal*$discount/100);
                            }
                            else{
                                $total = $subtotal - $discount;
                            }
                        @endphp
                        <span>Total</span> <span class="ml-auto text-dark ft-medium">TK {{ $total }}</span>
                        </li>
                        <li class="list-group-item fs-sm text-center">
                        Shipping cost calculated at Checkout *
                        </li>
                    </ul>
                    </div>
                </div>
                @php
                    $final_discount = ($type == 1)?$subtotal*$discount/100:$discount;
                    session([
                        'total'=>$total,
                        'discount'=>$final_discount,
                    ])
                @endphp
                <a class="btn btn-block btn-dark mb-3" href="{{ route('checkout') }}">Proceed to Checkout</a>

                <a class="btn-link text-dark ft-medium" href="shop.html">
                    <i class="ti-back-left mr-2"></i> Continue Shopping
                </a>
            </div>
        </div>
    </div>
</section>
@endif
<!-- ======================= Product Detail End ======================== -->
@endsection
