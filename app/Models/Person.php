<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;


class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'first_name', 'last_name', 'birth_name', 'middle_names', 'date_of_birth'
    ];

    // Relation : Une personne a plusieurs enfants
    public function children()
    {
        return $this->hasMany(Relationship::class, 'parent_id');
    }

    // Relation : Une personne a plusieurs parents
    public function parents()
    {
        return $this->hasMany(Relationship::class, 'child_id');
    }

    // Relation : Une personne a un utilisateur créateur
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public static function getDegreeWith($startId, $targetId)
{
    $startTime = microtime(true);
    $queryCount = 0;

    if ($startId == $targetId) {
        return [0, [$startId], 0, 0];
    }

    $visited = [];
    $queue = [[$startId, [$startId]]];

    while (!empty($queue)) {
        // Étape : construire un seul gros IN ()
        $currentIds = array_column($queue, 0); // ids actuels
        $paths = array_column($queue, 1); // chemins associés
        $queue = []; // reset queue pour prochaine itération

        // Requête groupée
        $placeholders = implode(',', array_fill(0, count($currentIds), '?'));
        $bindings = array_merge($currentIds, $currentIds); // pour parent_id et child_id

        $results = DB::select("
            SELECT parent_id, child_id FROM relationships
            WHERE parent_id IN ($placeholders) OR child_id IN ($placeholders)
        ", $bindings);
        $queryCount++;

        $neighbors = [];

        foreach ($results as $relation) {
            // chaque relation est bidirectionnelle
            $neighbors[$relation->parent_id][] = $relation->child_id;
            $neighbors[$relation->child_id][] = $relation->parent_id;
        }

        foreach ($currentIds as $idx => $currentId) {
            $currentPath = $paths[$idx];
            $currentNeighbors = $neighbors[$currentId] ?? [];

            foreach ($currentNeighbors as $neighborId) {
                if (in_array($neighborId, $visited)) continue;

                $newPath = [...$currentPath, $neighborId];

                if ($neighborId == $targetId) {
                    $duration = round((microtime(true) - $startTime) * 1000, 2);
                    return [count($newPath) - 1, $newPath, $queryCount, $duration];
                }

                $visited[] = $neighborId;
                $queue[] = [$neighborId, $newPath];
            }
        }
    }

    $duration = round((microtime(true) - $startTime) * 1000, 2);
    return [-1, [], $queryCount, $duration];
}


}
