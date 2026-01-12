<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Agent - e-Déclaration TG</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            margin: 0;
            background: #f1f3f6;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: #0f2a44;
            color: white;
            padding: 20px;
        }

        .sidebar h2 {
            font-size: 18px;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: #cfd8e3;
            text-decoration: none;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 8px;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background: #1e4b7a;
            color: #fff;
        }

        /* Main */
        .main {
            flex: 1;
            padding: 30px;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            padding: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        h3 {
            margin-bottom: 20px;
            color: #0f2a44;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        th {
            background: #f7f9fb;
            color: #333;
        }

        /* Statuts */
        .badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .pending {
            background: #fff3cd;
            color: #856404;
        }

        .validated {
            background: #d4edda;
            color: #155724;
        }

        .rejected {
            background: #f8d7da;
            color: #721c24;
        }

        /* Buttons */
        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-size: 13px;
        }

        .btn-validate {
            background: #28a745;
            color: white;
        }

        .btn-reject {
            background: #dc3545;
            color: white;
        }

        .actions form {
            display: inline-block;
        }

        .topbar {
            margin-bottom: 25px;
            font-size: 20px;
            font-weight: bold;
            color: #0f2a44;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <h2>🇹🇬 Agent Administratif</h2>

        <a href="{{ route('agent.dashboard') }}" class="active">Dashboard</a>
        <a href="#">Utilisateurs</a>
        <a href="#">Rapports</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button style="margin-top:30px;width:100%" class="btn btn-reject">Déconnexion</button>
        </form>
    </div>

    <!-- Main -->
    <div class="main">

        <div class="topbar">
            Gestion des Déclarations
        </div>

        @if(session('success'))
            <p style="color:green;margin-bottom:15px;">✔ {{ session('success') }}</p>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>ID Dossier</th>
                        <th>Type de Pièce</th>
                        <th>Nom du Déclarant</th>
                        <th>Date de Soumission</th>
                        <th>Statut</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pertes as $perte)
                        <tr>
                            <td>{{ $perte->id }}</td>
                            <td>{{ $perte->type_piece }}</td>
                            <td>{{ $perte->first_name }} {{ $perte->last_name }}</td>
                            <td>{{ $perte->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($perte->statut === 'en attente')
                                    <span class="badge pending">En attente</span>
                                @elseif($perte->statut === 'validée')
                                    <span class="badge validated">Validée</span>
                                @else
                                    <span class="badge rejected">Rejetée</span>
                                @endif
                            </td>
                            <td class="actions">
                                @if($perte->statut === 'en attente')
                                    <form method="POST" action="{{ route('agent.perte.valider', $perte) }}">
                                        @csrf
                                        <button class="btn btn-validate">Valider</button>
                                    </form>

                                    <form method="POST" action="{{ route('agent.perte.rejeter', $perte) }}">
                                        @csrf
                                        <button class="btn btn-reject">Rejeter</button>
                                    </form>
                                @else
                                    ✔ Traitée
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center;color:#888">
                                Aucune déclaration trouvée
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
