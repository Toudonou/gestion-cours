<?php

namespace App\Http\Controllers;

use App\Models\Ue;
use App\Models\Etudiant;
use App\Models\Directeur;
use App\Models\CoursLocal;
use App\Models\CoursMission;
use Illuminate\Http\Request;
use App\Models\EnseignantLocal;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\EnseignantMissionnaire;

class DirecteurController extends Controller{

    public function index(){
        return view('directeur.login');
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

        $directeur = Directeur::where('email', '=', $requete->email)->first();
 
        if($directeur) {
           
            if(Hash::check($requete->password, $directeur->password)){
                $requete->session()->put('email', $directeur->mail);
                return redirect()->route('home-directeur', ['id' => $directeur->id]);
            }else{
                return redirect()->route('login-directeurs')->with('echec', 'Mot de passe erroné');
            }
        }else{
            return redirect()->route('login-directeurs')->with('echec', 'Email introuvable');
        }
    }

    public function home(int $id){        
        $directeur = Directeur::findOrFail($id);
        $nbrCours = CoursLocal::where('directeur_id', '=', $id)->count() + CoursMission::where('directeur_id', '=', $id)->count();
        $nbrEtudiant = Etudiant::where('directeur_id', '=', $id)->count();
        $nbrEL = EnseignantLocal::where('directeur_id', '=', $id)->count();
        $nbrEM = EnseignantMissionnaire::where('directeur_id', '=', $id)->count();
        

        return view('directeur.home', ['directeur' => $directeur, 'nbrCours' => $nbrCours, 'nbrEtudiant' => $nbrEtudiant, 'nbrEL' => $nbrEL, 'nbrEM' => $nbrEM]);
    }

    public function indexEditer(int $id){
        $directeur = Directeur::findorfail($id);
        return view('directeur.editer', ['directeur' => $directeur]);
    }

    public function editer(int $id, Request $requete){
        $directeur = Directeur::findOrFail($id);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required|min:4'
            ],[
                'password.required' => 'Le mot de passe est obligatoire',
                'password.min' => 'Le mot de passe doit contenir au moins :min caractères',
            ]);
            $directeur->password = Hash::make($requete->password);
        }

        $donneesValidation = $requete->validate([
            'nom' => 'required',
            'prenom' => 'required',
            'email' => ['required', 'email', Rule::unique('directeurs')->ignore($id)],
        ],[
            'nom.required' => 'Le nom est obligaoire',
            'prenom.required' => 'Le prénom est obligaoire',
            'email.required' => 'L\'email est obligaoire',
            'email.email' => 'Entrer une adresse email valide',
            'email.unique' => 'L\'adresse '.$requete->email.' est déjà utilisée',
        ]);

        $directeur->nom = strip_tags($donneesValidation['nom']);
        $directeur->prenom = strip_tags($donneesValidation['prenom']);
        $directeur->email = strip_tags($donneesValidation['email']);
    
        $directeur->save();
        return redirect()->route('home-directeur', ['id' => $id])->with('effectuer', 'Directeur '. $directeur->nom.' édité avec succès');
 
        return view('login');
    }

    public function logout(){
        return view('login');
    }

    /** ENSEIGNANTS */
    public function gererEnseignants(int $id){
        $directeur = Directeur::findOrFail($id);
        return view('directeur.gererEnseignants', compact('directeur'));
    }

    /** ENSEIGNANTS LOCAUX */
    public function gererEnseignantsLocaux(int $id){
        $directeur = Directeur::findOrFail($id);
        $enseignants = EnseignantLocal::where('directeur_id', '=', $directeur->id)->paginate(5);
        return view('directeur.enseignantLocal.gererEnseignantsLocaux', ['directeur' => $directeur, 'enseignants' => $enseignants]);
    }

    public function indexAjouterEnseignantLocal(int $id){
        $directeur = Directeur::findOrFail($id);
        return view('directeur.enseignantLocal.ajouterEnseignantLocal', ['directeur' => $directeur]);
    }

    public function ajouterEnseignantLocal(int $id, Request $requete){
        $enseignant = $requete->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', 'unique:enseignant_locals'],
            'password' => ['required', 'min:4'],
        ],[
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',

            'email.required' => 'Le email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.unique' => 'L\'adresse '.$requete->email.' est déjà utilisée',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit faire au moins :min caractères',
        ]);

        $enseignant['nom'] = strip_tags($requete->nom);
        $enseignant['prenom'] = strip_tags($requete->prenom);
        $enseignant['email'] = strip_tags($requete->email);
        $enseignant['password']  = Hash::make($requete->password);
        $enseignant['vacataire'] = $requete->vacataire == 'on' ? 1 : 0;
        $enseignant['directeur_id'] = $id;
        
        EnseignantLocal::create($enseignant);
        return redirect()->route('gerer-enseignants-locaux', ['id' => $id])->with('effectuer', 'Enseignant '. $requete->nom.' ajouté avec succès');
    }

    public function indexEditerEnseignantLocal(int $idDirecteur, int $idEnseignant){
        $directeur = Directeur::findOrFail($idDirecteur);
        $enseignant = EnseignantLocal::findOrFail($idEnseignant);
        return view('directeur.enseignantLocal.editerEnseignantLocal', ['directeur' => $directeur, 'enseignant' => $enseignant]);
    }

    public function editerEnseignantLocal(int $idDirecteur, int $idEnseignant, Request $requete){
        $enseignant = EnseignantLocal::findOrFail($idEnseignant);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required|min:4'
            ]);
            $enseignant->password = Hash::make($requete->password);

        }

        $donneesValidation = $requete->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', Rule::unique('enseignant_locals')->ignore($idEnseignant)],
        ],[
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',

            'email.required' => 'Le email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.unique' => 'L\'adresse '.$requete->email.' est déjà utilisée',
        ]);
            
        $enseignant->nom = strip_tags($donneesValidation['nom']);
        $enseignant->prenom = strip_tags($donneesValidation['prenom']);
        $enseignant->email = strip_tags($donneesValidation['email']);
        $enseignant->vacataire = $requete->vacataire == 'on' ? 1 : 0;
    
        $enseignant->save();
        return redirect()->route('gerer-enseignants-locaux', ['id' => $idDirecteur])->with('effectuer', 'Enseignant '. $enseignant->nom.' édité avec succès');
    }
    
    public function supprimerEnseignantLocal(int $idDirecteur, int $idEnseignant){
        $enseignant = EnseignantLocal::findOrFail($idEnseignant);
        $nom = $enseignant->nom;
        $enseignant->delete();
        return back()->with('effectuer', 'Enseignant ' .$nom.' supprimer avec succès');
    }

    /**ENSEIGNANTS MISSIONNAIRES */
    public function gererEnseignantsMissionnaires(int $id){
        $directeur = Directeur::findOrFail($id);
        $enseignants = EnseignantMissionnaire::where('directeur_id', '=', $directeur->id)->paginate(5);
        return view('directeur.enseignantMissionnaire.gererEnseignantsMissionnaires', ['directeur' => $directeur, 'enseignants' => $enseignants]);
    }

    public function indexAjouterEnseignantMissionnaire(int $id){
        $directeur = Directeur::findOrFail($id);
        return view('directeur.enseignantMissionnaire.ajouterEnseignantMissionnaire', ['directeur' => $directeur]);
    }

    public function ajouterEnseignantMissionnaire(int $id, Request $requete){
        $enseignant = $requete->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', 'unique:enseignant_missionnaires'],
            'password' => ['required', 'min:4'],
            'universite' => ['required']
        ],[
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'universite.required' => 'L\'université doit être renseignée',

            'email.required' => 'Le email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.unique' => 'L\'adresse '.$requete->email.' est déjà utilisée',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit faire au moins :min caractères',
        ]);

        $enseignant['nom'] = strip_tags($requete->nom);
        $enseignant['prenom'] = strip_tags($requete->prenom);
        $enseignant['email'] = strip_tags($requete->email);
        $enseignant['universite'] = strip_tags($requete->universite);
        $enseignant['password']  = Hash::make($requete->password);
        $enseignant['directeur_id'] = $id;
        
        EnseignantMissionnaire::create($enseignant);
        return redirect()->route('gerer-enseignants-missionnaires', ['id' => $id])->with('effectuer', 'Enseignant '. $requete->nom.' ajouté avec succès');
    }

    public function indexEditerEnseignantMissionnaire(int $idDirecteur, int $idEnseignant){
        $directeur = Directeur::findOrFail($idDirecteur);
        $enseignant = EnseignantMissionnaire::findOrFail($idEnseignant);
        return view('directeur.enseignantMissionnaire.editerEnseignantMissionnaire', ['directeur' => $directeur, 'enseignant' => $enseignant]);
    }

    public function editerEnseignantMissionnaire(int $idDirecteur, int $idEnseignant, Request $requete){
        $enseignant = EnseignantMissionnaire::findOrFail($idEnseignant);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required'
            ]);
            $enseignant->password = Hash::make($requete->password);
        }

        $donneesValidation = $requete->validate([
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required', 'email', Rule::unique('enseignant_missionnaires')->ignore($idEnseignant)],
            'universite' => ['required']
        ],[
            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'universite.required' => 'l\'université doit être renseignée',

            'email.required' => 'Le email est obligatoire',
            'email.email' => 'Veuillez entrer une adresse email valide',
            'email.unique' => 'L\'adresse '.$requete->email.' est déjà utilisée',
        ]);

        $enseignant->nom = strip_tags($donneesValidation['nom']);
        $enseignant->prenom = strip_tags($donneesValidation['prenom']);
        $enseignant->email = strip_tags($donneesValidation['email']);
        $enseignant->universite = strip_tags($donneesValidation['universite']);
    
        $enseignant->save();
        return redirect()->route('gerer-enseignants-missionnaires', ['id' => $idDirecteur])->with('effectuer', 'Enseignant '. $enseignant->nom.' édité avec succès');
    }
    
    public function supprimerEnseignantMissionnaire(int $idDirecteur, int $idEnseignant){
        $enseignant = EnseignantMissionnaire::findOrFail($idEnseignant);
        $nom = $enseignant->nom;
        $enseignant->delete();
        return back()->with('effectuer', 'Enseignant ' .$nom.' supprimer avec succès');
    }


    /** ETUDIANTS */
    public function gererEtudiants(int $id){
        $directeur = Directeur::findOrFail($id);
        $etudiants = Etudiant::where('directeur_id', '=', $directeur->id)->paginate(5);
        return view('directeur.etudiant.gererEtudiants', ['directeur' => $directeur, 'etudiants' => $etudiants]);
    }

    public function indexAjouterEtudiant(int $id){
        $directeur = Directeur::findOrFail($id);
        return view('directeur.etudiant.ajouterEtudiant', ['directeur' => $directeur]);
    }

    public function ajouterEtudiant(int $id, Request $requete){
        $etudiant = $requete->validate([
            'matricule' => ['required', 'min:8', 'max:8', Rule::unique('etudiants')],
            'nom' => ['required'],
            'prenom' => ['required'],
            'filiere' => ['required'],
            'password' => ['required', 'min:4'],
        ],[
            'matricule.required' => 'Le matricule est obligatoire',
            'matricule.min' => 'Le matricule doit contenir exactement :min chiffres',
            'matricule.max' => 'Le matricule doit contenir exactement :max chiffres',
            'matricule.unique' => 'Le matricule '.$requete->matricule.' est déjà utilisé',

            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'filiere.required' => 'La filière doit être renseignée',

            'password.required' => 'Le mot de passe est obligatoire',
            'password.min' => 'Le mot de passe doit faire au moins :min caractères',
        ]);

        $etudiant['matricule'] = $requete->matricule;
        $etudiant['nom'] = strip_tags($requete->nom);
        $etudiant['prenom'] = strip_tags($requete->prenom);
        $etudiant['filiere'] = strip_tags($requete->filiere);
        $etudiant['password']  = Hash::make($requete->password);
        $etudiant['directeur_id'] = $id;
        
        Etudiant::create($etudiant);
        return redirect()->route('gerer-etudiants', ['id' => $id])->with('effectuer', 'Etudiant '. $requete->nom.' ajouté avec succès');
    }

    public function indexEditerEtudiant(int $idDirecteur, int $idEtudiant){
        $directeur = Directeur::findOrFail($idDirecteur);
        $etudiant = Etudiant::findOrFail($idEtudiant);
        return view('directeur.etudiant.editerEtudiant', ['directeur' => $directeur, 'etudiant' => $etudiant]);
    }

    public function editerEtudiant(int $idDirecteur, int $idEtudiant, Request $requete){
        $etudiant = Etudiant::findOrFail($idEtudiant);
    
        if($requete->modifierPassword == 'on'){
            $requete->validate([
                'password' => 'required'
            ]);
            $etudiant->password = Hash::make($requete->password);
        }
        
        $donneesValidation = $requete->validate([
            'matricule' => ['required', 'min:8', 'max:8', Rule::unique('etudiants')->ignore($idEtudiant)],
            'nom' => ['required'],
            'prenom' => ['required'],
            'filiere' => ['required'],
        ],[
            'matricule.required' => 'Le matricule est obligatoire',
            'matricule.min' => 'Le matricule doit contenir exactement :min chiffres',
            'matricule.max' => 'Le matricule doit contenir exactement :min chiffres',
            'matricule.unique' => 'Le matricule '.$requete->matricule.' est déjà utilisé',

            'nom.required' => 'Le nom est obligatoire',
            'prenom.required' => 'Le prénom est obligatoire',
            'filiere.required' => 'La filière doit être renseignée',
        ]);

        $etudiant->matricule = $donneesValidation['matricule'];
        $etudiant->nom = strip_tags($donneesValidation['nom']);
        $etudiant->prenom = strip_tags($donneesValidation['prenom']);
        $etudiant->filiere = strip_tags($donneesValidation['filiere']);
    
        $etudiant->save();
        return redirect()->route('gerer-etudiants', ['id' => $idDirecteur])->with('effectuer', 'Etudiant '. $etudiant->nom.' édité avec succès');
    }
    
    public function supprimerEtudiant(int $idDirecteur, int $idEtudiant){
        $etudiant = Etudiant::findOrFail($idEtudiant);
        $nom = $etudiant->nom;
        $etudiant->delete();
        return back()->with('effectuer', 'Etudiant ' .$nom.' supprimer avec succès');
    }


    /** COURS LOCAUX */
    public function gererCoursLocaux(int $id){
        $directeur = Directeur::findOrFail($id);
        $infos =  DB::table('cours_locals')
                ->join('ues', 'ues.id', '=', 'cours_locals.ue_id')
                ->join('enseignant_locals', 'enseignant_locals.id', '=', 'cours_locals.enseignant_local_id')
                ->select('cours_locals.id', 'nom', 'prenom', 'intitule', 'masseHoraire','intituleUE', 'semestre', 'filiere', 'ue_id', 'enseignant_local_id', 'credit')
                ->orderby('semestre')
                ->paginate(5);

        return view('directeur.coursLocal.gererCoursLocaux', ['directeur' => $directeur, 'infos' => $infos]);
        return $infos;
    }

    public function indexAjouterCoursLocal(int $id){
        $directeur = Directeur::findOrFail($id);
        $ues = Ue::all();
        $enseignants = EnseignantLocal::where('directeur_id', '=', $directeur->id)->get();
        return view('directeur.coursLocal.ajouterCoursLocal', ['directeur' => $directeur, 'ues' => $ues, 'enseignants' => $enseignants]);
    }

    public function ajouterCoursLocal(int $id, Request $requete){
        $cours = $requete->validate([
            'intituleUC' => ['required'],
            'masseHoraire' => ['required', 'numeric', 'min:1'],
            'semestre' => ['required', 'numeric', 'min:1'],
            'enseignant' => ['required'],
            'filiere' => ['required'],
        ],[
            'intituleUC.required' => 'L\'intitulé du cours est obligatoire',

            'masseHoraire.required' => 'La masse horaire est obligatoire',
            'masseHoraire.numeric' => 'La masse horaire doit être une valeur numérique',
            'masseHoraire.min' => 'La masse horaire doit être >= 1',

            'semestre.required' => 'Le semestre est obligatoire',
            'semestre.numeric' => 'Le semestre doit être une valeur numérique',
            'semestre.min' => 'Le semestre doit être >= 1',
        ]);
    
        $cours['intitule'] = strip_tags($requete->intituleUC);
        $cours['masseHoraire'] = $requete->masseHoraire;
        $cours['semestre'] = $requete->semestre;
        $cours['filiere'] = strip_tags($requete->filiere);
        $cours['enseignant_local_id'] = $requete->enseignant;
        $cours['directeur_id'] = $id;
    
        if($requete->ajouterUE == 'on'){
            $ue = $requete->validate([
                'intituleUE' => ['required'],
                'credit' => ['required'],
            ],[
                'intituleUE.required' => 'L\'intitulé de l\'UE est obligatoire',
    
                'credit.required' => 'Le credit est obligatoire',
                'credit.numeric' => 'Le credit doit être une valeur numérique',
                'credit.min' => 'Le credit doit être >= 1',
            ]);
    
            $ue['intituleUE'] = strip_tags($requete->intituleUE);
            $ue['credit'] = $requete->credit;
            $createdUe = Ue::create($ue);
    
            $cours['ue_id'] = $createdUe->id;
        } else {
            $requete->validate([
                'unite' => ['required'],
            ]);
            $cours['ue_id'] = $requete->unite;
        }
    
        CoursLocal::create($cours);
        return redirect()->route('gerer-cours-locaux', ['id' => $id])->with('effectuer', 'Cours '.$requete->intituleUC.' ajouté avec succès');
    }
    
    public function indexEditerCoursLocal(int $idDirecteur, int $idCours){
        $directeur = Directeur::findOrFail($idDirecteur);
        $cours = CoursLocal::findOrFail($idCours);
        $ues = Ue::all();
        $enseignants = EnseignantLocal::where('directeur_id', '=', $directeur->id)->get();
        $info =  DB::table('cours_locals')
                ->join('ues', 'ues.id', '=', 'cours_locals.ue_id')
                ->join('enseignant_locals', 'enseignant_locals.id', '=', 'cours_locals.enseignant_local_id')
                ->where('cours_locals.id', '=', $idCours)
                ->first();
        return view('directeur.coursLocal.editerCoursLocal', ['directeur' => $directeur, 'cours' => $cours, 'ues' => $ues, 'enseignants' => $enseignants, 'info' => $info]);
        // return $info;
    }

    public function editerCoursLocal(int $idDirecteur, int $idCours, Request $requete){
        $cours = CoursLocal::findOrFail($idCours);

        $requete->validate([
            'intituleUC' => ['required'],
            'masseHoraire' => ['required', 'numeric', 'min:1'],
            'semestre' => ['required', 'numeric', 'min:1'],
            'enseignant' => ['required'],
            'filiere' => ['required'],
        ],[
            'intituleUC.required' => 'L\'intitulé du cours est obligatoire',

            'masseHoraire.required' => 'La masse horaire est obligatoire',
            'masseHoraire.numeric' => 'La masse horaire doit être une valeur numérique',
            'masseHoraire.min' => 'La masse horaire doit être >= 1',

            'semestre.required' => 'Le semestre est obligatoire',
            'semestre.numeric' => 'Le semestre doit être une valeur numérique',
            'semestre.min' => 'Le semestre doit être >= 1',
        ]);
    
        $cours->intitule = strip_tags($requete->intituleUC);
        $cours->masseHoraire = $requete->masseHoraire;
        $cours->semestre = $requete->semestre;
        $cours->filiere = strip_tags($requete->filiere);
        $cours->enseignant_local_id = $requete->enseignant;
        $cours->directeur_id = $idDirecteur;
    
        if($requete->ajouterUE == 'on'){
            $ue = $requete->validate([
                'intituleUE' => ['required'],
                'credit' => ['required', 'numeric', 'min:1'],
            ],[
                'intituleUE.required' => 'L\'intitulé de l\'UE est obligatoire',
    
                'credit.required' => 'Le credit est obligatoire',
                'credit.numeric' => 'Le credit doit être une valeur numérique',
                'credit.min' => 'Le credit doit être >= 1',
            ]);
    
            $ue['intituleUE'] = strip_tags($requete->intituleUE);
            $ue['credit'] = $requete->credit;
            $createdUe = Ue::create($ue);
    
            $cours->ue_id = $createdUe->id;
        } else {
            $requete->validate([
                'unite' => ['required'],
            ]);
            $cours->ue_id = $requete->unite;
        }
        $cours->save();
        return redirect()->route('gerer-cours-locaux', ['id' => $idDirecteur])->with('effectuer', 'Cours '. $cours->intitule.' édité avec succès');
    }
    
    public function supprimerCoursLocal(int $idDirecteur, int $idCours){
        $cours = CoursLocal::findOrFail($idCours);
        $nom = $cours->intitule;
        $cours->delete();
        return back()->with('effectuer', 'Cours ' .$nom.' supprimer avec succès');
    }

    /** COURS DE MISSIONNAIRES */
    public function gererCoursMissionnaires(int $id){
        $directeur = Directeur::findOrFail($id);
        $infos =  DB::table('cours_missions')
                ->join('ues', 'ues.id', '=', 'cours_missions.ue_id')
                ->join('enseignant_missionnaires', 'enseignant_missionnaires.id', '=', 'cours_missions.enseignant_missionnaire_id')
                ->select('cours_missions.id', 'nom', 'prenom', 'intitule', 'masseHoraire','intituleUE', 'semestre', 'filiere', 'ue_id', 'enseignant_missionnaire_id', 'credit')
                ->orderby('semestre')
                ->paginate(5);

        return view('directeur.coursMissionnaire.gererCoursMissionnaires', ['directeur' => $directeur, 'infos' => $infos]);
        return $infos;
    }

    public function indexAjouterCoursMissionnaire(int $id){
        $directeur = Directeur::findOrFail($id);
        $ues = Ue::all();
        $enseignants = EnseignantMissionnaire::where('directeur_id', '=', $directeur->id)->get();
        return view('directeur.coursMissionnaire.ajouterCoursMissionnaire', ['directeur' => $directeur, 'ues' => $ues, 'enseignants' => $enseignants]);
    }

    public function ajouterCoursMissionnaire(int $id, Request $requete){
        $cours = $requete->validate([
            'intituleUC' => ['required'],
            'masseHoraire' => ['required', 'numeric', 'min:1'],
            'semestre' => ['required', 'numeric', 'min:1'],
            'enseignant' => ['required'],
            'filiere' => ['required'],
        ],[
            'intituleUC.required' => 'L\'intitulé du cours est obligatoire',

            'masseHoraire.required' => 'La masse horaire est obligatoire',
            'masseHoraire.numeric' => 'La masse horaire doit être une valeur numérique',
            'masseHoraire.min' => 'La masse horaire doit être >= 1',

            'semestre.required' => 'Le semestre est obligatoire',
            'semestre.numeric' => 'Le semestre doit être une valeur numérique',
            'semestre.min' => 'Le semestre doit être >= 1',
        ]);
    
        $cours['intitule'] = strip_tags($requete->intituleUC);
        $cours['masseHoraire'] = $requete->masseHoraire;
        $cours['semestre'] = $requete->semestre;
        $cours['filiere'] = strip_tags($requete->filiere);
        $cours['enseignant_missionnaire_id'] = $requete->enseignant;
        $cours['directeur_id'] = $id;
    
        if($requete->ajouterUE == 'on'){
            $ue = $requete->validate([
                'intituleUE' => ['required'],
                'credit' => ['required'],
            ],[
                'intituleUE.required' => 'L\'intitulé de l\'UE est obligatoire',
    
                'credit.required' => 'Le credit est obligatoire',
                'credit.numeric' => 'Le credit doit être une valeur numérique',
                'credit.min' => 'Le credit doit être >= 1',
            ]);
    
            $ue['intituleUE'] = strip_tags($requete->intituleUE);
            $ue['credit'] = $requete->credit;
            $createdUe = Ue::create($ue);
    
            $cours['ue_id'] = $createdUe->id;
        } else {
            $requete->validate([
                'unite' => ['required'],
            ]);
            $cours['ue_id'] = $requete->unite;
        }
    
        CoursMission::create($cours);
        return redirect()->route('gerer-cours-missionnaires', ['id' => $id])->with('effectuer', 'Cours '.$requete->intituleUC.' ajouté avec succès');
    }
    
    public function indexEditerCoursMissionnaire(int $idDirecteur, int $idCours){
        $directeur = Directeur::findOrFail($idDirecteur);
        $cours = CoursMission::findOrFail($idCours);
        $ues = Ue::all();
        $enseignants = EnseignantMissionnaire::where('directeur_id', '=', $directeur->id)->get();
        $info =  DB::table('cours_missions')
                ->join('ues', 'ues.id', '=', 'cours_missions.ue_id')
                ->join('enseignant_missionnaires', 'enseignant_missionnaires.id', '=', 'cours_missions.enseignant_missionnaire_id')
                ->where('cours_missions.id', '=', $idCours)
                ->first();
        return view('directeur.coursMissionnaire.editerCoursMissionnaire', ['directeur' => $directeur, 'cours' => $cours, 'ues' => $ues, 'enseignants' => $enseignants, 'info' => $info]);
        // return $info;
    }

    public function editerCoursMissionnaire(int $idDirecteur, int $idCours, Request $requete){
        $cours = CoursMission::findOrFail($idCours);

        $requete->validate([
            'intituleUC' => ['required'],
            'masseHoraire' => ['required', 'numeric', 'min:1'],
            'semestre' => ['required', 'numeric', 'min:1'],
            'enseignant' => ['required'],
            'filiere' => ['required'],
        ],[
            'intituleUC.required' => 'L\'intitulé du cours est obligatoire',

            'masseHoraire.required' => 'La masse horaire est obligatoire',
            'masseHoraire.numeric' => 'La masse horaire doit être une valeur numérique',
            'masseHoraire.min' => 'La masse horaire doit être >= 1',

            'semestre.required' => 'Le semestre est obligatoire',
            'semestre.numeric' => 'Le semestre doit être une valeur numérique',
            'semestre.min' => 'Le semestre doit être >= 1',
        ]);
    
        $cours->intitule = strip_tags($requete->intituleUC);
        $cours->masseHoraire = $requete->masseHoraire;
        $cours->semestre = $requete->semestre;
        $cours->filiere = strip_tags($requete->filiere);
        $cours->enseignant_missionnaire_id = $requete->enseignant;
        $cours->directeur_id = $idDirecteur;
    
        if($requete->ajouterUE == 'on'){
            $ue = $requete->validate([
                'intituleUE' => ['required'],
                'credit' => ['required', 'numeric', 'min:1'],
            ],[
                'intituleUE.required' => 'L\'intitulé de l\'UE est obligatoire',
    
                'credit.required' => 'Le credit est obligatoire',
                'credit.numeric' => 'Le credit doit être une valeur numérique',
                'credit.min' => 'Le credit doit être >= 1',
            ]);
    
            $ue['intituleUE'] = strip_tags($requete->intituleUE);
            $ue['credit'] = $requete->credit;
            $createdUe = Ue::create($ue);
    
            $cours->ue_id = $createdUe->id;
        } else {
            $requete->validate([
                'unite' => ['required'],
            ]);
            $cours->ue_id = $requete->unite;
        }
        $cours->save();
        return redirect()->route('gerer-cours-missionnaires', ['id' => $idDirecteur])->with('effectuer', 'Cours '. $cours->intitule.' édité avec succès');
    }
    
    public function supprimerCoursMissionnaire(int $idDirecteur, int $idCours){
        $cours = CoursMission::findOrFail($idCours);
        $nom = $cours->intitule;
        $cours->delete();
        return back()->with('effectuer', 'Cours ' .$nom.' supprimer avec succès');
    }

}
