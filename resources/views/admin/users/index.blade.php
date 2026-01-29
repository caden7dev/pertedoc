@extends('layouts.app')

@section('title', 'Gestion des Utilisateurs')

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

    /* Cartes utilisateurs - Style similaire à la capture */
    .user-card {
        background: white;
        border-radius: 0;
        padding: 0;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
        overflow: hidden;
    }

    .user-card-header {
        background: #f8f9fa;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #e0e0e0;
    }

    .user-header-left {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .user-id-badge {
        background: #3498db;
        color: white;
        padding: 5px 15px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .user-name-header {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .user-email-header {
        color: #666;
        font-size: 0.95rem;
    }

    .user-role-badge {
        padding: 6px 15px;
        border-radius: 3px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .user-actions-header {
        display: flex;
        gap: 8px;
    }

    .action-btn-header {
        padding: 6px 12px;
        border-radius: 5px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 0.9rem;
    }

    .user-details-body {
        padding: 25px 30px;
        background: white;
    }

    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        row-gap: 15px;
    }

    .detail-row {
        display: flex;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 10px;
    }

    .detail-label-col {
        font-weight: 600;
        color: #2c3e50;
        width: 180px;
        flex-shrink: 0;
    }

    .detail-value-col {
        color: #555;
        flex: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .details-grid {
            grid-template-columns: 1fr;
        }
        
        .user-card-header {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }
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
                <a class="nav-link text-white active" href="{{ route('admin.users.index') }}">
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
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-start border-primary border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Total Utilisateurs</h6>
                            <h3 class="mb-0">{{ $users->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-start border-danger border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Administrateurs</h6>
                            <h3 class="mb-0">{{ $users->where('role', 'admin')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-start border-warning border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Agents</h6>
                            <h3 class="mb-0">{{ $users->where('role', 'agent')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="card shadow-sm border-start border-info border-4 h-100">
                        <div class="card-body">
                            <h6 class="text-muted mb-2">Citoyens</h6>
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
                        <div class="col-md-5">
                            <button type="submit" class="btn btn-primary">Filtrer</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Réinitialiser</a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Cartes Utilisateurs --}}
            <div class="users-list">
                @forelse($users as $user)
                <div class="user-card">
                    {{-- Header de la carte --}}
                    <div class="user-card-header">
                        <div class="user-header-left">
                            <span class="user-id-badge">{{ $user->id }}</span>
                            <div>
                                <div class="user-name-header">{{ $user->name }}</div>
                                <div class="user-email-header">{{ $user->email }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div>
                                @if($user->role === 'admin')
                                    <span class="user-role-badge bg-danger text-white">👑 Admin</span>
                                @elseif($user->role === 'agent')
                                    <span class="user-role-badge bg-warning text-dark">🛡️ Agent</span>
                                @else
                                    <span class="user-role-badge bg-primary text-white">👤 Citoyen</span>
                                @endif
                            </div>
                            <div class="user-actions-header">
                                <button type="button" class="action-btn-header btn-info text-white" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                    ✏️ Modifier
                                </button>
                                @if($user->id !== auth()->id())
                                <button type="button" class="action-btn-header btn-danger text-white" data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                    🗑️ Supprimer
                                </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Corps de la carte avec détails --}}
                    <div class="user-details-body">
                        <div class="details-grid">
                            <div class="detail-row">
                                <span class="detail-label-col">Nom complet:</span>
                                <span class="detail-value-col">{{ $user->name }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Email:</span>
                                <span class="detail-value-col">{{ $user->email }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Téléphone:</span>
                                <span class="detail-value-col">{{ $user->contact ?? 'N/A' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Adresse:</span>
                                <span class="detail-value-col">{{ $user->address ?? 'N/A' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Date de naissance:</span>
                                <span class="detail-value-col">{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Genre:</span>
                                <span class="detail-value-col">{{ $user->gender === 'male' ? 'Masculin' : ($user->gender === 'female' ? 'Féminin' : 'N/A') }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Nationalité:</span>
                                <span class="detail-value-col">{{ $user->nationality ?? 'N/A' }}</span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Rôle:</span>
                                <span class="detail-value-col">
                                    @if($user->role === 'admin')
                                        <span class="badge bg-danger">Admin</span>
                                    @elseif($user->role === 'agent')
                                        <span class="badge bg-warning text-dark">Agent</span>
                                    @else
                                        <span class="badge bg-primary">Citoyen</span>
                                    @endif
                                </span>
                            </div>

                            <div class="detail-row">
                                <span class="detail-label-col">Inscrit le:</span>
                                <span class="detail-value-col">{{ $user->created_at->format('d/m/Y à H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Modal Modifier --}}
                <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                                @csrf
                                @method('PUT')
                                <div class="modal-header bg-warning">
                                    <h5 class="modal-title">✏️ Modifier l'utilisateur</h5>
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

                {{-- Modal Supprimer --}}
                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
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
                <div class="alert alert-info">
                    <p class="mb-0">Aucun utilisateur trouvé</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Modal Ajouter Utilisateur --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">➕ Ajouter un utilisateur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
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