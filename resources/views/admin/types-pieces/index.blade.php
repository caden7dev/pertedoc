@extends('layouts.app')

@section('title', 'Gestion des Types de Pièces')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3" style="position: relative;">
            <h5 class="mb-4">🇹🇬 e-Déclaration TG</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">📊 Tableau de bord</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('admin.users.index') }}">👤 Gestion des Utilisateurs</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white active" href="{{ route('admin.types-pieces.index') }}" style="background: rgba(255,255,255,0.1); border-radius: 5px;">🪪 Types de Pièces</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('admin.roles.index') }}">🔐 Rôles & Droits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">📈 Statistiques & Rapports</a>
                </li>
            </ul>

            {{-- Bouton de déconnexion --}}
            <div class="mt-auto pt-4" style="position: absolute; bottom: 20px; left: 15px; right: 15px;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger w-100" style="border-radius: 10px; font-weight: 600;">
                        🚪 Se déconnecter
                    </button>
                </form>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="col-md-10 p-4">
            <h4 class="mb-4">Gestion des Types de Pièces</h4>

            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Types de pièces disponibles</strong>
                </div>
                <div class="card-body">
                    <p class="alert alert-info">
                        <strong>ℹ️ Information :</strong> Cette page est en cours de développement. Vous pourrez bientôt ajouter, modifier et supprimer des types de pièces.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection