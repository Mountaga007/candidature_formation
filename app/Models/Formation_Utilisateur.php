<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Formation_Utilisateur extends Model
{
    use HasFactory;

    protected $fillable = [
        'statut_candidature',
        'id_formation',
        'id_user'
    ];

    public function formation_user()
    {
        return $this->hasMany(Formation::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class, 'id_formation');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
}