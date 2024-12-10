<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AccessPlicy
{
    use HandlesAuthorization;
   /** * Détermine si l'utilisateur peut accéder à la page de profil. *
    *
    * @param \App\Models\User $user
    * @return bool
    */

     public function viewProfile(User $user) {
                // dd('superadmin');

        return $user->profil->libelle == 'superadmin'; // Assurez-vous que le champ 'role' existe dans votre modèle User
    }

   /** * Détermine si l'utilisateur peut accéder à la page de profil. *
    *
    * @param \App\Models\User $user
    * @return bool
    */

     public function dashboard(User $user) {
                // dd('superadmin');

        return $user->profil->libelle == 'admin'; // Assurez-vous que le champ 'role' existe dans votre modèle User
    }
}
