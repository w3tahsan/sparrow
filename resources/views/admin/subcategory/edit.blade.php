@extends('layouts.dashboard')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto">
            <div class="card">
                 @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header">
                    <h3>Edit SubCategory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="hidden" name="id" value="{{ $subcategory_info->id }}">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ ($category->id == $subcategory_info->category_id?'selected':'') }}>{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">SubCategory Name</label>
                            <input type="text" value="{{ $subcategory_info->subcategory_name  }}" class="form-control" name="subcategory_name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                            <input onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" type="file" class="form-control" name="subcategory_img">
                            <div class="mt-2">
                                <img width="200" id="blah" src="{{ asset('uploads/subcategory') }}/{{ $subcategory_info->subcategory_img }}">
                            </div>
                        </div>
                        <div class="mb-3 pt-3">
                            <button class="btn btn-primary" type="submit">Update SubCategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
