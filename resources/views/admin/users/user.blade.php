@extends('layouts.dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-9  m-auto">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @can('show_user_list')
                    <div class="card">
                        <div class="card-header">
                            <h1>User List</h1>
                            <span style="float: right">Total User: {{ $total_user }}</span>
                        </div>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tr>
                                    <th>SL</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($user->photo == null)
                                                <img width="50" src="{{ Avatar::create($user->name)->toBase64() }}" />
                                        </td>
                                    @else
                                        <img width="50" src="{{ asset('uploads/user') }}/{{ $user->photo }}" /></td>
                                @endif
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                <td>
                                    @can('delete_user')
                                        <a href="{{ route('user.delete', $user->id) }}" class="btn btn-danger">Delete</a>
                                    @endcan
                                </td>
                                </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                @endcan
            </div>
            <div class="col-lg-3">
                register form
            </div>
        </div>
    </div>
@endsection
