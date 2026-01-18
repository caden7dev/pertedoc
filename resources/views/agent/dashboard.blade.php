<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Agent - e-Déclaration TG</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #f0f4f8;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: linear-gradient(180deg, #1e3a5f 0%, #2d5a8c 100%);
            color: white;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(0,0,0,0.2);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h2 {
            font-size: 1.3rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .sidebar-header .badge-role {
            background: #f39c12;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .user-info {
            padding: 1.5rem;
            background: rgba(255,255,255,0.1);
            margin: 1rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-avatar {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
        }

        .user-details h4 {
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }

        .user-details p {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .sidebar-nav {
            flex: 1;
            padding: 1rem;
            overflow-y: auto;
        }

        .sidebar-nav a {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 1rem 1.2rem;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 0.5rem;
            transition: all 0.3s;
            font-weight: 600;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: rgba(255,255,255,0.15);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-nav svg {
            width: 20px;
            height: 20px;
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        .btn-logout {
            width: 100%;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Header */
        .page-header {
            background: linear-gradient(135deg, #27ae60 0%, #2ecc71 100%);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            color: white;
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.3);
        }

        .page-header h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
        }

        .page-header p {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            padding: 1.8rem;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
            transition: all 0.3s;
            border-left: 4px solid;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .stat-card.pending {
            border-color: #f39c12;
        }

        .stat-card.validated {
            border-color: #27ae60;
        }

        .stat-card.rejected {
            border-color: #e74c3c;
        }

        .stat-card.total {
            border-color: #3498db;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.8rem;
        }

        .stat-card h3 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card p {
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e3a5f;
        }

        /* Alerts */
        .alert {
            padding: 1.2rem 1.5rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            font-weight: 600;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-left: 4px solid #27ae60;
        }

        .alert svg {
            width: 24px;
            height: 24px;
        }

        /* Filters */
        .filters {
            background: white;
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .filters-row {
            display: flex;
            gap: 1rem;
            align-items: center;
            flex-wrap: wrap;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #555;
            font-size: 0.9rem;
        }

        .filter-group select {
            width: 100%;
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 0.95rem;
            transition: all 0.3s;
        }

        .filter-group select:focus {
            outline: none;
            border-color: #27ae60;
        }

        /* Table Section */
        .table-section {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        .table-header {
            padding: 1.5rem 2rem;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-bottom: 2px solid #dee2e6;
        }

        .table-header h2 {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1e3a5f;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 1.2rem 1.5rem;
            text-align: left;
        }

        th {
            background: #f8f9fa;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s;
        }

        tr:hover {
            background: #f8fcff;
        }

        /* Status Badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 700;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.validated {
            background: #d4edda;
            color: #155724;
        }

        .status-badge.rejected {
            background: #f8d7da;
            color: #721c24;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
        }

        .status-pending { background: #f39c12; }
        .status-validated { background: #27ae60; }
        .status-rejected { background: #e74c3c; }

        /* Action Buttons */
        .actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-action {
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.85rem;
        }

        .btn-validate {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
        }

        .btn-validate:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(39, 174, 96, 0.3);
        }

        .btn-reject {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
        }

        .btn-reject:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(231, 76, 60, 0.3);
        }

        .btn-view {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }

        .btn-view:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(52, 152, 219, 0.3);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: #999;
        }

        .empty-state-icon {
            font-size: 5rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .filters-row {
                flex-direction: column;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 0.8rem;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>
                🇹🇬 e-Déclaration TG
                <span class="badge-role">AGENT</span>
            </h2>
        </div>

        <div class="user-info">
            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="user-details">
                <h4>{{ auth()->user()->name }}</h4>
                <p>Agent Administratif</p>
            </div>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('agent.dashboard') }}" class="active">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Toutes les déclarations
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Statistiques
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Mon Profil
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:20px;height:20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Se déconnecter
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Page Header -->
        <div class="page-header">
            <h1>Gestion des Déclarations de Perte</h1>
            <p>Validez et gérez les déclarations soumises par les citoyens</p>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card total">
                <div class="stat-icon">📊</div>
                <h3>Total</h3>
                <p>{{ $pertes->count() }}</p>
            </div>
            <div class="stat-card pending">
                <div class="stat-icon">⏳</div>
                <h3>En attente</h3>
                <p>{{ $pertes->where('statut', 'en attente')->count() }}</p>
            </div>
            <div class="stat-card validated">
                <div class="stat-icon">✅</div>
                <h3>Validées</h3>
                <p>{{ $pertes->where('statut', 'validée')->count() }}</p>
            </div>
            <div class="stat-card rejected">
                <div class="stat-icon">❌</div>
                <h3>Rejetées</h3>
                <p>{{ $pertes->where('statut', 'rejetée')->count() }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <div class="filters-row">
                <div class="filter-group">
                    <label>Statut</label>
                    <select id="filterStatus">
                        <option value="">Tous les statuts</option>
                        <option value="en attente">En attente</option>
                        <option value="validée">Validée</option>
                        <option value="rejetée">Rejetée</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Type de pièce</label>
                    <select id="filterType">
                        <option value="">Tous les types</option>
                        <option value="CNI">CNI</option>
                        <option value="Passeport">Passeport</option>
                        <option value="Permis">Permis de conduire</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label>Date</label>
                    <select id="filterDate">
                        <option value="">Toutes les dates</option>
                        <option value="today">Aujourd'hui</option>
                        <option value="week">Cette semaine</option>
                        <option value="month">Ce mois</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header">
                <h2>
                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:24px;height:24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Déclarations récentes
                </h2>
            </div>

            @if($pertes->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>ID Dossier</th>
                            <th>Type de Pièce</th>
                            <th>Nom du Déclarant</th>
                            <th>Date de Soumission</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pertes as $perte)
                            <tr>
                                <td><strong>#{{ str_pad($perte->id, 5, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ $perte->type_piece }}</td>
                                <td>{{ $perte->first_name }} {{ $perte->last_name }}</td>
                                <td>{{ $perte->created_at->format('d/m/Y à H:i') }}</td>
                                <td>
                                    @if($perte->statut === 'en attente')
                                        <span class="status-badge pending">
                                            <span class="status-dot status-pending"></span>
                                            En attente
                                        </span>
                                    @elseif($perte->statut === 'validée')
                                        <span class="status-badge validated">
                                            <span class="status-dot status-validated"></span>
                                            Validée
                                        </span>
                                    @else
                                        <span class="status-badge rejected">
                                            <span class="status-dot status-rejected"></span>
                                            Rejetée
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="actions">
                                        @if($perte->statut === 'en attente')
                                            <form method="POST" action="{{ route('agent.perte.valider', $perte) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-action btn-validate">
                                                    ✓ Valider
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('agent.perte.rejeter', $perte) }}" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn-action btn-reject">
                                                    ✗ Rejeter
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn-action btn-view">
                                                👁 Voir
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <h3>Aucune déclaration trouvée</h3>
                    <p>Il n'y a actuellement aucune déclaration à traiter</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Filtres interactifs
        document.getElementById('filterStatus').addEventListener('change', filterTable);
        document.getElementById('filterType').addEventListener('change', filterTable);
        document.getElementById('filterDate').addEventListener('change', filterTable);

        function filterTable() {
            const statusFilter = document.getElementById('filterStatus').value.toLowerCase();
            const typeFilter = document.getElementById('filterType').value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                const status = row.cells[4].textContent.toLowerCase();
                const type = row.cells[1].textContent.toLowerCase();

                const statusMatch = !statusFilter || status.includes(statusFilter);
                const typeMatch = !typeFilter || type.includes(typeFilter);

                row.style.display = (statusMatch && typeMatch) ? '' : 'none';
            });
        }

        // Confirmation avant validation/rejet
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                const button = this.querySelector('button[type="submit"]');
                const action = button.textContent.includes('Valider') ? 'valider' : 'rejeter';
                
                if (!confirm(`Êtes-vous sûr de vouloir ${action} cette déclaration ?`)) {
                    e.preventDefault();
                }
            });
        });
    </script>

</body>
</html>