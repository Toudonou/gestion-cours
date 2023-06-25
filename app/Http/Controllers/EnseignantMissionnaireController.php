<?php

namespace App\Http\Controllers;

use App\Models\SupportTd;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\EnseignantMissionnaire;

class EnseignantMissionnaireController extends Controller
{
    public function index(){
        return view('enseignantMissionnaire.login');
    }

    public function login(Request $requete){
        $requete->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ],[
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse mail valide',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Pour des raisons de sécurité, le mot de passe doit faire :min caractères.',
        ]);

        $requete['email'] = strip_tags($requete->email);
        $requete['password'] = strip_tags($requete->password);

        $enseignant = EnseignantMissionnaire::where('email', '=', $requete->email)->first();
 
        if($enseignant) {
           
            if(Hash::check($requete->password, $enseignant->password)){
                $requete->session()->put('email', $enseignant->mail);
                return redirect()->route('home-enseignant-missionnaire', ['id' => $enseignant->id]);
            }else{
                return redirect()->route('login-enseignant-missionnaire')->with('echec', 'Mot de passe erroné');
            }
        }else{
            return redirect()->route('login-enseignant-missionnaire')->with('echec', 'Email introuvable');
        }
    }

    public function home(int $id){
        $i = 0;
        $enseignant = EnseignantMissionnaire::findOrFail($id);
        $cours =  DB::table('cours_missions')
                ->join('ues', 'ues.id', '=', 'cours_missions.ue_id')
                ->join('enseignant_missionnaires', 'enseignant_missionnaires.id', '=', 'cours_missions.enseignant_missionnaire_id')
                ->select('cours_missions.id', 'nom', 'prenom', 'intitule', 'masseHoraire','intituleUE', 'semestre', 'filiere', 'ue_id', 'enseignant_missionnaire_id', 'credit')
                ->where('enseignant_missionnaire_id', '=', $id)
                ->paginate(5);
        
        foreach ($cours as $key) {
            $i += 1;
        }
        if($i != 0){
            return view('enseignantMissionnaire.home', ['enseignant' => $enseignant, 'cours' => $cours]);
        }else{
            return view('enseignantMissionnaire.nonProgrammer', ['enseignant' => $enseignant, 'cours' => $cours]);
        }
    }

    public function indexEditer(int $id){
        $enseignant = EnseignantMissionnaire::findorfail($id);
        return view('enseignantMissionnaire.editer', compact('enseignant'));
    }

    public function editer(int $id, Request $requete){
        $enseignant = EnseignantMissionnaire::findOrFail($id);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required|min:4'
            ],[
                'password.required' => 'Le mot de passe est obligatoire',
                'password.min' => 'Le mot de passe doit contenir au moins :min caractères',
            ]);
            $enseignant->password = Hash::make($requete->password);
        }

        $donneesValidation = $requete->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => ['required', 'email', Rule::unique('enseignant_missionnaires')->ignore($id)],
        ],[
            'nom.required' => 'Le nom est obligaoire',
            'prenom.required' => 'Le prénom est obligaoire',
            'email.required' => 'L\'email est obligaoire',
            'email.email' => 'Entrer une adresse email valide',
            'email.unique' => 'L\'adresse ' . $requete->email . ' est déjà utilisée',

        ]);

        $enseignant->nom = strip_tags($donneesValidation['nom']);
        $enseignant->prenom = strip_tags($donneesValidation['prenom']);
        $enseignant->email = strip_tags($donneesValidation['email']);
    
        $enseignant->save();
        return redirect()->route('home-enseignant-missionnaire', ['id' => $id])->with('effectuer', 'Enseignant '. $enseignant->nom.' édité avec succès');
    }

    public function logout(){
        return view('login');
    }

    public function uploadCours($idEnseignant, $idCours, Request $request){
        $request->validate([
            'fichier' => 'required|mimes:pdf|max:2048',
        ], [
            'fichier.required' => 'Le fichier est obligatoire',
            'fichier.mimes' => 'Le fichier doit être un pdf',
            'fichier.max' => 'Le fichier doit faire moins de :max',
        ]);

        $fichier = $request->file('fichier');
        $nomFichier = $fichier->getClientOriginalName();
        $cheminFichier = $fichier->store('fichiers');

        $fichierModel = SupportCours::create([
            'nom' => $nomFichier,
            'chemin' => $cheminFichier,
            'type_cours' => 'mission',
            'cours_id' => $idCours,
            'enseignant_id' => $idEnseignant,
        ]);
        return redirect()->back()->with('effectuer', 'Le support de cours a été téléversé avec succès.');
    }

    public function uploadTd($idEnseignant, $idCours, Request $request){
        $request->validate([
            'fichier' => 'required|mimes:pdf|max:2048',
        ], [
            'fichier.required' => 'Le fichier est obligatoire',
            'fichier.mimes' => 'Le fichier doit être un pdf',
            'fichier.max' => 'Le fichier doit faire moins de :max',
        ]);

        $fichier = $request->file('fichier');
        $nomFichier = $fichier->getClientOriginalName();
        $cheminFichier = $fichier->store('fichiers');

        $fichierModel = SupportTd::create([
            'nom' => $nomFichier,
            'chemin' => $cheminFichier,
            'type_cours' => 'mission',
            'cours_id' => $idCours,
            'enseignant_id' => $idEnseignant,
        ]);
        return redirect()->back()->with('effectuer', 'Le TD a été téléversé avec succès.');
    }

    public function gererSupportCours($id){
        $enseignant = EnseignantMissionnaire::findOrFail($id);
        $supCours =  DB::table('support_cours')
        ->join('cours_missions', 'cours_missions.id', '=', 'support_cours.cours_id')
        ->join('enseignant_missionnaires', 'cours_missions.enseignant_missionnaire_id', '=', 'enseignant_missionnaires.id')
        ->where('support_cours.type_cours','=', 'mission')
        ->select('support_cours.id', 'support_cours.id', 'enseignant_id', 'intitule', 'filiere', 'support_cours.nom', 'support_cours.chemin')
        ->where('enseignant_id', '=', $id)
        ->paginate(10);

        return view('enseignantMissionnaire.gererSupportCours', ['suppCours' => $supCours, 'enseignant' => $enseignant]);
    }

    public function supprimerSupportCours(int $idEnseignant, int $idCours){
        $cours = SupportCours::findOrFail($idCours);
        $cours->delete();
        return back()->with('effectuer', 'Support de cours supprimer avec succès');
    }

    public function gererSupportTd($id){
        $enseignant = EnseignantMissionnaire::findOrFail($id);
        $supCours =  DB::table('support_tds')
        ->join('cours_missions', 'cours_missions.id', '=', 'support_tds.cours_id')
        ->join('enseignant_missionnaires', 'cours_missions.enseignant_missionnaire_id', '=', 'enseignant_missionnaires.id')
        ->where('support_tds.type_cours','=', 'mission')
        ->select('support_tds.id', 'support_tds.id', 'enseignant_id', 'intitule', 'filiere', 'support_tds.nom', 'support_tds.chemin')
        ->where('enseignant_id', '=', $id)
        ->paginate(10);


        return view('enseignantMissionnaire.gererSupportTd', ['suppCours' => $supCours, 'enseignant' => $enseignant]);
    }

    public function supprimerSupportTd(int $idEnseignant, int $idCours){
        $cours = SupportTd::findOrFail($idCours);
        $cours->delete();
        return back()->with('effectuer', 'Support de Td supprimer avec succès');
    }
}
