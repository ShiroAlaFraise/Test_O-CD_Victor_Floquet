<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Degré de Parenté</title>
</head>
<body>
    <h1>Résultat de la recherche de degré de parenté</h1>

    <p><strong>Dégré :</strong> {{ $degree }}</p>
    <p><strong>Chemin :</strong> {{ implode(' -> ', $path) }}</p>
    <p><strong>Nombre de requêtes SQL :</strong> {{ $queryCount }}</p>
    <p><strong>Durée (en ms) :</strong> {{ $duration }} ms</p>

    <!-- Formulaire pour retenter avec d'autres IDs -->
    <form method="POST" action="{{ url('/degre') }}">
        @csrf
        <label for="start_id">ID de départ :</label>
        <input type="number" name="start_id" value="{{ $startId ?? '' }}" required>

        <label for="end_id">ID d'arrivée :</label>
        <input type="number" name="end_id" value="{{ $targetId ?? '' }}" required>

        <button type="submit">Tester avec d'autres IDs</button>
    </form>
</body>
</html>
