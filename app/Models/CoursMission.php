<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursMission extends Model
{
    use HasFactory;
    protected $fillable = [
        'intitule',
        'masseHoraire',
        'semestre',
        'filiere',
        'ue_id',
        'enseignant_missionnaire_id',
        'directeur_id',
    ];
}
