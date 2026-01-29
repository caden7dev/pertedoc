@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- SIDEBAR --}}
        <div class="col-md-2 bg-dark text-white min-vh-100 p-3">
            <h5 class="mb-4">🇹🇬 e-Déclaration TG</h5>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">📊 Tableau de bord</a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-white active bg-success" href="{{ route('admin.users.index') }}" style="border-radius: 5px;">👤 Gestion des Utilisateurs</a>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0">Gestion des Utilisateurs</h4>
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    ➕ Ajouter un utilisateur
                </button>
            </div>

            {{-- Messages de succès/erreur --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    ✅ {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ❌ {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Statistiques rapides --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card shadow-sm border-start border-primary border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Total Utilisateurs</h6>
                            <h3 class="mb-0">{{ $users->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-start border-danger border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Administrateurs</h6>
                            <h3 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-start border-warning border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Agents</h6>
                            <h3 class="mb-0">{{ $users->where('role', 'agent')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow-sm border-start border-info border-4">
                        <div class="card-body">
                            <h6 class="text-muted">Citoyens</h6>
                            <h3 class="mb-0">{{ $users->where('role', 'user')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Filtres --}}
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('admin.users.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="🔍 Rechercher (nom, email)" value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">Tous les rôles</option>
                                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="agent" {{ request('role') == 'agent' ? 'selected' : '' }}>Agent</option>
                                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Citoyen</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Table des utilisateurs --}}
            <div class="card shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Nom Complet</th>
                                <th>Email</th>
                                <th>Téléphone</th>
                                <th>Rôle</th>
                                <th>Date d'inscription</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->contact ?? 'N/A' }}</td>
                                <td>
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">👑 Admin</span>
                                    @elseif($user->role === 'agent')
                                        <span class="badge bg-warning text-dark">🛡️ Agent</span>
                                    @else
                                        <span class="badge bg-primary">👤 Citoyen</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewUserModal{{ $user->id }}">
                                            👁️ Voir
                                        </button>
                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                            ✏️ Modifier
                                        </button>
                                        @if($user->id !== auth()->id())
                                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                            🗑️ Supprimer
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Modal Voir Utilisateur --}}
                            <div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Détails de l'utilisateur</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table">
                                                <tr>
                                                    <th>Nom complet:</th>
                                                    <td>{{ $user->name }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Email:</th>
                                                    <td>{{ $user->email }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Téléphone:</th>
                                                    <td>{{ $user->contact ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Adresse:</th>
                                                    <td>{{ $user->address ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Date de naissance:</th>
                                                    <td>{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Genre:</th>
                                                    <td>{{ $user->gender === 'male' ? 'Masculin' : 'Féminin' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Nationalité:</th>
                                                    <td>{{ $user->nationality ?? 'N/A' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Rôle:</th>
                                                    <td>{{ ucfirst($user->role) }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Inscrit le:</th>
                                                    <td>{{ $user->created_at->format('d/m/Y à H:i') }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Modifier Utilisateur --}}
                            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Modifier l'utilisateur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Nom complet</label>
                                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Téléphone</label>
                                                    <input type="text" name="contact" class="form-control" value="{{ $user->contact }}">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Rôle</label>
                                                    <select name="role" class="form-select" required>
                                                        <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Citoyen</option>
                                                        <option value="agent" {{ $user->role === 'agent' ? 'selected' : '' }}>Agent</option>
                                                        <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-primary">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Modal Supprimer Utilisateur --}}
                            <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <div class="modal-header bg-danger text-white">
                                                <h5 class="modal-title">⚠️ Confirmer la suppression</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Êtes-vous sûr de vouloir supprimer l'utilisateur <strong>{{ $user->name }}</strong> ?</p>
                                                <p class="text-danger"><small>⚠️ Cette action est irréversible !</small></p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-muted">Aucun utilisateur trouvé</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ajouter Utilisateur --}}
<div class="modal fade" id="addUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">➕ Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nom complet *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email *</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Téléphone</label>
                        <input type="text" name="contact" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe *</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Rôle *</label>
                        <select name="role" class="form-select" required>
                            <option value="user">Citoyen</option>
                            <option value="agent">Agent</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection