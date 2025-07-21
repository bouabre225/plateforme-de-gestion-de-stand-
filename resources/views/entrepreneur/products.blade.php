                                                                                                                                @extends('layouts.app')

@section('title', 'Gestion des produits - Plateforme Eat&Drink')

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
                            <li>Bienvenue, {{ $entrepreneur->nom_entreprise }} !</li>
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
                        <li class="active"><a href="{{ route('entrepreneur.products') }}">Produits</a></li>
                        <li><a href="{{ route('entrepreneur.orders') }}">Commandes</a></li>
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
                    <h2>Gestion des produits</h2>
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
    <div class="container-fluid px-2 px-md-4">
        <div class="row">
            <div class="col-12">
                <div class="shoping__cart__table table-responsive">
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
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4 gap-2">
                        <h4 class="mb-0">Vos produits</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">
                            <i class="fa fa-plus"></i> Ajouter un produit
                        </button>
                    </div>
                    @if($products->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Image</th>
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Prix</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $product)
                                        <tr>
                                            <td style="width: 120px;">
                                                <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail" style="max-width: 100px;">
                                            </td>
                                            <td>{{ $product->nom }}</td>
                                            <td>{{ $product->description }}</td>
                                            <td>{{ number_format($product->prix, 2) }} €</td>
                                            <td>
                                                <a href="{{ route('entrepreneur.products.edit', $product->id) }}" class="btn btn-sm btn-warning mb-1">Modifier</a>
                                                <form action="{{ route('entrepreneur.products.delete', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger mb-1" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-info-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucun produit pour l'instant</h5>
                            <p class="text-muted">Ajoutez un produit pour commencer à vendre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Add Product Modal -->
        <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <form method="POST" action="{{ route('entrepreneur.products.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addProductModalLabel">Ajouter un produit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="nom" class="form-label">Nom du produit</label>
                                <input type="text" class="form-control" id="nom" name="nom" required value="{{ old('nom') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="prix" class="form-label">Prix (€)</label>
                                <input type="number" step="0.01" class="form-control" id="prix" name="prix" required value="{{ old('prix') }}">
                            </div>
                            <div class="form-group mb-3">
                                <label for="image" class="form-label">Image du produit</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Ajouter</button>
                        </div>
                    </form>
                </div>
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
