<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnseignantMissionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'universite',
        'email',
        'password',
        'directeur_id'
    ];
}
