<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;

use App\Models\Cour;
use App\Models\Filiere;
use App\Models\Planing;
use Illuminate\Http\Request;

class PlaningController extends Controller
{
    public function planing($id = null){
        $planing = $id ? Planing::find($id) : null;
        $filieres = Filiere::all();

        $cours = Cour::select('cours.id as cId','cours.nom as courname', 'users.nom as username','users.prenom as userfirstname' , 'enseignants.matricule')
                       ->join('enseignants', 'cours.enseignants_id', '=', 'enseignants.id')
                       ->join('users', 'users.enseignants_id', '=', 'enseignants.id')
                       ->get();

        $jours = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi'];
        $emploisDuTemps = [];
        $niveaux = collect(); // Collection pour stocker les niveaux uniques
        foreach ($jours as $jour) {
            $coursPlaning = Planing::select( 'cours.id as cId', 'cours.nom as courname', 'users.nom as username', 'users.prenom as userfirstname', 'enseignants.matricule', 'planings.id as pId', 'planings.jours', 'planings.date_debut', 'planings.date_fin', 'filieres.niveau', 'filieres.nom as filiere' )
                                     ->join('cours', 'planings.cours_id', '=', 'cours.id')
                                     ->join('enseignants', 'cours.enseignants_id', '=', 'enseignants.id')
                                     ->join('users', 'users.enseignants_id', '=', 'enseignants.id')
                                     ->join('filieres', 'planings.filieres_id', '=', 'filieres.id')
                                     ->where('planings.jours', $jour)
                                     ->get();
                                     $emploisDuTemps[$jour] = $coursPlaning;
                                     // Ajouter les niveaux uniques à la collection
                                    //  $emploisDuTemps[$jour] = $coursPlaning;
                                     // Ajouter les niveaux et filières uniques à la collection
            $niveaux = $niveaux->merge($coursPlaning->map(function ($item) {
                                        return [
                                            'niveau' => $item->niveau,
                                            'filiere' => $item->filiere,
                                            'slug' => Str::slug($item->filierename . '-' . $item->niveau)
                                        ];
                                    }))->unique();

        }
        return view('admin.planing', compact('filieres', 'planing', 'cours', 'coursPlaning', 'jours', 'emploisDuTemps', 'niveaux'));
    }

    public function planingStore(){
        $id = request('id');
        if($id){
            $planing = Planing::find($id);
            $msg = 'modification reussi';
        }else{
            $planing = new Planing();
            $msg = 'planing crée avec succes';
        }

        $planing->jours= request('jour');
        $planing->date_debut = request('date_debut');
        $planing->date_fin = request('date_fin');
        $planing->filieres_id = request('filiere');
        if(request('cours')){
            foreach(request('cours') as $cour){
                    $planing->cours_id = $cour;
                    $planing->save();
            }
            $planing->save();
            return redirect()->back()->with('success'.$msg);
        }else{
            return redirect()->back()->with('error','enregistrement erroné');
        }


    }
}
