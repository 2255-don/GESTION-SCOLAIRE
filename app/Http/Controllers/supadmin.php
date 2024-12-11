<?php

namespace App\Http\Controllers;

use App\Models\Enseignant;
use App\Models\Etudiant;
use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;

class supadmin extends Controller
{
    //profil
    public function profil($id = null){
       $profil = $id ? Profil::find($id) : null;
       $profils= Profil::all();
    //    $newProfil = new Profil();
       return view('supadmin.profile', compact('profil', 'profils'));

    }

    public function storeprofil(){
        $id = request('id');
        if($id){
            $profil = Profil::find($id);
            $msg = 'modifié';
        }else{
            $profil = new Profil();
            $msg = 'ajouter';
        }

        $profil->libelle = request('libelle');
        $profil->save();
        $profils = Profil::all();
        return redirect()->route('supadmin.profil', compact('profils'))->with('success','profil '.$msg.' avec succes');
    }

    public function delateprofil($id){
        $profil = Profil::findOrFail($id);
        $profil->delete();
        return redirect()->route('supadmin.profil')->with('success','profil suprimé avec succes');;

    }



    //user

    public function user($id = null){
        $user = $id ? User::find($id) : null;
        $profils= Profil::all();
        $users = User::select('id', 'nom', 'prenom', 'email', 'password', 'profils_id', 'etudiants_id', 'enseignants_id')
                       ->with(['profil', 'etudiant', 'enseignant'])
                       ->get();

    // dd($users);

        return view('supadmin.dashboard',compact('users', 'user', 'profils'));

    }

    public function userStore() {
        $id = request('id');
        $profil = Profil::all();

        if($id){
            $user = User::find($id);
            $msg = ' User modifié ';
        }else{
            $user = new User();
            $msg = ' User ajouter ';
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
        $users = User::select('nom','prenom', 'email', 'profils_id')->with('profil')->get();
        return redirect()->route('supadmin.user', compact('users'))->with('success', $msg.'avec succes');
    }

    public function delateUser($id){
        $user = User::findOrFail($id);
        $etudiantId = $user->etudiants_id;
        $enseignantId = $user->enseignants_id;

        if($etudiantId){
            $etudiant = Etudiant::find($etudiantId);
            if($etudiant){
                $etudiant->delete();
            }
        }elseif($enseignantId ){
            $enseignant = Enseignant::find($enseignantId);
            $enseignant->delete();
        }
        $user->delete();
        return redirect()->back()->with('success', 'User suprimé avec succes');
    }

    //numeromatricule
    // public function numeromatricule($id){
    //   $user = User::with('profil')->find($id);
    //   $profil =$user->profil->libelle;
    //   if($profil == 'etudiant'){
    //     $nomPart = substr(strtoupper($user->nom), 0, 1);
    //     $profilPart = substr(strtoupper($user->profil->libelle), 0, 2);
    //     $random = rand(000000, 999999);
    //     $matricule = Strtoupper($nomPart. $profilPart. $random );

    //   }elseif($profil == 'enseignat'){
    //     $nomPart = substr(strtoupper($user->nom), 0, 1);
    //     $profilPart = substr(strtoupper($user->profil->libelle), 0, 2);
    //     $random = rand(000000, 999999);
    //     $matricule = Strtoupper($nomPart. $profilPart. $random );

    //   }

    // }

    // chart
    public function fechtdata(){
        $users = User::select('id', 'nom', 'prenom', 'email', 'password', 'profils_id', 'etudiants_id', 'enseignants_id')
                       ->with(['profil', 'etudiant', 'enseignant'])
                       ->get();
        return response()->json($users);
    }
}

