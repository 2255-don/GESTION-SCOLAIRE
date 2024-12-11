<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planing extends Model
{
    use HasFactory;
    public function filiere(){
        return $this->belongsTo(Filiere::class, 'filieres_id');
    }
    public function cour(){
        return $this->belongsTo(Cour::class, 'cours_id');
    }
}
