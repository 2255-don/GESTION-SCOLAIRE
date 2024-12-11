<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bulletin extends Model
{
    use HasFactory;

    public function note(){
        return $this->belongsTo(Note::class, 'notes_id');
    }

    public function etudiant(){
        return $this->belongsTo(Etudiant::class, 'etudiants_id');
    }
}
