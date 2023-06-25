<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTd extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom', 'chemin', 'type_cours', 'cours_id', 'enseignant_id',
    ];
}
