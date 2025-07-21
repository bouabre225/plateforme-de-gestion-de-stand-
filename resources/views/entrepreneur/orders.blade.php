@extends('layouts.app')

@section('title', 'Gestion des commandes - Plateforme Eat&Drink')

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
                        <li><a href="{{ route('entrepreneur.products') }}">Produits</a></li>
                        <li class="active"><a href="{{ route('entrepreneur.orders') }}">Commandes</a></li>
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
                    <h2>Gestion des commandes</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ route('entrepreneur.dashboard') }}">Dashboard</a>
                        <span>Orders</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Breadcrumb Section End -->

<!-- Orders Section Begin -->
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
                        <h4 class="mb-0">Commandes clients</h4>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-primary btn-sm">Toutes</button>
                            <button class="btn btn-outline-warning btn-sm">En attente</button>
                            <button class="btn btn-outline-success btn-sm">Terminées</button>
                        </div>
                    </div>
                    @if($orders->count())
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Date</th>
                                        <th>Détails</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->id }}</td>
                                            <td>{{ $order->date_commande->format('d/m/Y H:i') }}</td>
                                            <td>{{ json_encode($order->details_commande) }}</td>
                                            <td><span class="badge badge-info">En attente</span></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fa fa-info-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune commande pour l'instant</h5>
                            <p class="text-muted">Ajouter des produits pour commencer à vendre.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Orders Section End -->
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
    .btn-group .btn {
        border-radius: 0;
    }
    .btn-group .btn:first-child {
        border-top-left-radius: 0.25rem;
        border-bottom-left-radius: 0.25rem;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 0.25rem;
        border-bottom-right-radius: 0.25rem;
    }
</style>
@endpush
