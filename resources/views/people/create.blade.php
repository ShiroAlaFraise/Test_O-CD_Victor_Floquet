<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer une Personne</title>
</head>
<body>
    <h1>Créer une nouvelle personne</h1>

    <!-- Affichage des messages de validation ou d'erreur -->
    @if($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Formulaire de création -->
    <form action="{{ route('people.store') }}" method="POST">
        @csrf

        <div>
            <label for="first_name">Prénom:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
        </div>

        <div>
            <label for="middle_names">Prénoms intermédiaires (séparés par des virgules):</label>
            <input type="text" id="middle_names" name="middle_names" value="{{ old('middle_names') }}">
        </div>

        <div>
            <label for="last_name">Nom de famille:</label>
            <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
        </div>

        <div>
            <label for="birth_name">Nom de naissance:</label>
            <input type="text" id="birth_name" name="birth_name" value="{{ old('birth_name') }}">
        </div>

        <div>
            <label for="date_of_birth">Date de naissance (YYYY-MM-DD):</label>
            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}">
        </div>

        <div>
            <button type="submit">Créer</button>
        </div>
    </form>

</body>
</html>
