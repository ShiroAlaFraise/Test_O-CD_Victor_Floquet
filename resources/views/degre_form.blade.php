<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Degré de Parenté</title>
</head>
<body>
    <h1>Entrez les IDs pour calculer le degré de parenté</h1>

    <form method="POST" action="{{ url('/degre') }}">
        @csrf
        <label for="start_id">ID de départ :</label>
        <input type="number" name="start_id" required>

        <label for="end_id">ID d'arrivée :</label>
        <input type="number" name="end_id" required>

        <button type="submit">Calculer</button>
    </form>
</body>
</html>
