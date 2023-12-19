<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formation_Utilisateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'liste_candidature',
        'statut_candidature',
        
    ];
}