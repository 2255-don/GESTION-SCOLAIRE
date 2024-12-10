<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model
{
    use HasFactory;
    public function user(){
        return $this->hasMany(User::class);
    }
    public function cour(){
        return $this->hasMany(Cour::class);
    }
}
