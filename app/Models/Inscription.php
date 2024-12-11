<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;
    public function etudiant(){
        return $this->belongsTo(Etudiant::class, 'etudiants_id');

    }
    public function filiere(){
        return $this->belongsTo(Filiere::class, 'filieres_id');


    }
}
