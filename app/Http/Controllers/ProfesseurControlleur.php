<?php

namespace App\Http\Controllers;

use App\Models\Bulletin;
use App\Models\Cour;
use App\Models\Etudiant;
use App\Models\Filiere;
use App\Models\Note;
use App\Models\User;
use Illuminate\Support\Str;

use Illuminate\Http\Request;

class ProfesseurControlleur extends Controller
{

    public function acceuilAdmin(){
        return view('prof.acceuil');
    }

   public function choixFiliere(Request $request){
    $periode = request('periode');
    $periode = $request->session()->put('periode', $periode);
    $idProfesseur = auth()->user()->enseignants_id;

    $idProfesseur = auth()->user()->enseignants_id;

    $filiere = Filiere::select('filieres.id as filiereId', 'filieres.nom', 'filieres.niveau')
                        ->join('planings', 'planings.filieres_id', '=', 'filieres.id')
                        ->join('cours', 'cours.id', '=', 'planings.cours_id')
                        ->where('cours.enseignants_id', '=', $idProfesseur)
                        ->distinct()
                        ->get();



    return view('prof.filiere', compact('filiere'));
   }

   public function note( Request $request,  $id = null){
    $periode = $request->session()->get('periode');
    $idProfesseur = auth()->user()->enseignants_id;
                    //   dd($periode, $idProfesseur);

    $note = $id ? Note::select('notes.id as noteId', 'notes.note1 as note', 'notes.note2 as notes', 'cours.id as courId', 'cours.nom as courname', 'cours.statut', 'filieres.nom as filiere', 'filieres.id as filiereId','filieres.niveau', 'usersEtudiant.nom', 'usersEtudiant.prenom', 'etudiants.matricule', 'enseignants.matricule', 'inscriptions.satut', 'etudiants.matricule', 'etudiants.id', 'bulletins.periode as periode')
                    ->join('etudiants', 'etudiants.id', '=', 'notes.etudiants_id')
                    ->join('enseignants', 'enseignants.id', '=', 'notes.etudiants_id')
                    ->join('cours', 'cours.enseignants_id', '=', 'enseignants.id')
                    ->join('users as usersEnseignant', 'usersEnseignant.enseignants_id', '=', 'enseignants.id')
                    ->join('users as usersEtudiant', 'usersEtudiant.etudiants_id', '=', 'etudiants.id')
                    ->join('inscriptions', 'inscriptions.etudiants_id', '=', 'etudiants.id')
                    ->join('filieres', 'inscriptions.filieres_id', '=', 'filieres.id')
                    ->join('bulletins', 'etudiants.id', '=', 'bulletins.etudiants_id')
                    ->where('notes.id', '=', $id)
                    ->where('bulletins.periode', '=', $periode)
                    ->first(): null;
    $users = User::select('users.id as userId', 'users.nom', 'users.prenom', 'users.email', 'users.etudiants_id', 'users.profils_id', 'etudiants.matricule', 'inscriptions.satut', 'filieres.nom as filiere', 'profils.libelle', 'filieres.niveau', 'notes.id as noteId','notes.note1 as note', 'notes.note2 as notes','cours.nom as courname', 'bulletins.periode as periode')
                    ->join('profils', 'profils.id', '=', 'users.profils_id')
                    ->join('etudiants', 'etudiants.id', '=', 'users.etudiants_id')
                    ->join('inscriptions', 'etudiants.id', '=', 'inscriptions.etudiants_id')
                    ->join('filieres', 'filieres.id', '=', 'inscriptions.filieres_id')
                    ->join('notes', 'notes.etudiants_id', '=', 'etudiants.id')
                    ->join('cours', 'notes.cours_id', '=', 'cours.id')
                    ->join('bulletins', 'etudiants.id', '=', 'bulletins.etudiants_id')
                    ->where('cours.enseignants_id', '=', $idProfesseur)
                    ->where('bulletins.periode', '=', $periode)
                    ->whereColumn('bulletins.notes_id', 'notes.id')
                    ->distinct()
                    ->get();
                    //    dd($users);

    $niveaux = collect();
    $matricule = Etudiant::all();
    $filiere = Filiere::all();

    $niveaux = $niveaux->merge($users->map(function ($item) {return [ 'niveau' => $item->niveau, 'filiere' => $item->filiere, 'courname' =>$item->courname, 'slug' => Str::slug($item->filierename . '-' . $item->niveau . '-' . $item->courname)];}))->unique();

    $cours = Cour::select('cours.id as cId','cours.nom as courname', 'users.nom as username','users.prenom as userfirstname' , 'enseignants.matricule')
                    ->join('enseignants', 'cours.enseignants_id', '=', 'enseignants.id')
                    ->join('users', 'users.enseignants_id', '=', 'enseignants.id')
                    ->where('cours.enseignants_id', '=', $idProfesseur)
                    ->get();
                    // return response()->json($note);

    return view('prof.notation', compact('note', 'periode', 'niveaux', 'cours', 'users', 'filiere'));
   }

   public function noteStore(Request $request){
    $id = request('id');
    $periode = $request->session()->get('periode');

    $existingNote = Note::where('etudiants_id', $request->etudiant) ->where('cours_id', $request->cours) ->first(); if ($existingNote) { return back()->withErrors(['etudiant' => 'Une note existe déjà pour cet étudiant et ce cours.']); }

    $idProfesseur = request('id_enseignant');
    // dd($proffesseur);
    if($id){
        $note = Note::find($id);
        $msg = 'note modifié avec succes';
        // modification de le note
        $note->note1 = request('note');
        $note->note2 = request('note2');
        $note->cours_id = request('cours');
        $note->etudiants_id = request('etudiant');
        $note->enseignants_id = $idProfesseur;
        $note->save();
    }else{
        $note = new Note();
        $msg = 'note enregistre avec succes';
        //enregistrement de la note
        $note->note1 = request('note');
        $note->note2 = request('note2');
        $note->cours_id = request('cours');
        $note->etudiants_id = request('etudiant');
        $note->enseignants_id = $idProfesseur;
        $note->save();

        //l'engistrement dans la table bulletin, la periode de la note
        $noteId = $note->id;
        $bulletin_Etudiant_Id = $note->etudiants_id;
        $bulletin = new Bulletin();
        $bulletin->periode = $periode;
        $bulletin->notes_id = $noteId;
        $bulletin->etudiants_id = $bulletin_Etudiant_Id;
        $bulletin->save();
    }



    return redirect()->back()->with('success'.$msg);
   }

   //pour rendre le formulaire dynamique pour l'affichage automatique des numeros matricule apres la selection des filieres dans le formulaire
   public function getEtudiantByNiveauFiliere($filiere) {
        try{
                $etudiants = Etudiant::select('etudiants.matricule', 'etudiants.id')
                                    ->join('inscriptions', 'inscriptions.etudiants_id', '=', 'etudiants.id')
                                    ->join('filieres', 'filieres.id', '=', 'inscriptions.filieres_id')
                                    ->where('inscriptions.satut', '=','inscrit')
                                    ->where('filieres.id', '=',$filiere)
                                    ->get(); // Vérifiez les données ici
            if ($etudiants->isEmpty()) {
                return response()->json(['error' => 'Aucun étudiant trouvé'], 404);
            }
            return response()->json($etudiants);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
