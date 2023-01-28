@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Category</a></li>
    </ol>
</div>
<div class="">
    <div class="row">
        <div class="col-lg-8">
            @can('show_category')
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Icon</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $sl=>$category)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                @if (App\Models\User::where('id', $category->added_by)->exists())
                                    {{ $category->rel_to_user->name }}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td><img width="50" src="{{ asset('uploads/category') }}/{{ $category->category_img }}" class="img-fluid rounded-top" alt=""></td>
                            <td style="font-family:fontawesome "><i class="{{ $category->icon }}"></i></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        @can('edit_category')
                                        <a class="dropdown-item" href="{{ route('edit.category', $category->id) }}">Edit</a>
                                        @endcan
                                        @can('delete_category')
                                        <a class="dropdown-item" href="{{ route('delete.category', $category->id) }}">Delete</a>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
            @endcan

            {{-- <div class="card">
                <div class="card-header">
                    <h3>Soft Deleted Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <tr>
                            <th>SL</th>
                            <th>Category</th>
                            <th>Added By</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($trash_categories as $sl=>$category)
                        <tr>
                            <td>{{ $sl+1 }}</td>
                            <td>{{ $category->category_name }}</td>
                            <td>
                                @if (App\Models\User::where('id', $category->added_by)->exists())
                                    {{ $category->rel_to_user->name }}
                                @else
                                    Unknown
                                @endif
                            </td>
                            <td><img width="50" src="{{ asset('uploads/category') }}/{{ $category->category_img }}" class="img-fluid rounded-top" alt=""></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{ route('restore.category', $category->id) }}">Restore</a>
                                        <a class="dropdown-item" href="{{ route('delete.hard.category', $category->id) }}">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div> --}}
        </div>

        <div class="col-lg-4">
            <div class="card">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                <div class="card-header">
                    <h3>Add Category</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            @php
                               $icons = [
                                    'fa-glass',
                                    'fa-music',
                                    'fa-search',
                                    'fa-envelope-o',
                                    'fa-heart',
                                    'fa-star',
                                    'fa-star-o',
                                    'fa-user',
                                    'fa-film',
                                    'fa-th-large',
                                    'fa-th',
                                    'fa-th-list',
                                    'fa-check',

                                    'fa-file',
                                    'fa-file-text',
                                    'fa-sort-alpha-asc',
                                    'fa-sort-alpha-desc',
                                    'fa-sort-amount-asc',
                                    'fa-sort-amount-desc',
                                    'fa-sort-numeric-asc',
                                    'fa-sort-numeric-desc',
                                    'fa-thumbs-up',
                                    'fa-thumbs-down',
                                    'fa-youtube-square',
                                    'fa-youtube',
                                    'fa-xing',
                                    'fa-xing-square',
                                    'fa-youtube-play',
                                    'fa-dropbox',
                                    'fa-stack-overflow',
                                    'fa-instagram',
                                    'fa-flickr',
                                    'fa-adn',
                                    'fa-bitbucket',

                                    'fa-file-audio-o',
                                    'fa-file-video-o',
                                    ];
                            @endphp
                            <label for="" class="form-label">Select  Icon</label>
                            <div style="font-family:fontawesome; font-size:22px">
                                @foreach ($icons as $icon)
                                    <i class="fa {{ $icon }}" data-icon="{{ $icon }}"></i>
                                @endforeach
                            </div>
                            <input type="text" id="icon" name="icon" class="form-control" placeholder="icon">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="category_name">
                            @error('category_name')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Category Image</label>
                            <input type="file" class="form-control" name="category_img">
                            @error('category_img')
                                <strong class="text-danger">{{ $message }}</strong>
                            @enderror
                        </div>
                        <div class="mb-3 pt-3">
                            <button class="btn btn-primary" type="submit">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_script')
<script>
    $('.fa').click(function(){
        var icon = $(this).attr('data-icon');
        $('#icon').attr('value', icon);
    });
</script>
@endsection
