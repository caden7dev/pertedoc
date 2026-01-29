@extends('layouts.app')

@section('title', 'Tableau de bord - Administrateur Général')

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
                <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}">
                    📊 Tableau de bord
                </a>
                <a class="nav-link text-white" href="{{ route('admin.users.index') }}">
                    👤 Gestion des Utilisateurs
                </a>
                <a class="nav-link text-white" href="{{ route('admin.types-pieces.index') }}">
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
            <h4 class="mb-4">Tableau de bord Administrateur Général</h4>

            {{-- STAT CARDS --}}
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6>Utilisateurs Totaux</h6>
                            <h3>{{ $stats['users'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6>Types de Pièces Actifs</h6>
                            <h3>{{ $stats['types_pieces'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6>Rôles Définis</h6>
                            <h3>{{ $stats['roles'] }}</h3>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <h6>Déclarations</h6>
                            <h3>{{ $stats['pertes'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- GESTION UTILISATEURS --}}
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Derniers Utilisateurs</strong>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Rôle</th>
                                    <th>Date d'inscription</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if($user->role === 'admin')
                                            <span class="badge bg-danger">Admin</span>
                                        @elseif($user->role === 'agent')
                                            <span class="badge bg-warning text-dark">Agent</span>
                                        @else
                                            <span class="badge bg-primary">Citoyen</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- TYPES DE PIÈCES ET STATS --}}
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">Gestion des Types de Pièces</div>
                        <div class="card-body">
                            @if($typesPieces->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        @foreach($typesPieces as $type)
                                        <tr>
                                            <td>{{ $type->nom }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-secondary">Éditer</button>
                                                <button class="btn btn-sm btn-danger">Supprimer</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">Aucun type de pièce enregistré</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- STATISTIQUES --}}
                <div class="col-md-6 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-header">Statistiques d'Utilisation</div>
                        <div class="card-body">
                            <canvas id="statsChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chart JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
new Chart(document.getElementById('statsChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($chart['labels']) !!},
        datasets: [{
            label: 'Déclarations',
            data: {!! json_encode($chart['data']) !!},
            backgroundColor: 'rgba(39, 174, 96, 0.6)',
            borderColor: 'rgba(39, 174, 96, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection