@extends('enseignantMissionnaire.templates.base')

@section('titre')
Acceuil
@endsection

@section('dashboard')
active
@endsection

@section('coursStatus1')
collapsed
@endsection

@section('enseignantStatus1')
collapsed
@endsection

@section('contenu')
<h1 class="h3 mb-2 text-gray-800">Votre programmation</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            @if ($errors->has('nom'))
            <p class="text-danger">{{$errors->first('nom')}}</p>
            @endif
            @if ($errors->has('fichier'))
            <p class="text-danger">{{$errors->first('fichier')}}</p>
            @endif
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="table">
                    <td>Intitulé</td>
                    <td>Masse Horaire</td>
                    <td>Semestre</td>
                    <td>Filière</td>
                    <td>UE (Crédit)</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    @foreach ($cours as $uc)
                    <tr>
                        <td>{{$uc->intitule}}</td>
                        <td>{{$uc->masseHoraire}}</td>
                        <td>{{$uc->semestre}}</td>
                        <td>{{$uc->filiere}}</td>
                        <td>{{$uc->intituleUE}} ({{$uc->credit}})</td>
                        <div id="popupForm1" class="popup hidden">
                            <div class="card shadow mb-4" style="max-width: max-content; margin: -100px auto;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h2 class="center-text mb-4">Support de cours</h2>
                                        <form action="{{route('self-enseignant-missionnaire-upload-cours', ['idEnseignant' => $enseignant->id, 'idCours' => $uc->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3 form-floating">
                                                <label for="fichier">Fichier</label>
                                                <input type="file" class="form-control" name="fichier" id="fichier" required>

                                            </div>
                                            <!-- Aligner les boutons Annuler et Enregistrer diamétralement opposés -->
                                            <div class="align-center mt-4">
                                                <a href="#" class="btn btn-outline-danger me-auto" id="closeFormBtn" style="float: left;">Annuler</a>
                                                <button type="submit" class="btn btn-outline-primary btn-lg" style="width: max-content; padding: 5px; font-size: large; float: right;">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="popupForm2" class="popup hidden">
                            <div class="card shadow mb-4" style="max-width: max-content; margin: -100px auto;">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <h2 class="center-text mb-4">Ajouter un TD</h2>
                                        <form action="{{route('self-enseignant-missionnaire-upload-td', ['idEnseignant' => $enseignant->id, 'idCours' => $uc->id])}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3 form-floating">
                                                <label for="fichier">Fichier</label>
                                                <input type="file" class="form-control" name="fichier" id="fichier" required>

                                            </div>
                                            <!-- Aligner les boutons Annuler et Enregistrer diamétralement opposés -->
                                            <div class="align-center mt-4">
                                                <a href="#" class="btn btn-outline-danger me-auto" id="closeFormBtn2" style="float: left;">Annuler</a>
                                                <button type="submit" class="btn btn-outline-primary btn-lg" style="width: max-content; padding: 5px; font-size: large; float: right;">Enregistrer</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <td style="display: flex;">
                            <a class="btn btn-outline-primary btn-sm openFormBtn1" style="margin-right: 20px;" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" id="upload">
                                    <path fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 16v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-3M14 5l-4-4-4 4M10 1v14"></path>
                                </svg> Cours</a>
                            <a class="btn btn-outline-primary btn-sm openFormBtn2" style="margin-right: -20px;" href="#"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" id="upload">
                                    <path fill="none" fill-rule="evenodd" stroke="#000" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 16v3a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-3M14 5l-4-4-4 4M10 1v14"></path>
                                </svg> TD</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$cours->links('pagination::bootstrap-5')}}
        </div>
    </div>
</div>





<script>
    document.addEventListener("DOMContentLoaded", function() {
        const openFormBtns = document.querySelectorAll(".openFormBtn1");
        const popupForm = document.getElementById("popupForm1");
        const closeFormBtn = document.getElementById("closeFormBtn");

        // Gérer l'ouverture du formulaire
        openFormBtns.forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                popupForm.classList.remove("hidden");
            });
        });

        // Gérer la fermeture du formulaire
        closeFormBtn.addEventListener("click", function() {
            popupForm.classList.add("hidden");
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const openFormBtns = document.querySelectorAll(".openFormBtn2");
        const popupForm = document.getElementById("popupForm2");
        const closeFormBtn = document.getElementById("closeFormBtn2");

        // Gérer l'ouverture du formulaire
        openFormBtns.forEach(function(btn) {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                popupForm.classList.remove("hidden");
            });
        });

        // Gérer la fermeture du formulaire
        closeFormBtn.addEventListener("click", function() {
            popupForm.classList.add("hidden");
        });
    });
</script>

@endsection