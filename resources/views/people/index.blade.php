<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Personnes</title>
</head>
<body>
    <h1>Liste des Personnes</h1>
    <a href="{{ route('people.create') }}">Créer une personne</a>
    <ul>
        @foreach ($people as $person)
            <li>{{ $person->first_name }} {{ $person->last_name }}</li>
        @endforeach
    </ul>
</body>
</html>
