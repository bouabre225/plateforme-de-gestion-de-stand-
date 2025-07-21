@extends('layouts.app')

@section('title', 'Connexion Entrepreneur - Plateforme Eat&Drink')

@section('content')
<section class="breadcrumb-section set-bg" data-setbg="{{ asset('img/breadcrumb.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="breadcrumb__text">
                    <h2 class="text-center mb-4">Connexion à votre espace entrepreneur</h2>
                    <div class="breadcrumb__option">
                        <a href="{{ url('/') }}">Home</a>
                        <span>Login</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="checkout spad">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="checkout__form">
                    <h4 class="mb-4">Entrepreneur Login</h4>
                    <p class="text-muted mb-4">Access your enterprise dashboard</p>
                    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('entrepreneur.login') }}">
                        @csrf
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <label for="email">Adresse e-mail</label>
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Entrez votre e-mail">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="checkout__input">
                                    <label for="mot_de_passe">Mot de passe</label>
                                    <input id="mot_de_passe" type="password" class="form-control" name="mot_de_passe" required placeholder="Entrez votre mot de passe">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <div class="checkout__input__checkbox">
                                    <label for="remember">
                                        Remember me
                                        <input type="checkbox" id="remember" name="remember">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-lg-12 text-center">
                                <p class="mt-3">Vous n'avez pas de compte ? <a href="{{ route('entrepreneur.register') }}">Inscrivez-vous ici</a></p>
                                <p>
                                    <a href="#" class="text-primary">Forgot your password?</a>
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .checkout__input input.is-invalid {
        border-color: #dc3545;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
    .alert {
        border-radius: 0.375rem;
        padding: 1rem;
        margin-bottom: 1rem;
    }
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
</style>
@endpush
