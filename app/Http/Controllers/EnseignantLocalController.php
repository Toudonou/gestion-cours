<?php

namespace App\Http\Controllers;

use App\Models\CoursLocal;
use Illuminate\Http\Request;
use App\Models\EnseignantLocal;
use App\Models\SupportCours;
use App\Models\SupportTd;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EnseignantLocalController extends Controller
{
    public function index() {
        return view('enseignantLocal.login');
    }

    public function login(Request $requete){
        $requete->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:4'],
        ], [
            'email.required' => 'L\'email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse mail valide',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Pour des raisons de sécurité, le mot de passe doit faire :min caractères.',
        ]);

        $requete['email'] = strip_tags($requete->email);
        $requete['password'] = strip_tags($requete->password);

        $enseignant = EnseignantLocal::where('email', '=', $requete->email)->first();

        if ($enseignant) {

            if (Hash::check($requete->password, $enseignant->password)) {
                $requete->session()->put('email', $enseignant->mail);
                return redirect()->route('home-enseignant-local', ['id' => $enseignant->id]);
            } else {
                return redirect()->route('login-enseignant-local')->with('echec', 'Mot de passe erroné');
            }
        } else {
            return redirect()->route('login-enseignant-local')->with('echec', 'Email introuvable');
        }
    }

    public function home(int $id){
        $enseignant = EnseignantLocal::findOrFail($id);
        $cours =  DB::table('cours_locals')
            ->join('ues', 'ues.id', '=', 'cours_locals.ue_id')
            ->select('cours_locals.id', 'intitule', 'masseHoraire', 'intituleUE', 'semestre', 'filiere', 'ue_id', 'enseignant_local_id', 'credit')
            ->where('enseignant_local_id', '=', $id)
            ->orderBy('semestre')
            ->paginate(5);

        $i = DB::table('cours_locals')
            ->join('ues', 'ues.id', '=', 'cours_locals.ue_id')
            ->select('cours_locals.id', 'intitule', 'masseHoraire', 'intituleUE', 'semestre', 'filiere', 'ue_id', 'enseignant_local_id', 'credit')
            ->where('enseignant_local_id', '=', $id)
            ->count();

        if ($i != 0) {
            return view('enseignantLocal.home', ['enseignant' => $enseignant, 'cours' => $cours]);
        } else {
            return view('enseignantLocal.nonProgrammer', ['enseignant' => $enseignant, 'cours' => $cours]);
        }
    }

    public function indexEditer(int $id){
        $enseignant = EnseignantLocal::findorfail($id);
        return view('enseignantLocal.editer', compact('enseignant'));
    }

    public function editer(int $id, Request $requete){
        $enseignant = EnseignantLocal::findOrFail($id);

        if ($requete->modifierPassword == 'on') {
            $requete->validate([
                'password' => 'required|min:4'
            ], [
                'password.required' => 'Le mot de passe est obligatoire',
                'password.min' => 'Le mot de passe doit contenir au moins :min caractères',
            ]);
            $enseignant->password = Hash::make($requete->password);
        }

        $donneesValidation = $requete->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => ['required', 'email', Rule::unique('enseignant_locals')->ignore($id)],
        ], [
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
        return redirect()->route('home-enseignant-local', ['id' => $id])->with('effectuer', 'Enseignant ' . $enseignant->nom . ' édité avec succès');
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
            'type_cours' => 'local',
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
            'type_cours' => 'local',
            'cours_id' => $idCours,
            'enseignant_id' => $idEnseignant,
        ]);
        return redirect()->back()->with('effectuer', 'Le TD a été téléversé avec succès.');
    }

    public function gererSupportCours($id){
        $enseignant = EnseignantLocal::findOrFail($id);
        $supCours =  DB::table('support_cours')
        ->join('cours_locals', 'cours_locals.id', '=', 'support_cours.cours_id')
        ->join('enseignant_locals', 'cours_locals.enseignant_local_id', '=', 'enseignant_locals.id')
        ->where('support_cours.type_cours','=', 'local')
        ->select('support_cours.id', 'support_cours.id', 'enseignant_id', 'intitule', 'filiere', 'support_cours.nom', 'support_cours.chemin')
        ->where('enseignant_id', '=', $id)
        ->paginate(10);
        ;

        return view('enseignantLocal.gererSupportCours', ['suppCours' => $supCours, 'enseignant' => $enseignant]);
    }

    public function supprimerSupportCours(int $idEnseignant, int $idCours){
        $cours = SupportCours::findOrFail($idCours);
        $cours->delete();
        return back()->with('effectuer', 'Support de cours supprimer avec succès');
    }

    public function gererSupportTd($id){
        $enseignant = EnseignantLocal::findOrFail($id);
        $supCours =  DB::table('support_tds')
        ->join('cours_locals', 'cours_locals.id', '=', 'support_tds.cours_id')
        ->join('enseignant_locals', 'cours_locals.enseignant_local_id', '=', 'enseignant_locals.id')
        ->where('support_tds.type_cours','=', 'local')
        ->select('support_tds.id', 'support_tds.id', 'enseignant_id', 'intitule', 'filiere', 'support_tds.nom', 'support_tds.chemin')
        ->where('enseignant_id', '=', $id)
        ->paginate(10);
        ;

        return view('enseignantLocal.gererSupportTd', ['suppCours' => $supCours, 'enseignant' => $enseignant]);
    }

    public function supprimerSupportTd(int $idEnseignant, int $idCours){
        $cours = SupportTd::findOrFail($idCours);
        $cours->delete();
        return back()->with('effectuer', 'Support de Td supprimer avec succès');
    }
}           


