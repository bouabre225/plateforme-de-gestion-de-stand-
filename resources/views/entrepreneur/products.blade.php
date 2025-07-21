                                                                                                                                @extends('layouts.app')

@section('title', 'Product Management - Eat&Drink Platform')

@section('content')
<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li><i class="fa fa-envelope"></i> {{ $entrepreneur->email }}</li>
                            <li>Welcome, {{ $entrepreneur->enterprise_name }}!</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__auth">
                            <form method="POST" action="{{ route('entrepreneur.logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-link text-white p-0" style="text-decoration: none;">
                                    <i class="fa fa-sign-out"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo">
                    <a href="{{ route('entrepreneur.dashboard') }}">
                        <h3 class="text-success">Eat&Drink</h3>
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li><a href="{{ route('entrepreneur.dashboard') }}">Dashboard</a></li>
                        <li class="active"><a href="{{ route('entrepreneur.products') }}">Products</a></li>
                        <li><a href="{{ route('entrepreneur.orders') }}">Orders</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- Header Section End -->

<!-- Breadcrumb Section Begin -->
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2>Product Management</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('entrepreneur.dashboard') }}">Dashboard</a>
                        <span>Products</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Products Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4>Your Products</h4>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                            <i class="fa fa-plus"></i> Add New Product
                        </button>
                    </div>
                    @if($products->count())
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td style="width: 120px;">
                                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 100px;">
                                        </td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->description }}</td>
                                        <td>{{ number_format($product->price, 2) }} €</td>
                                        <td>
                                            <a href="{{ route('entrepreneur.products.edit', $product->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a>
                                            <form action="{{ route('entrepreneur.products.delete', $product->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                                                    <i class="fa fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center py-5">
                                    <i class="fa fa-shopping-bag fa-4x text-muted mb-4"></i>
                                    <h4 class="text-muted">No Products Yet</h4>
                                    <p class="text-muted mb-4">Start by adding your first product to begin selling on the platform.</p>
                                    <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addProductModal">
                                        <i class="fa fa-plus"></i> Add Your First Product
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('entrepreneur.products.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="addProductModalLabel">Add New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price (€)</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" required value="{{ old('price') }}">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Product</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Products Section End -->
@endsection

@push('styles')
<style>
    .header__top__right__auth button {
        background: none;
        border: none;
        color: inherit;
        font-size: inherit;
    }
    .header__top__right__auth button:hover {
        text-decoration: underline !important;
    }
</style>
@endpush
