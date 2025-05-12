<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Relationship extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'parent_id', 'child_id'
    ];

    // Relation : Un enfant a un parent
    public function parent()
    {
        return $this->belongsTo(Person::class, 'parent_id');
    }

    // Relation : Un parent a un enfant
    public function child()
    {
        return $this->belongsTo(Person::class, 'child_id');
    }

    // Relation : Un créateur de la relation
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
