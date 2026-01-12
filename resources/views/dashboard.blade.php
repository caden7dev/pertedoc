<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - e-Déclaration TG</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
            font-family: 'Nunito', sans-serif;
        }

        body { 
            display: flex; 
            min-height: 100vh; 
            position: relative;
        }

        /* Arrière-plan avec image */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ asset("images/image3.jpeg") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            z-index: -2;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }

        /* Overlay léger pour lisibilité */
        body::after {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(240, 244, 248, 0.75);
            z-index: -1;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            box-shadow: 4px 0 20px rgba(0,0,0,0.15);
            display: flex;
            flex-direction: column;
            position: relative;
            z-index: 10;
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 2px solid #e0e0e0;
        }

        .sidebar-header h2 { 
            font-size: 1.3rem;
            font-weight: 800;
            display: flex; 
            align-items: center; 
            gap: 0.8rem;
            color: #1e3a5f;
        }

        .sidebar-header span { 
            font-size: 1.8rem;
            background: white;
            padding: 0.3rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .sidebar-nav {
            flex: 1;
            padding: 1.5rem 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            overflow-y: auto;
        }

        .sidebar-nav a {
            text-decoration: none;
            color: #555;
            font-weight: 600;
            padding: 1rem 1.2rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.3s;
            font-size: 1rem;
        }

        .sidebar-nav a:hover,
        .sidebar-nav a.active {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3);
        }

        .sidebar-nav a svg {
            width: 20px;
            height: 20px;
        }

        .sidebar-footer {
            padding: 1.5rem 1rem;
            border-top: 2px solid #e0e0e0;
        }

        .btn-logout {
            width: 100%;
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(231, 76, 60, 0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
        }

        /* Main content */
        .main {
            flex: 1;
            padding: 2.5rem;
            overflow-y: auto;
            position: relative;
            z-index: 1;
        }

        /* Alert */
        .alert {
            padding: 1.2rem;
            border-radius: 12px;
            margin-bottom: 2rem;
            font-size: 1rem;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        /* Header */
        .dashboard-header {
            background: rgba(255, 255, 255, 0.98);
            padding: 2rem;
            border-radius: 20px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            backdrop-filter: blur(15px);
        }

        .welcome {
            font-size: 2rem;
            font-weight: 800;
            color: #1e3a5f;
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: #666;
            font-size: 1rem;
        }

        /* Stats cards */
        .stats { 
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem; 
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.8rem;
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transition: all 0.3s;
            backdrop-filter: blur(15px);
            border: 3px solid transparent;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        }

        .stat-card.green { 
            border-color: #27ae60;
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(46, 204, 113, 0.05));
        }

        .stat-card.yellow { 
            border-color: #f39c12;
            background: linear-gradient(135deg, rgba(243, 156, 18, 0.1), rgba(241, 196, 15, 0.05));
        }

        .stat-card.blue { 
            border-color: #3498db;
            background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(41, 128, 185, 0.05));
        }

        .stat-card h4 {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card p { 
            font-size: 2.5rem;
            font-weight: 800;
            color: #1e3a5f;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        /* Action button */
        .btn-new {
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            padding: 1.2rem 2.5rem;
            border: none;
            border-radius: 15px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            margin-bottom: 2rem;
            transition: all 0.3s;
            box-shadow: 0 6px 20px rgba(39, 174, 96, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
        }

        .btn-new:hover { 
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(39, 174, 96, 0.4);
        }

        /* Table section */
        .table-section {
            background: rgba(255, 255, 255, 0.98);
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            backdrop-filter: blur(15px);
        }

        .table-section h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e3a5f;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        table th, table td { 
            padding: 1.2rem 1.5rem; 
            text-align: left;
        }

        table th { 
            background: #f8f9fa;
            font-weight: 700;
            color: #1e3a5f;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }

        table tr {
            border-bottom: 1px solid #f0f0f0;
            transition: all 0.3s;
        }

        table tr:hover { 
            background: #f8fcff;
        }

        table tr:last-child {
            border-bottom: none;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-badge.pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-badge.validated {
            background: #d4edda;
            color: #155724;
        }

        .status-dot { 
            width: 8px; 
            height: 8px; 
            border-radius: 50%; 
            display: inline-block;
        }

        .status-pending { background: #f39c12; }
        .status-validated { background: #27ae60; }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: #999;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            body {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .main {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>
                <span>🇹🇬</span> 
                e-Déclaration TG
            </h2>
        </div>

        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="active">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Tableau de bord
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Mon Profil
            </a>
            <a href="{{ route('perte.index') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Mes Déclarations
            </a>
            <a href="{{ route('perte.create') }}">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                Nouvelle Déclaration
            </a>
            <a href="#">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Aide
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

    <!-- Main content -->
    <div class="main">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="alert alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        <!-- Header -->
        <div class="dashboard-header">
            <div class="welcome">Bienvenue, {{ $user->name }} 👋</div>
            <div class="welcome-subtitle">Voici un aperçu de vos activités récentes</div>
        </div>

        <!-- Stats -->
        <div class="stats">
            <div class="stat-card green">
                <div class="stat-icon">📄</div>
                <h4>Total Déclarations</h4>
                <p>{{ $totalDeclarations }}</p>
            </div>
            <div class="stat-card yellow">
                <div class="stat-icon">⏳</div>
                <h4>En attente</h4>
                <p>{{ $enAttente }}</p>
            </div>
            <div class="stat-card blue">
                <div class="stat-icon">✅</div>
                <h4>Validées</h4>
                <p>{{ $validees }}</p>
            </div>
        </div>

        <a href="{{ route('perte.create') }}" class="btn-new">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:24px;height:24px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Déclarer une nouvelle perte
        </a>

        <!-- Recent activities -->
        <div class="table-section">
            <h3>
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Mes Activités récentes
            </h3>

            @if($dernieresDeclarations->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Type de pièce</th>
                            <th>Date de déclaration</th>
                            <th>Lieu de perte</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($dernieresDeclarations as $declaration)
                            <tr>
                                <td><strong>{{ $declaration->type_piece }}</strong></td>
                                <td>{{ $declaration->date_declaration ? $declaration->date_declaration->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $declaration->lieu_perte }}</td>
                                <td>
                                    @if($declaration->statut === 'validée')
                                        <span class="status-badge validated">
                                            <span class="status-dot status-validated"></span>
                                            Validée
                                        </span>
                                    @else
                                        <span class="status-badge pending">
                                            <span class="status-dot status-pending"></span>
                                            En attente
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📭</div>
                    <p>Aucune déclaration pour le moment</p>
                    <p style="margin-top: 0.5rem; font-size: 0.9rem;">Cliquez sur le bouton ci-dessus pour créer votre première déclaration</p>
                </div>
            @endif
        </div>
    </div>

</body>
</html>