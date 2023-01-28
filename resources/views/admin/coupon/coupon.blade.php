@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Coupon List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Coupon</th>
                        <th>Discount</th>
                        <th>Expire Date</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $key=>$coupon)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $coupon->coupon_name }}</td>
                        <td>{{ $coupon->discount }} {{ ($coupon->type == 1)?'%':'TK' }}</td>
                        <td>{{ $coupon->expire }}</td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="">Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        @can('add_coupon')
        <div class="card">
            <div class="card-header">
                <h3>Add Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.coupon') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Name</label>
                        <input type="text" name="coupon_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Discount %</label>
                        <input type="number" name="discount" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Expire Date</label>
                        <input type="date" name="expire" class="form-control">
                    </div>
                    <div class="mb-3">
                       <select name="type" class="form-control">
                            <option value=""> -- Select Type </option>
                            <option value="1"> Percentage </option>
                            <option value="2"> Solid Amount </option>
                       </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
                    </div>
                </form>
            </div>
        </div>
        @endcan
    </div>
</div>
@endsection
