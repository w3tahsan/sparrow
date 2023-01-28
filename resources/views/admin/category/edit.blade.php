@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                             <input type="hidden" class="form-control" name="category_id" value="{{ $catrgory_info->id }}">
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name" value="{{ $catrgory_info->category_name }}">
                            @error('category_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="category_img" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            @error('category_img')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror

                            <div class="mt-2">
                                <img id="blah" width="100" src="{{ asset('uploads/category') }}/{{ $catrgory_info->category_img }}" alt="">
                            </div>
                        </div>
                        <div class="mb-3 pt-3">
                            <button class="btn btn-primary" type="submit">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
