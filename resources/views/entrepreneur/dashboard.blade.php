@extends('layouts.app')

@section('title', 'Tableau de bord Entrepreneur - Plateforme Eat&Drink')

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
                        <li class="active"><a href="{{ route('entrepreneur.dashboard') }}">Dashboard</a></li>
                        <li><a href="{{ route('entrepreneur.products') }}">Products</a></li>
                        <li><a href="{{ route('entrepreneur.orders') }}">Orders</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li>Statut :
                            @if($entrepreneur->isApproved())
                                <span class="badge badge-success">Approuvé</span>
                            @elseif($entrepreneur->isWaitingApproval())
                                <span class="badge badge-warning">En attente d'approbation</span>
                            @else
                                <span class="badge badge-danger">Rejeté</span>
                            @endif
                        </li>
                    </ul>
                </div>
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
                    <h2>Tableau de bord Entrepreneur</h2>
                    <div class="breadcrumb__option">
                        <span>{{ $entrepreneur->nom_entreprise }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Dashboard Section Begin -->
<section class="shoping-cart spad">
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($entrepreneur->isWaitingApproval())
            <div class="alert alert-warning" role="alert">
                <h5><i class="fa fa-clock-o"></i> Compte en attente d'approbation</h5>
                <p>Votre compte entrepreneur est actuellement en attente d'approbation. Vous pouvez gérer vos produits et voir les commandes, mais certaines fonctionnalités peuvent être limitées jusqu'à ce que votre compte soit approuvé par un administrateur.</p>
            </div>
        @elseif($entrepreneur->isRejected())
            <div class="alert alert-danger" role="alert">
                <h5><i class="fa fa-times-circle"></i> Compte rejeté</h5>
                <p><strong>Raison :</strong> {{ $entrepreneur->rejection_reason }}</p>
                <p>Veuillez contacter le support pour plus d'informations.</p>
            </div>
        @endif

        <!-- Dashboard Stats -->
        <div class="row mb-5">
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-primary mb-3">
                            <i class="fa fa-shopping-bag fa-3x"></i>
                        </div>
                        <h3 class="card-title">{{ $totalProducts }}</h3>
                        <p class="card-text text-muted">Produits au total</p>
                        <a href="{{ route('entrepreneur.products') }}" class="btn btn-outline-primary btn-sm">
                            Gérer les produits
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-success mb-3">
                            <i class="fa fa-shopping-cart fa-3x"></i>
                        </div>
                        <h3 class="card-title">{{ $totalOrders }}</h3>
                        <p class="card-text text-muted">Commandes au total</p>
                        <a href="{{ route('entrepreneur.orders') }}" class="btn btn-outline-success btn-sm">
                            Voir les commandes
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="text-warning mb-3">
                            <i class="fa fa-clock-o fa-3x"></i>
                        </div>
                        <h3 class="card-title">{{ $pendingOrders }}</h3>
                        <p class="card-text text-muted">Commandes en attente</p>
                        <a href="{{ route('entrepreneur.orders') }}" class="btn btn-outline-warning btn-sm">
                            Traiter les commandes
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <h4 class="mb-4">Actions rapides</h4>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fa fa-plus-circle text-primary"></i> Ajouter un produit
                                    </h5>
                                    <p class="card-text">Ajoutez un nouveau produit à votre catalogue et commencez à vendre.</p>
                                    <a href="{{ route('entrepreneur.products') }}" class="btn btn-primary">
                                        Ajouter un produit
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-lg-6 mb-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <i class="fa fa-list-alt text-success"></i> Gérer les commandes
                                    </h5>
                                    <p class="card-text">Consultez et gérez les commandes clients pour vos produits.</p>
                                    <a href="{{ route('entrepreneur.orders') }}" class="btn btn-success">
                                        Voir les commandes
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row mt-5">
            <div class="col-lg-12">
                <h4 class="mb-4">Activité récente</h4>
                <div class="card">
                    <div class="card-body">
                        @if(isset($recentProducts) && $recentProducts->count())
                            <ul class="list-group list-group-flush">
                                @foreach($recentProducts as $product)
                                    <li class="list-group-item d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}" class="img-thumbnail mr-3" style="max-width: 60px;">
                                        <div>
                                            <strong>{{ $product->name }}</strong><br>
                                            <small class="text-muted">Ajouté le {{ $product->created_at->format('d/m/Y H:i') }}</small>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-info-circle fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Aucune activité récente</h5>
                                <p class="text-muted">Commencez par ajouter des produits pour voir l'activité ici.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Dashboard Section End -->
@endsection

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .badge {
        font-size: 0.8em;
        padding: 0.4em 0.6em;
    }
    .badge-success {
        background-color: #28a745;
    }
    .badge-warning {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-danger {
        background-color: #dc3545;
    }
    .alert {
        border-radius: 0.375rem;
    }
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
