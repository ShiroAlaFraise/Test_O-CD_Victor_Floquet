<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    public function index()
    {
        // On récupère toutes les personnes avec leur créateur (relation `creator` définie dans Person)
        $people = Person::with('creator')->get();
    
        // Retourner une vue et passer les données à la vue
        return view('people.index', compact('people'));
    }

    public function show($id)
    {
        // On récupère la personne spécifique avec ses enfants et ses parents
        $person = Person::with(['children', 'parents'])->findOrFail($id);

        // Extraire les personnes à partir des relations
        $children = $person->children->map(function ($relationship) {
            return $relationship->child; // Enfant associé dans la relation
        });

        $parents = $person->parents->map(function ($relationship) {
            return $relationship->parent; // Parent associé dans la relation
        });

        // Retourner une vue et passer les données à la vue
        return view('people.show', compact('person', 'children', 'parents'));
    }


    public function create()
    {   
        // Retourner une vue pour le formulaire de création
        return view('people.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
        ]);

        // Traitement des données avant l'insertion
        $first_name = ucfirst(strtolower($request->first_name)); // Première lettre en majuscule
        $last_name = strtoupper($request->last_name); // Tout en majuscule
        $birth_name = strtoupper($request->birth_name ?? $last_name); // Si birth_name non renseigné, utiliser last_name
        $middle_names = $request->middle_names
            ? implode(' ', array_map('ucwords', explode(',', strtolower($request->middle_names)))) // Chaque prénom en majuscule
            : null;
        $date_of_birth = $request->date_of_birth ? date('Y-m-d', strtotime($request->date_of_birth)) : null; // Format YYYY-MM-DD

        // Créer une nouvelle personne avec les données formatées et validées
        $person = Person::create([
            'first_name' => $first_name,
            'last_name' => $last_name,
            'birth_name' => $birth_name,
            'middle_names' => $middle_names,
            'date_of_birth' => $date_of_birth,
            'created_by' => auth()->id(), // Utilisateur authentifié
        ]);
        return redirect()->route('people.index')->with('success', 'Personne créée avec succès!');
    }
}
