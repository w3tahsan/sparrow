@extends('layouts.dashboard')

@section('content')
<div class="">
    <div class="row">
        <div class="col-lg-8">
            @can('show_subcategory')
            <div class="card">
                <div class="card-header">
                    <h3>SubCategory List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>SubCategory</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($subcategories as $sl=>$subcategory)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $subcategory->rel_to_category->category_name }}</td>
                            <td>{{ $subcategory->subcategory_name }}</td>
                            <td><img width="50" src="{{ asset('uploads/subcategory') }}/{{ $subcategory->subcategory_img }}" class="img-fluid rounded-top" alt=""></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('edit.subcategory', $subcategory->id) }}">Edit</a>
                                        <a class="dropdown-item" href="{{ route('delete.category', $subcategory->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endcan
        </div>

        <div class="col-lg-4">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header">
                    <h3>Add SubCategory</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('subcategory.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <select name="category_id" class="form-control">
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">SubCategory Name</label>
                            <input type="text" class="form-control" name="subcategory_name">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="subcategory_img">
                        </div>
                        <div class="mb-3 pt-3">
                            <button class="btn btn-primary" type="submit">Add SubCategory</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

