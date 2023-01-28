@extends('frontend.master')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 m-auto">
                <div class="mb-3 mt-4">
                    <h3>Password Reset Form - {{ $token }}</h3>
                </div>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <form class="border p-3 rounded" action="{{ route('customer.pass.reset.confirm') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>New Password *</label>
                        <input type="hidden" name="token" class="form-control" value="{{ $token }}">
                        <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password *</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-md full-width bg-dark text-light fs-md ft-medium">Reset
                            Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
