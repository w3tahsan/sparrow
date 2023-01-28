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
                            <li class="breadcrumb-item active" aria-current="page">Product by Category:
                                <strong>{{ $category_name->category_name }}</strong>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- ======================= Top Breadcrubms ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row align-items-center rows-products">
                <!-- Single -->
                @foreach ($category_products as $product)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-6">
                        <div class="my-5">
                            @php
                                $abc = $product->after_discount;
                                settype($abc, 'string');
                            @endphp
                            {{-- {!! DNS2D::getBarcodeHTML($abc, 'QRCODE') !!} --}}

                        </div>
                        <div class="product_grid card b-0">
                            {{-- <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">Sale</div> --}}
                            @if ($product->discount != null)
                                <div class="badge bg-danger text-white position-absolute ft-regular ab-right text-upper">
                                    -{{ $product->discount }}%</div>
                            @endif
                            <div class="card-body p-0">
                                <div class="shop_thumb position-relative">
                                    <a class="card-img-top d-block overflow-hidden"
                                        href="{{ route('details', $product->slug) }}"><img class="card-img-top"
                                            src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}"
                                            alt="..."></a>
                                </div>
                            </div>
                            <div class="card-footer b-0 p-0 pt-2 bg-white d-flex align-items-start justify-content-between">
                                <div class="text-left">
                                    <div class="text-left">
                                        <div class="elso_titl"><span
                                                class="small">{{ $product->rel_to_cat->category_name }}</span>
                                        </div>
                                        <h5 class="fs-md mb-0 lh-1 mb-1"><a
                                                href="shop-single-v1.html">{{ $product->product_name }}</a></h5>
                                        <div class="star-rating align-items-center d-flex justify-content-left mb-2 p-0">
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star filled"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <div class="elis_rty">
                                            {{-- @if ($product->discount != null) --}}
                                            <span class="ft-medium text-muted line-through fs-md mr-2">BDT
                                                {{ $product->price }}</span>
                                            {{-- @endif
                                            <span class="ft-bold text-dark fs-sm">BDT {{ $product->after_discount }}</span> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
@endsection
