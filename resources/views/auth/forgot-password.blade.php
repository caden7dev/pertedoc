<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mot de passe oublié - e-Déclaration TG</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: linear-gradient(135deg, #5a8dc4 0%, #7ba8d1 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            max-width: 450px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h2 {
            color: #1e3a5f;
            text-align: center;
            margin-bottom: 2rem;
        }
        input {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
        }
        button {
            width: 100%;
            padding: 1rem;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
        }
        button:hover {
            background-color: #229954;
        }
        .alert {
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }
        .alert-success { background-color: #d4edda; color: #155724; }
        .alert-error { background-color: #f8d7da; color: #721c24; }
        a { color: #27ae60; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Mot de passe oublié</h2>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        @if(session('reset_link'))
    <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg break-all">
        <p>Lien de réinitialisation généré :</p>
        <a href="{{ session('reset_link') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">
            {{ session('reset_link') }}
        </a>
    </div>
@endif


        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <input type="email" name="email" placeholder="Votre email" required>
            <button type="submit">Envoyer le lien de réinitialisation</button>
        </form>

        <p style="text-align:center; margin-top:1rem;">
            <a href="{{ route('login') }}">Retour à la connexion</a>
        </p>
    </div>
</body>
</html>
