<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

  </head>
  <body>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 my-5 text-center">
                <h3 class="bg-primary text-white py-3">All Products</h3>
            </div>
        </div>
        <div class="row">
            @foreach ($all_products as $product)
            <div class="col-lg-3">
                <div class="item my-3">
                    <img class="w-100 img-fluid" src="{{ asset('uploads/product/preview') }}/{{ $product->preview }}" alt="">
                    <p>{{ $product->product_name }}</p>
                </div>
            </div>
            @endforeach

            <div class="col-lg-12">
                <div class="my-3">
                    {{ $all_products->links('vendor.pagination.custom') }}
                </div>
            </div>


        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  </body>
</html>
