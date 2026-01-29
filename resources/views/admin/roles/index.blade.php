@extends('layouts.app')

@section('title', 'Gestion des Rôles')

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
                    <a class="nav-link text-white" href="{{ route('admin.types-pieces.index') }}">🪪 Types de Pièces</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white active" href="{{ route('admin.roles.index') }}" style="background: rgba(255,255,255,0.1); border-radius: 5px;">🔐 Rôles & Droits</a>
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
            <h4 class="mb-4">Gestion des Rôles et Droits</h4>

            <div class="card shadow-sm">
                <div class="card-header">
                    <strong>Rôles disponibles</strong>
                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Rôle</th>
                                <th>Description</th>
                                <th>Permissions</th>
                                <th>Nombre d'utilisateurs</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><span class="badge bg-danger">Admin</span></td>
                                <td>Administrateur système</td>
                                <td>
                                    <small>
                                        ✅ Gestion utilisateurs<br>
                                        ✅ Gestion rôles<br>
                                        ✅ Paramètres système<br>
                                        ✅ Validation déclarations
                                    </small>
                                </td>
                                <td>{{ \App\Models\User::where('role', 'admin')->count() }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-warning text-dark">Agent</span></td>
                                <td>Agent administratif</td>
                                <td>
                                    <small>
                                        ✅ Validation déclarations<br>
                                        ✅ Consultation dossiers<br>
                                        ✅ Génération attestations
                                    </small>
                                </td>
                                <td>{{ \App\Models\User::where('role', 'agent')->count() }}</td>
                            </tr>
                            <tr>
                                <td><span class="badge bg-primary">User</span></td>
                                <td>Citoyen / Utilisateur standard</td>
                                <td>
                                    <small>
                                        ✅ Création déclarations<br>
                                        ✅ Suivi des dossiers<br>
                                        ✅ Téléchargement attestations
                                    </small>
                                </td>
                                <td>{{ \App\Models\User::where('role', 'user')->count() }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="mt-4 alert alert-info">
                        <strong>ℹ️ Information :</strong> La gestion avancée des permissions sera disponible dans une prochaine version.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection