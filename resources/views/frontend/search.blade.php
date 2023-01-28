@extends('frontend.master')

@section('content')
    <!-- ======================= Shop Style 1 ======================== -->
    <section class="bg-cover" style="background:url({{ asset('frontend/img/banner-2.png') }}) no-repeat;">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <div class="text-left py-5 mt-3 mb-3">
                        <h1 class="ft-medium mb-3">Shop</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= Shop Style 1 ======================== -->


    <!-- ======================= Filter Wrap Style 1 ======================== -->
    <section class="py-3 br-bottom br-top">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Shop</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Women's</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- ============================= Filter Wrap ============================== -->


    <!-- ======================= All Product List ======================== -->
    <section class="middle">
        <div class="container">
            <div class="row">

                <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 p-xl-0">

                    <div class="search-sidebar sm-sidebar border">
                        <div class="col-lg-12">
                            <div class="form-group px-3">
                                <a href="{{ route('search') }}" id="price_btn" class="btn form-control">Reset Filter</a>
                            </div>
                        </div>
                        <div class="search-sidebar-body">
                            <!-- Single Option -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#pricing" data-toggle="collapse" aria-expanded="false"
                                            role="button">Pricing</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse show" id="pricing" data-parent="#pricing">
                                    <div class="row">
                                        <div class="col-lg-6 pr-1">
                                            <div class="form-group pl-3">
                                                <input type="number" id="min" class="form-control" name="min"
                                                    placeholder="Min" value="{{ @$_GET['min'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6 pl-1">
                                            <div class="form-group pr-3">
                                                <input type="number" id="max" class="form-control" name="max"
                                                    placeholder="Max" value="{{ @$_GET['max'] }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="px-3 price_btn">
                                                <button id="" class="btn form-control">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Option -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#Categories" data-toggle="collapse" aria-expanded="false"
                                            role="button">Categories</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse show" id="Categories" data-parent="#Categories">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="inner_widget_link">
                                                    <ul class="no-ul-list">
                                                        @foreach ($categories as $category)
                                                            <li>
                                                                <input id="category{{ $category->id }}" class="category_id"
                                                                    name="category_id" type="radio"
                                                                    value="{{ $category->id }}"
                                                                    @if (isset($_GET['category_id'])) @if ($_GET['category_id'] == $category->id)
                                                                    checked @endif
                                                                    @endif
                                                                >
                                                                <label for="category{{ $category->id }}"
                                                                    class="checkbox-custom-label">{{ $category->category_name }}<span>{{ App\Models\Product::where('category_id', $category->id)->count() }}</span></label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Option -->
                            {{-- <div class="single_search_boxed">
                            <div class="widget-boxed-header">
                                <h4><a href="#brands" data-toggle="collapse" aria-expanded="false" role="button">Brands</a></h4>
                            </div>
                            <div class="widget-boxed-body collapse show" id="brands" data-parent="#brands">
                                <div class="side-list no-border">
                                    <!-- Single Filter Card -->
                                    <div class="single_filter_card">
                                        <div class="card-body pt-0">
                                            <div class="inner_widget_link">
                                                <ul class="no-ul-list">
                                                    @foreach ($all_search_product as $brand)
                                                    <li>
                                                        <input id="brands1" class="checkbox-custom" name="brands" type="radio">
                                                        <label for="brands1" class="checkbox-custom-label">{{ $brand->brand }}<span>142</span></label>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                            <!-- Single Option -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#colors" data-toggle="collapse" class="collapsed" aria-expanded="false"
                                            role="button">Colors</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse" id="colors" data-parent="#colors">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="text-left">
                                                    @foreach ($colors as $color)
                                                        <div class="form-check form-check-inline mb-1">
                                                            <input id="color{{ $color->id }}" class="color_idd"
                                                                name="color_id" type="radio" value="{{ $color->id }}"
                                                                @if (isset($_GET['color_id'])) @if ($_GET['color_id'] == $color->id)
                                                                    checked @endif
                                                                @endif
                                                            >
                                                            <label for="color{{ $color->id }}"
                                                                class="checkbox-custom-label">{{ $color->color_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Single Option -->
                            <div class="single_search_boxed">
                                <div class="widget-boxed-header">
                                    <h4><a href="#size" data-toggle="collapse" class="collapsed" aria-expanded="false"
                                            role="button">Size</a></h4>
                                </div>
                                <div class="widget-boxed-body collapse" id="size" data-parent="#size">
                                    <div class="side-list no-border">
                                        <!-- Single Filter Card -->
                                        <div class="single_filter_card">
                                            <div class="card-body pt-0">
                                                <div class="text-left pb-0 pt-2">
                                                    @foreach ($sizes as $size)
                                                        <div class="form-check form-check-inline mb-1">
                                                            <input id="size{{ $size->id }}" class="size_idd"
                                                                name="size_id" type="radio"
                                                                value="{{ $size->id }}"
                                                                @if (isset($_GET['size_id'])) @if ($_GET['size_id'] == $size->id)
                                                                    checked @endif
                                                                @endif
                                                            >
                                                            <label for="size{{ $size->id }}"
                                                                class="checkbox-custom-label">{{ $size->size_name }}</label>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-9 col-lg-8 col-md-12 col-sm-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12">
                            <div class="border mb-3 mfliud">
                                <div class="row align-items-center py-2 m-0">
                                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-12">
                                        <h6 class="mb-0">Searched Products Found</h6>
                                    </div>

                                    <div class="col-xl-9 col-lg-8 col-md-7 col-sm-12">
                                        <div class="filter_wraps d-flex align-items-center justify-content-end m-start">
                                            <div class="single_fitres mr-2 br-right">
                                                <select class="custom-select simple" id="sort" name="sort">
                                                    <option value="">Default Sorting</option>
                                                    <option {{ @$_GET['sort'] == 1 ? 'selected' : '' }} value="1">
                                                        Sort
                                                        by
                                                        A - Z</option>
                                                    <option value="2" {{ @$_GET['sort'] == 2 ? 'selected' : '' }}>
                                                        Sort
                                                        by
                                                        Z - A</option>
                                                    <option value="3" {{ @$_GET['sort'] == 3 ? 'selected' : '' }}>
                                                        Sort
                                                        by
                                                        Low - High Price</option>
                                                    <option value="4" {{ @$_GET['sort'] == 4 ? 'selected' : '' }}>
                                                        Sort
                                                        by
                                                        Hight - Low price</option>
                                                </select>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- row -->
                    <div class="row align-items-center rows-products">

                        <!-- Single -->
                        @forelse ($all_search_product as $product)
                            <div class="col-xl-4 col-lg-4 col-md-6 col-6">
                                <div class="product_grid card b-0">
                                    <div class="badge bg-info text-white position-absolute ft-regular ab-left text-upper">
                                        New</div>
                                    <div class="card-body p-0">
                                        <div class="shop_thumb position-relative">
                                            <a class="card-img-top d-block overflow-hidden"
                                                href="shop-single-v1.html"><img class="card-img-top"
                                                    src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}"
                                                    alt="..."></a>
                                        </div>
                                    </div>
                                    <div class="card-footer b-0 p-0 pt-2 bg-white">

                                        <div class="text-left">
                                            <h5 class="fw-bolder fs-md mb-0 lh-1 mb-1"><a
                                                    href="shop-single-v1.html">{{ $product->product_name }}</a></h5>
                                            <div class="elis_rty"><span class="ft-bold text-dark fs-sm">TK
                                                    {{ $product->after_discount }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-lg-12 text-center">
                                <h3 class="mt-5 text-danger">No Search Product Found</h3>
                            </div>
                        @endforelse
                    </div>
                    <!-- row -->
                </div>
            </div>
        </div>
    </section>
    <!-- ======================= All Product List ======================== -->
@endsection
