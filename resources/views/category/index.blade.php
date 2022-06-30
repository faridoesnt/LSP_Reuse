@extends('layouts.admin')

@section('main-content')

    <h1 class="h3 mb-4 text-gray-800">Master Category</h1>

    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12 order-lg-1">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('category.create') }}" class="btn btn-primary">Create New Category</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Category Name</th>
                                    <th>Created By</th>
                                    <th>Status</th>
                                    <th style="width: 30%;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($category as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            @if ($item->status == "Aktif")
                                                <div class="row">
                                                    <a href="{{ route('category.edit', $item->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                    <form action="{{ route('category-status', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success mr-2">
                                                            Set Nonactive
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('category.destroy', $item->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            @else
                                                <div class="row">
                                                    <a href="{{ route('category.edit', $item->id) }}" class="btn btn-primary mr-2">Edit</a>
                                                    <form action="{{ route('category-status', $item->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-success mr-2">
                                                            Set Active
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('category.destroy', $item->id) }}" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Category.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $category->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection