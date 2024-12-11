<?php

namespace App\Http\Controllers;

use App\Models\Cour;
use App\Models\User;
use Illuminate\Http\Request;

class Cours extends Controller
{
    public function Cour($id = null){
        $users= User:: select('users.id','users.nom', 'users.prenom', 'enseignants.id as ids')->join('profils', 'users.profils_id', '=', 'profils.id')->join('enseignants', 'enseignants.id', 'users.enseignants_id')->where('profils.libelle', 'professeur')->get();
        $cour = $id ? Cour::find($id) : null;
        $cours = Cour::select('cours.id as cId','cours.nom as courname', 'users.nom as username','users.prenom as userfirstname' , 'enseignants.matricule')->join('enseignants', 'cours.enseignants_id', '=', 'enseignants.id')->join('users', 'users.enseignants_id', '=', 'enseignants.id')->get();
        // dd($cours);
        return view('admin.cour', compact('cour', 'cours', 'users'));
    }

    public function courStore(){
        $id = request('id');

        if($id){
            $cour = Cour::find($id);
            $msg = 'cour modifié  avec success';
        }else{
            $cour = new Cour();
            $msg = 'cour ajouter avec success';
        }

        $cour->nom = request('nom');
        $cour->enseignants_id = request('prof');

        $cour->save();

        return redirect()->back()->with('success' .$msg);
    }

    public function delateCour($id){
        $cour= Cour::findOrFail($id);
        $cour->delete();
        return redirect()->back()->with('success', 'cour suprimé avec succes');
    }


}
