<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\Filiere;
use Illuminate\Http\Request;

class Filieres extends Controller
{
    public function filiere($id = null){
        $filiere = $id ? Filiere::find($id) : null;
        // $cours = Cour::select('cours.id as cId','cours.nom as courname', 'users.nom as username','users.prenom as userfirstname' , 'enseignants.matricule')->join('enseignants', 'cours.enseignants_id', '=', 'enseignants.id')->join('users', 'users.enseignants_id', '=', 'enseignants.id')->get();
        $filieres = Filiere::select('id', 'nom', 'statut', 'niveau' )->get();
        return view('admin.filiere', compact('filiere', 'filieres'));
    }

    public function filiereStore(){
        $id = request('id');
        if($id){
            $filiere = Filiere::find($id);
            $msg = 'filiere modifier avec succes';
        }else{
            $filiere = new Filiere();
            $msg = 'filiere ajouter avec succes';
        }

        $filiere->nom = request('nom');
        $filiere->niveau = request('niveau');
        // $filiere->cours_id = request('cour');
        $filiere->save();
        return redirect()->back()->with('success'.$msg);
    }

    public function delateFiliere($id){
        $filiere = Filiere::finOrFail($id);
        $filiere->delete();
        return redirect()->back()->with('success','message suprimé avec succes');
    }

    // public function delateFiliere()
}
