<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de la Personne</title>
</head>
<body>
    <h1>{{ $person->first_name }} {{ $person->last_name }}</h1>
    <p>Date de naissance: {{ $person->date_of_birth }}</p>
    <h2>Enfants</h2>
    <ul>
        @foreach ($children as $child)
            <li>{{ $child->first_name }} {{ $child->last_name }}</li>
        @endforeach
    </ul>
    <h2>Parents</h2>
    <ul>
        @foreach ($parents as $parent)
            <li>{{ $parent->first_name }} {{ $parent->last_name }}</li>
        @endforeach
    </ul>
</body>
</html>
