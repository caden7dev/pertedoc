@extends('layouts.app')

@section('title', 'Tableau de bord - Administrateur Général')

@section('content')
<div class="container-fluid">

<div class="row">
    {{-- SIDEBAR --}}
    <div class="col-md-2 bg-dark text-white min-vh-100 p-3" style="position: relative;">
        <h5 class="mb-4">🇹🇬 e-Déclaration TG</h5>
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
                <a class="nav-link text-white active" href="{{ route('admin.dashboard') }}" style="background: rgba(255,255,255,0.1); border-radius: 5px;">📊 Tableau de bord</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.users.index') }}">👤 Gestion des Utilisateurs</a>
            </li>
            <li class="nav-item mb-2">
                <a class="nav-link text-white" href="{{ route('admin.types-pieces.index') }}">🪪 Types de Pièces</a>
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

        <h4 class="mb-4">Tableau de bord Administrateur Général</h4>

        {{-- STAT CARDS --}}
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6>Utilisateurs Totaux</h6>
                        <h3>{{ $stats['users'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6>Types de Pièces Actifs</h6>
                        <h3>{{ $stats['types_pieces'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6>Rôles Définis</h6>
                        <h3>{{ $stats['roles'] }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6>Déclarations</h6>
                        <h3>{{ $stats['pertes'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        {{-- GESTION UTILISATEURS --}}
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between">
                <strong>Derniers Utilisateurs</strong>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">Voir tout</a>
            </div>
            <div class="card-body table-responsive">
                <table class="table">
                    <thead>
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

        {{-- TYPES DE PIÈCES --}}
        <div class="row">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header">Gestion des Types de Pièces</div>
                    <div class="card-body">
                        @if($typesPieces->count() > 0)
                            <table class="table">
                                @foreach($typesPieces as $type)
                                <tr>
                                    <td>{{ $type->nom }}</td>
                                    <td>
                                        <a class="btn btn-sm btn-secondary">Éditer</a>
                                        <a class="btn btn-sm btn-danger">Supprimer</a>
                                    </td>
                                </tr>
                                @endforeach
                            </table>
                        @else
                            <p class="text-muted">Aucun type de pièce enregistré</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- STATISTIQUES --}}
            <div class="col-md-6">
                <div class="card shadow-sm">
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