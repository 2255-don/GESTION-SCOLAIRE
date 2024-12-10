<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Planing;
use App\Models\Profil;
use App\Models\User;
use App\Models\Inscription;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function inscription($id = null){
        $user = $id ? User::find($id) : null;
        $profils= Profil::select('id', 'libelle')
                        //  ->where('libelle', '=','etudiant')
                         ->orwhere('libelle', '=','professeur')
                         ->get();
        $users = User::select('id', 'nom', 'prenom', 'email', 'enseignants_id', 'etudiants_id', 'profils_id')
                       ->with(['enseignant', 'etudiant','profil'])
                    //    ->where('profils_id', '=', 4)
                       ->orwhere('profils_id', '=', 5)
                       ->get();
                       //dd($users);
        return view('admin.adminDashboard',compact('user', 'users', 'profils'));


    }

    public function inscriptionStorre(){
        $id = request('id');
        if($id){
            $user = User::find($id);
            $msg = 'user modifier avec succes';
        }else{
            $user = new User();
            $msg = 'user cree avec succes';
        }

        $user->nom = request('nom');
        $user->prenom = request('prenom');
        $user->email = request('email');
        $user->password = request('password');
        $user->profils_id = request('profil');
        if(!$id){
          if( $user->profils_id == 4 ){
            $profil = 'etudiant';
            $nomPart = substr(strtoupper($user->nom), 0, 1);
            $profilPart = substr(strtoupper($profil), 0, 2);
            $random = rand(000000, 999999);
            $matricule = Strtoupper($nomPart. $profilPart. $random );
            $etudiant = new Etudiant();
            $etudiant->matricule = $matricule;
            $etudiant->save();
            $etudiantId = $etudiant->id;
            $user->etudiants_id = $etudiantId;
            $user->save();
          }elseif($user->profils_id == 5){
            $profil = 'enseignant';
            $nomPart = substr(strtoupper($user->nom), 0, 1);
            $profilPart = substr(strtoupper($profil), 0, 2);
            $random = rand(000000, 999999);
            $matricule = Strtoupper($nomPart. $profilPart. $random );
            $enseignant =new Enseignant();
            $enseignant->matricule= $matricule;
            $enseignant->save();
            $enseignantId = $enseignant->id;
            $user->enseignants_id = $enseignantId;
            $user->save();
          }
        }
        $user->save();
        return redirect()->back()->with('message'.$msg);
    }

    public function inscriptionDelete($id){
        $user = User::findOrFail($id);
        $etudiantId = $user->etudiants_id;
        $enseignantId = $user->enseignants_id;
        $user->delete();

        if($etudiantId){
            $etudiant = Etudiant::find($etudiantId);
            // $cour = C
            if($etudiant){
                $etudiant->delete();
            }
        }elseif($enseignantId ){

            $cours = Cour::where('enseignants_id', $enseignantId)->get();
            // dd($cours);
            if($cours){
            //supression du planing
                foreach ($cours as $cour) {
                    $planings = Planing::where('cours_id',$cour->id)->get();
                    if($planings){
                        foreach ($planings as $planing) {
                            $planing->delete();
                        }
                     $cour->delete();

                    }
                }
            }
            // Supprimer chaque cours
            // foreach ($cours as $cour) {
            // }
            $enseignant = Enseignant::find($enseignantId);
            $enseignant->delete();

        }
        return redirect()->back()->with('success', 'User suprimé avec succes');
    }


    public function Etudiant($id = null){
        $user = $id ? User::find($id) : null;
        $filieres= Filiere::all();
        $profils= Profil::select('id', 'libelle')
                         ->where('libelle', '=','etudiant')
                        //  ->orwhere('libelle', '=','professeur')
                         ->get();
        $users = User::select('users.id as userId', 'users.nom', 'users.prenom', 'users.email', 'users.etudiants_id', 'users.profils_id', 'etudiants.matricule', 'inscriptions.satut', 'filieres.nom as filiername', 'profils.libelle')
                       ->join('profils', 'profils.id', '=', 'users.profils_id')
                       ->join('etudiants', 'etudiants.id', '=', 'users.etudiants_id')
                       ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiants_id')
                       ->join('filieres', 'filieres.id', '=', 'inscriptions.filieres_id')
                    //    ->with(['enseignant', 'etudiant','profil'])
                       ->where('profils_id', '=', 4)
                    //    ->orwhere('profils_id', '=', 5)
                       ->get();
                    //    dd($users);
        return view('admin.etudiant',compact('user', 'users', 'profils', 'filieres'));


    }

    public function StoreEtudiant(){
        $id = request('id');
        if($id){
            $user = User::find($id);
            $msg = 'user modifier avec succes';
        }else{
            $user = new User();
            $msg = 'user cree avec succes';
        }

        $user->nom = request('nom');
        $user->prenom = request('prenom');
        $user->email = request('email');
        $user->password = request('password');
        $user->profils_id = request('profil');
        if(!$id){
          if( $user->profils_id == 4 ){
            $profil = 'etudiant';
            $nomPart = substr(strtoupper($user->nom), 0, 1);
            $profilPart = substr(strtoupper($profil), 0, 2);
            $random = rand(000000, 999999);
            $matricule = Strtoupper($nomPart. $profilPart. $random );
            $etudiant = new Etudiant();
            $etudiant->matricule = $matricule;
            $etudiant->save();
            $etudiantId = $etudiant->id;

            //storeInscription
            $inscription = new inscription();
            $inscription->satut = 'inscrit';
            $inscription->etudiants_id = $etudiantId;
            $inscription->filieres_id = request('filiere');
            $inscription->save();
            //storeUser
            $user->etudiants_id = $etudiantId;
            $user->save();
          }
        }
        $user->save();
        return redirect()->back()->with('message'.$msg);

    }



}
