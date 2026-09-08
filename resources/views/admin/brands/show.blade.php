@extends('layouts.admin') {{-- Or whatever your admin layout is named --}}

@section('content')
<div class="container">
    <h1>Brand Details: {{ $brand->name }}</h1>
    <hr>
    <p><strong>Slug:</strong> {{ $brand->slug }}</p>
    <p><strong>Status:</strong> {{ $brand->is_active ? 'Active' : 'Inactive' }}</p>
    
    <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection