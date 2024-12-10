<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;
    public function planing(){
        return $this->hasMany(Planing::class);
    }
    public function enseignant(){
        return $this->belongsTo(Enseignant::class, 'enseignants_id');
    }

    public function note(){
        return $this->hasMany(Note::class);
    }
}
