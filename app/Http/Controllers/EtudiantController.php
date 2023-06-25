<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\CoursLocal;
use App\Models\CoursMission;
use App\Models\SupportCours;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupportTd;
use Illuminate\Support\Facades\Hash;

class EtudiantController extends Controller
{
    public function index(){
        return view('etudiant.login');
    }

    public function login(Request $requete){
        $requete->validate([
            'matricule' => ['required', 'min:8', 'max:8'],
            'password' => ['required', 'min:4'],
        ],[
            'matricule.required' => 'Le matricule est obligatoire',
            'matricule.min' => 'Le matricule doit faire exactement :min chiffres',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Pour des raisons de sécurité, le mot de passe doit faire :min caractères.',
        ]);

        $requete['password'] = strip_tags($requete->password);

        $etudiant = Etudiant::where('matricule', '=', $requete->matricule)->first();
 
        if($etudiant) {
           
            if(Hash::check($requete->password, $etudiant->password)){
                $requete->session()->put('matricule', $etudiant->matricule);
                return redirect()->route('home-etudiant', ['id' => $etudiant->id]);
            }else{
                return redirect()->route('login-etudiant')->with('echec', 'Mot de passe erroné');
            }
        }else{
            return redirect()->route('login-etudiant')->with('echec', 'Matricule introuvable');
        }
    }

    public function home(int $id){
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiant.home', ['etudiant' => $etudiant]);
    }

    public function homeCoursLocal(int $id){
        $etudiant = Etudiant::findOrFail($id);
        $cours =  CoursLocal::where('filiere', '=', $etudiant->filiere)
                    ->orderby('semestre')
                    ->paginate(8);
        
        return view('etudiant.homeLocal', ['etudiant' => $etudiant, 'cours' => $cours]);
    }

    public function homeCoursMission(int $id){
        $etudiant = Etudiant::findOrFail($id);
        $cours =  CoursMission::where('filiere', '=', $etudiant->filiere)
                    ->orderby('semestre')
                    ->paginate(8);
        
        return view('etudiant.homeMission', ['etudiant' => $etudiant, 'cours' => $cours]);
    }

    public function indexEditer(int $id){
        $etudiant = Etudiant::findorfail($id);
        return view('etudiant.editer', compact('etudiant'));
    }

    public function editer(int $id, Request $requete){
        $etudiant = Etudiant::findOrFail($id);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required|min:4'
            ],[
                'password.required' => 'Le mot de passe est obligatoire',
                'password.min' => 'Le mot de passe doit contenir au moins :min caractères',
            ]);
            $etudiant->password = Hash::make($requete->password);
        }

        $donneesValidation = $requete->validate([
            'nom' => 'required',
            'prenom' => 'required',
        ],[
            'nom.required' => 'Le nom est obligaoire',
            'prenom.required' => 'Le prénom est obligaoire',

        ]);

        $etudiant->nom = strip_tags($donneesValidation['nom']);
        $etudiant->prenom = strip_tags($donneesValidation['prenom']);
    
        $etudiant->save();
        return redirect()->route('home-etudiant', ['id' => $id])->with('effectuer', 'Etudiant '. $etudiant->nom.' édité avec succès');
    }

    public function logout(){
        return view('login');
    }

    public function supportCours($id, $type, $idCours) {
        $fichiers = SupportCours::where('cours_id', '=', $idCours)
            ->where('type_cours', '=', $type)
            ->get();
        
        $cours = ''.$type == 'local' ? CoursLocal::findOrFail($idCours) : CoursMission::findOrFail($idCours);

        if ($fichiers->isEmpty()) {
            return redirect()->back()->with('effectuer', 'Aucun fichier disponible.');
        }
        
        $nom = '' . $cours->intitule;
        $filiere = '' . $cours->filiere;
        $nomArchive = 'fichiers_support_cours_' . $nom . '_' . $filiere . '_' . $type . '_' . time() . '.zip';
        $cheminArchive = storage_path($nomArchive);
    
        $zip = new \ZipArchive();
        $zip->open($cheminArchive, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
    
        foreach ($fichiers as $fichier) {
            $cheminFichier = storage_path('app/' . $fichier->chemin);
    
            if (file_exists($cheminFichier)) {
                $nomFichier = $fichier->nom;
                $zip->addFile($cheminFichier, $nomFichier);
            }
        }
        $zip->close();

        return response()->download($cheminArchive, $nomArchive);
    }
    
    public function supportTd($id, $type, $idCours) {
        $fichiers = SupportTd::where('cours_id', '=', $idCours)
            ->where('type_cours', '=', $type)
            ->get();
    

        $cours = ''.$type == 'local' ? CoursLocal::findOrFail($idCours) : CoursMission::findOrFail($idCours);

        if ($fichiers->isEmpty()) {
            return redirect()->back()->with('effectuer', 'Aucun fichier disponible.');
        }
    
        $nom = '' . $cours->intitule;
        $filiere = '' . $cours->filiere;
        $nomArchive = 'fichiers_support_td_' . $nom . '_' . $filiere . '_' . $type . '_' . time() . '.zip';
        
        $cheminArchive = storage_path($nomArchive);
    
        $zip = new \ZipArchive();
        $zip->open($cheminArchive, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
    
        foreach ($fichiers as $fichier) {
            $cheminFichier = storage_path('app/' . $fichier->chemin);

            if (file_exists($cheminFichier)) {
                $nomFichier = $fichier->nom;
                $zip->addFile($cheminFichier, $nomFichier);
            }
        }
    
        $zip->close();
        return response()->download($cheminArchive, $nomArchive);
    }      
}
