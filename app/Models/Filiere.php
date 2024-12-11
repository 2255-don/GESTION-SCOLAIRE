<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;
    public function planing() {
        return $this->hasMany(Planing::class);
    }
    public function inscription() {
        return $this->hasMany(Inscription::class);
    }
}
