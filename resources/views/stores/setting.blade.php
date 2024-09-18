@extends('layouts.dashboard')

@section('title', 'Store Setting')

@section('content')
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <!-- Edit Store Form -->
        <div class="p-4 sm:p-8 shadow sm:rounded-lg" style="background-color: #3f3f46; color: white;">
            <div class="max-w-xl">
                @include('stores.partials.edit')
            </div>
        </div>

        <!-- Delete Store Form -->
        <div class="p-4 sm:p-8 shadow sm:rounded-lg" style="background-color: #3f3f46; color: white;">
            <div class="max-w-xl">
                @include('stores.partials.delete')
            </div>
        </div>
    </div>
@endsection