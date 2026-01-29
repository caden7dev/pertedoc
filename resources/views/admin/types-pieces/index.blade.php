@extends('layouts.app')

@section('title', 'Gestion des Types de Pièces')

@section('content')
<style>
    /* Style pour la sidebar fixe */
    .admin-sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100vh;
        width: 250px;
        background: #2c3e50;
        overflow-y: auto;
        z-index: 1000;
    }
    
    .admin-content {
        margin-left: 250px;
        min-height: 100vh;
        background: #f8f9fa;
    }
    
    /* Bouton déconnexion bien positionné */
    .logout-section {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 250px;
        padding: 15px;
        background: #2c3e50;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
    
    .logout-btn {
        width: 100%;
        padding: 10px 15px;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
    }
    
    .logout-btn:hover {
        background: #c0392b;
        transform: translateY(-2px);
    }
    
    /* Padding pour éviter que le contenu passe sous le bouton logout */
    .sidebar-nav-wrapper {
        padding-bottom: 80px;
    }
    
    /* Nav links */
    .nav-link {
        transition: all 0.3s;
        border-radius: 5px;
        margin-bottom: 5px;
    }
    
    .nav-link:hover {
        background: rgba(255,255,255,0.1);
    }
    
    .nav-link.active {
        background: #27ae60 !important;
    }
</style>

<div class="d-flex">
    {{-- SIDEBAR FIXE --}}
    <div class="admin-sidebar text-white p-3">
        <div class="sidebar-nav-wrapper">
            <h5 class="mb-4 text-center">🇹🇬 e-Déclaration TG</h5>
            <nav class="nav flex-column">
                <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">
                    📊 Tableau de bord
                </a>
                <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                    👤 Gestion des Utilisateurs
                </a>
                <a class="nav-link text-white active" href="{{ route('admin.types-pieces.index') }}">
                    🪪 Types de Pièces
                </a>
                <a class="nav-link text-white" href="{{ route('admin.roles.index') }}">
                    🔐 Rôles & Droits
                </a>
                <a class="nav-link text-white" href="#">
                    📈 Statistiques & Rapports
                </a>
            </nav>
        </div>
        
        {{-- Bouton de déconnexion fixe --}}
        <div class="logout-section">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    🚪 Se déconnecter
                </button>
            </form>
        </div>
    </div>

    {{-- CONTENU PRINCIPAL --}}
    <div class="admin-content flex-fill p-4">
        <div class="container-fluid">
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