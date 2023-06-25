<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantLocal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'vacataire',
        'email',
        'password',
        'directeur_id'
    ];
}
