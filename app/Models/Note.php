<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;
    public function etudiant(){
        return $this->belongsTo(Etudiant::class, 'etudiants_id');

    }
    public function enseignant(){
        return $this->belongsTo(Enseignant::class, 'enseignants_id');

    }
    public function cour(){
        return $this->belongsTo(Cour::class, 'cours_id');

    }
}
