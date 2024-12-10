<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;
    public function user(){
        return $this->hasMany(User::class);
    }
    public function inscription(){
        return $this->hasMany(Inscription::class);
    }
    public function note(){
        return $this->hasMany(Note::class);
    }
}
