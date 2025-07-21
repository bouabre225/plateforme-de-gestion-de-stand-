@extends('layouts.app')

@section('title', 'Edit Product - Eat&Drink Platform')

@section('content')
<header class="header">
    <!-- ... header code unchanged ... -->
</header>
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <!-- ... breadcrumb code unchanged ... -->
</section>
<section class="shoping-cart spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Edit Product</h5>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('entrepreneur.products.update', $product->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $product->name) }}">
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description', $product->description) }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price (€)</label>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price', $product->price) }}">
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">Product Image</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                @if($product->image_url)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 120px;">
                                    </div>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('entrepreneur.products') }}" class="btn btn-secondary">Back to Products</a>
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection 