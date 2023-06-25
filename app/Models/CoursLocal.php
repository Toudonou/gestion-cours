<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursLocal extends Model
{
    use HasFactory;
    protected $fillable = [
        'intitule',
        'masseHoraire',
        'semestre',
        'filiere',
        'ue_id',
        'enseignant_local_id',
        'directeur_id',
    ];
}
