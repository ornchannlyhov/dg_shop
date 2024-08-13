@extends('layouts.app')

@section('content')
    <h1>Stores</h1>
    <a href="{{ route('store.create') }}" class="btn btn-primary">Create New Store</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Owner</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stores as $store)
                <tr>
                    <td>{{ $store->name }}</td>
                    <td>{{ $store->description }}</td>
                    <td>{{ $store->seller->user->name }}</td>
                    <td>
                        <a href="{{ route('store.show', $store->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('store.edit', $store->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('store.destroy', $store->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
