@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Store</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('store.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="store_name">Store Name</label>
            <input type="text" name="store_name" id="store_name" class="form-control" value="{{ old('store_name') }}" required>
            @error('store_name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="store_description">Store Description</label>
            <textarea name="store_description" id="store_description" class="form-control">{{ old('store_description') }}</textarea>
            @error('store_description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="logo">Store Logo</label>
            <input type="file" name="logo" id="logo" class="form-control-file">
            @error('logo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Create Store</button>
    </form>
</div>
@endsection
