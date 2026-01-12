<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de Déclaration de Perte</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background: #e9eff4;
            padding: 2rem;
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

        .container {
            max-width: 1300px;
            margin: auto;
            background: #fff;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 15px 40px rgba(0,0,0,.12);
        }

        h1 {
            text-align: center;
            margin-bottom: 3rem;
            color: #090a0aff;
            font-size: 3rem;
        }

        .section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-weight: 700;
            margin-bottom: 1rem;
            color: #1e8449;
            font-size: 1.8rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.1rem;
           
           
        }

        label {
            font-weight: 600;
            font-size: 1.4rem;
        }

        input, select, textarea {
            width: 100%;
            padding: 0.9rem;
            border-radius: 10px;
            border: 1px solid #dcdcdc;
            font-size: 1.3rem;
        }
        textarea {
            resize: none;
        }

        .full {
            grid-column: span 2;
        }

        .checkbox {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            margin-top: 1rem;
            font-size: 1.7rem;
        }

        .submit-btn {
            background: #1e8449;
            color: white;
            padding: 1rem 2rem;
            border-radius: 12px;
            border: none;
            font-weight: 900;
            cursor: pointer;
            display: block;
            margin: 3rem auto 0;
            font-size: 1.3rem;
        }

        .submit-btn:hover {
            background: #186a3b;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 1rem;
            border-radius: 10px;
            margin-bottom: 1rem;
        }
        
        
    </style>
</head>

<body>

<div class="container">

    <h1>Formulaire de Déclaration de Perte</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('perte.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- 1. Informations du déclarant -->
        <div class="section">
            <div class="section-title">1. Informations du déclarant</div>

            <div class="grid">
                <div>
                    <label>Nom</label>
                    <input type="text" name="last_name" required>
                </div>

                <div>
                    <label>Prénom(s)</label>
                    <input type="text" name="first_name" required>
                </div>

                <div>
                    <label>Numéro de téléphone</label>
                    <input type="text" name="contact" required>
                </div>

                <div>
                    <label>Adresse e-mail</label>
                    <input type="email" name="email" required>
                </div>
            </div>
        </div>

        <!-- 2. Informations sur la pièce perdue -->
        <div class="section">
            <div class="section-title">2. Informations sur la pièce perdue</div>

            <div class="grid">
                <div>
                    <label>Type de pièce</label>
                    <select name="type_piece" required>
                        <option value="">-- Sélectionner --</option>
                        <option value="CNI">Carte Nationale d’Identité</option>
                        <option value="Passeport">Passeport</option>
                        <option value="Permis">Permis de conduire</option>
                    </select>
                </div>

                <div>
                    <label>Numéro de la pièce</label>
                    <input type="text" name="numero_piece">
                </div>

                <div>
                    <label>Date de délivrance</label>
                    <input type="date" name="date_delivrance">
                </div>

                <div>
                    <label>Autorité de délivrance</label>
                    <input type="text" name="autorite_delivrance">
                </div>
            </div>
        </div>

        <!-- 3. Date et circonstances -->
        <div class="section">
            <div class="section-title">3. Détails de la perte</div>

            <div class="grid">
                <div>
                    <label>Date de la perte</label>
                    <input type="date" name="date_perte" required>
                </div>

                <div>
                    <label>Lieu de la perte</label>
                    <input type="text" name="lieu_perte" required>
                </div>

                <div class="full">
                    <label>Circonstances de la perte</label>
                    <textarea name="circonstances" rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- 4. Justificatifs -->
        <div class="section">
            <div class="section-title">4. Justificatifs</div>

            <div class="grid">
                <div>
                    <label>Copie de la pièce (si existante)</label>
                    <input type="file" name="copie_piece">
                </div>

                <div>
                    <label>Déclaration de vol (police)</label>
                    <input type="file" name="declaration_vol">
                </div>

                <div class="full">
                    <label>Photo ou document complémentaire</label>
                    <input type="file" name="document_complementaire">
                </div>
            </div>
        </div>

        <!-- 5. Confirmation -->
        <div class="checkbox">
            <input type="checkbox" required>
            <label>Je certifie sur l’honneur l’exactitude des informations fournies.</label>
        </div>

        <button type="submit" class="submit-btn">Soumettre la déclaration</button>

    </form>

</div>

</body>
</html>
