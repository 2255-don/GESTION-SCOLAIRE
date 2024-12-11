<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Filiere;
use App\Models\Moyenne;
use App\Models\Note;
use App\Models\User;
use Illuminate\Http\Request;

class AdminNoteController extends Controller
{

    public function choixFiliere(){
        // $request->session()->put('idFiliere', $id);
    //    $filiereId =  $request->session()->get('idFiliere');
        $filieres =Filiere::select('id','niveau', 'nom')
                        //   ->where('id', $filiereId)
                          ->distinct()
                          ->get();
        return view('admin.note', compact('filieres'));

    }

    public function infoEtudiant(Request $request){

        $niveau = request('niveau');
        // dd($niveau);

        $periode = request('periode');
        // dd($periode);

        $filiereId =  request('filiere');
        // dd($filiereId);

        $periode = $request->session()->put('periode', $periode);
        $etudiants = User::select('users.nom as username', 'users.prenom as userfirstname', 'bulletins.statut as statut', 'etudiants.matricule', 'etudiants.id')
                           ->join('etudiants', 'etudiants.id', '=', 'users.etudiants_id')
                           ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiants_id')
                           ->join('notes', 'etudiants.id', '=', 'notes.etudiants_id')
                           ->join('filieres', 'filieres.id', '=', 'inscriptions.filieres_id')
                           ->join('bulletins', 'notes.id', '=', 'bulletins.notes_id')
                           ->where('filieres.id', '=', $filiereId)
                           ->where('filieres.niveau', '=', $niveau)
                           ->distinct()
                           ->get();
            // dd($etudiants);
        return view('admin.info_etudiant', compact('etudiants'));
    }

    public function  bulletin(Request $request, $id){
    $periode = $request->session()->get('periode');

    $cours = User::select('users.id as userId', 'users.nom', 'users.prenom', 'users.email', 'users.etudiants_id', 'users.profils_id', 'etudiants.matricule', 'inscriptions.satut', 'filieres.nom as filiere', 'profils.libelle', 'filieres.niveau', 'notes.id as noteId','notes.note1 as note', 'notes.note2 as notes','cours.nom as courname', 'bulletins.periode as periode', 'bulletins.id as bulletinId')
                ->join('profils', 'profils.id', '=', 'users.profils_id')
                ->join('etudiants', 'etudiants.id', '=', 'users.etudiants_id')
                ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiants_id')
                ->join('filieres', 'filieres.id', '=', 'inscriptions.filieres_id')
                ->join('notes', 'notes.etudiants_id', '=', 'etudiants.id')
                ->join('cours', 'notes.cours_id', '=', 'cours.id')
                ->join('bulletins', 'etudiants.id', '=', 'bulletins.etudiants_id')
                ->where('etudiants.id', '=',  $id)
                ->where('bulletins.periode', '=', $periode)
                // ->whereColumn('bulletins.notes_id', 'notes.id')
                ->distinct()
                ->get();
    $moyennes = Moyenne::all();
    foreach($moyennes as $moyenne){
        if($moyenne->etudiants_id != $id){
            foreach($cours as $cour){
                // calcule et insertion de la notegen dans la table note
                $sommeNote =  $cour->note + $cour->notes;
                $notegen = $sommeNote / 2;
                $note = Note::find($cour->noteId);
                $note->notegen = $notegen;
                $note->save();
            }
            //   calcule et isertion de la moyenne dans la table moyenne
            $notes = Note::where('etudiants_id', $id)->pluck('notegen');
            $moyenne = $notes->avg();
            $moyennes = new Moyenne();
            $moyennes->moyenne = $moyenne;
            $moyennes->etudiants_id = $id;
            $moyennes->save();
        }
    }

    $bulletin = Note::select('notes.note1', 'notes.note2', 'notes.notegen', 'cours.nom as corname', 'users.nom', 'users.prenom', 'etudiants.matricule', 'moyennes.moyenne')
                      ->join('cours', 'cours.id', '=', 'notes.cours_id')
                      ->join('etudiants', 'etudiants.id', '=', 'notes.etudiants_id')
                      ->join('users', 'etudiants.id', '=', 'users.etudiants_id')
                      ->join('bulletins', 'bulletins.notes_id', '=', 'notes.id')
                      ->join('moyennes', 'etudiants.id', '=', 'moyennes.etudiants_id')
                      ->where('bulletins.periode', '=', $periode)
                      ->where('etudiants.id', '=', $id)
                      ->distinct()
                      ->get();

    return view('admin.show_bulletin', compact('bulletin'));
    }

    public function showBulletin(Request $request, $id){
    $periode = $request->session()->get('periode');
        $bulletin = Note::select('notes.note1', 'notes.note2', 'notes.notegen', 'cours.nom as corname', 'users.nom', 'users.prenom', 'etudiants.matricule', 'moyennes.moyenne')
                      ->join('cours', 'cours.id', '=', 'notes.cours_id')
                      ->join('etudiants', 'etudiants.id', '=', 'notes.etudiants_id')
                      ->join('users', 'etudiants.id', '=', 'users.etudiants_id')
                      ->join('bulletins', 'bulletins.notes_id', '=', 'notes.id')
                      ->join('moyennes', 'etudiants.id', '=', 'moyennes.etudiants_id')
                      ->where('bulletins.periode', '=', $periode)
                      ->where('etudiants.id', '=', $id)
                      ->distinct()
                      ->get();

    return view('admin.show_bulletin', compact('bulletin'));
    }
}
