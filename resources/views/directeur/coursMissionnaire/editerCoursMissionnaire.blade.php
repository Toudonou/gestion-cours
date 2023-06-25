@extends('directeur.templates.base')

@section('titre')
    Editer un cours de mission
@endsection

@section('coursStatus2')
show
@endsection

@section('coursMissionStatus')
active
@endsection

@section('enseignantStatus1')
collapsed
@endsection


@section('contenu')
<div class="card shadow mb-4" style="max-width: 800px; margin: auto;">
    <div class="card-body">
        <div class="table-responsive">
            <h2 class="center-text mb-4">Editer un cours de mission</h2>
            <form action="{{route('editer-cours-missionnaire', ['idDirecteur' => $directeur->id, 'idCours' => $cours->id])}}" method="post">
                @csrf
                <div class="mb-3 form-floating">
                    <label for="intituleUC">Intitulé du cours</label>
                    <input type="text" class="form-control" name="intituleUC" id="intituleUC" placeholder="analyse différentielle" value="{{$info->intitule}}">
                    @if ($errors->has('intituleUC'))
                    <p class="text-danger">{{$errors->first('intituleUC')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="masseHoraire">Masse Horaire</label>
                    <input type="number" class="form-control" name="masseHoraire" id="masseHoraire" placeholder="30h" value="{{$info->masseHoraire}}">
                    @if ($errors->has('masseHoraire'))
                    <p class="text-danger">{{$errors->first('masseHoraire')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="semestre">Semestre</label>
                    <input type="number" class="form-control" name="semestre" id="semestre" placeholder="1" value="{{$info->semestre}}">
                    @if ($errors->has('semestre'))
                    <p class="text-danger">{{$errors->first('semestre')}}</p>
                    @endif
                </div>

                <label for="filiere">Filière</label>
                <select class="form-control form-control-user" id="filiere" name="filiere" style="margin-bottom: 20px;" value="{{old('filiere')}}" required>
                    <option value="{{$info->filiere}}" selected>{{$info->filiere}}</option>
                    <option value="Informatique">Informatique</option>
                    <option value="Mathématiques">Mathématiques</option>
                    <option value="Physque">Physique</option>
                    @if ($errors->has('filiere'))
                    <p class="text-danger">{{$errors->first('filiere')}}</p>
                    @endif
                </select>

                <label for="filiere" style="margin-top: 10px">Choix de l'enseignant</label>
                <select class="form-control form-control-user" id="enseignant" name="enseignant" style="margin-bottom: 20px;" value="{{old('enseignant')}}" required>
                    <option value="{{$info->enseignant_missionnaire_id}}" selected>{{$info->nom}} {{$info->prenom}}</option>
                    @foreach ($enseignants as $enseignant)
                    <option value="{{$enseignant->id}}">{{$enseignant->nom}} {{$enseignant->prenom}}</option>
                    @endforeach
                    @if ($errors->has('enseignant'))
                    <p class="text-danger">{{$errors->first('enseignant')}}</p>
                    @endif
                </select>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="ajouterUE" id="ajouterUE">
                    <label class="form-check-label" for="ajouterUE">Ajouter une nouvelle UE</label>
                </div>
                <select class="form-control form-control-user" id="unite" name="unite" style="margin-bottom: 20px;">
                    <option value="{{$info->ue_id}}" selected>{{$info->intituleUE}}</option>
                    @foreach ($ues as $ue)
                    <option value="{{$ue->id}}">{{$ue->intituleUE}}</option>
                    @endforeach
                    @if ($errors->has('unite'))
                    <p class="text-danger">{{$errors->first('unite')}}</p>
                    @endif
                </select>
                <div class="mb-3 form-floating hidden" id="newUE">
                    <div class="mb-3 form-floating">
                        <label for="intituleUE">Intitulé de l'UE</label>
                        <input type="text" class="form-control" name="intituleUE" id="intituleUE" placeholder="intitulé de l'UE" value="{{old('intituleUE')}}">
                        @if ($errors->has('intituleUE'))
                        <p class="text-danger">{{$errors->first('intituleUE')}}</p>
                        @endif
                    </div>
                    <div class="mb-3 form-floating">
                        <input type="number" class="form-control" name="credit" id="credit" placeholder="3" value="{{old('credit')}}">
                        <label for="credit">Crédit de l'UE</label>
                        @if ($errors->has('credit'))
                        <p class="text-danger">{{$errors->first('credit')}}</p>
                        @endif
                    </div>
                </div>

                <!-- Aligner les boutons Annuler et Enregistrer diamétralement opposés -->
                <div class="align-center mt-4">
                    <a href="{{route('gerer-cours-missionnaires', ['id' => $directeur->id])}}" class="btn btn-outline-danger me-auto" style="float: left;">Annuler</a>
                    <button type="submit" class="btn btn-outline-primary btn-lg" style="width: max-content; padding: 5px; font-size: large; float: right;">Enregistrer</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection