@extends('directeur.templates.base')

@section('titre')
Ajouter un étudiant
@endsection

@section('etudiant')
active
@endsection

@section('coursStatus1')
collapsed
@endsection

@section('enseignantStatus1')
collapsed
@endsection

@section('contenu')
<!-- DataTales Example -->
<div class="card shadow mb-4" style="max-width: 800px; margin: auto;">
    <div class="card-body">
        <div class="table-responsive">
            <h2 class="center-text mb-4">Ajouter un étudiant</h2>
            <form action="{{route('ajouter-etudiant', ['id' => $directeur->id])}}" method="post">
                @csrf
                <div class="mb-3 form-floating">
                    <label for="matricule">Matricule</label>
                    <input type="number" class="form-control" name="matricule" id="matricule" placeholder="Votre matricule..." value="{{old('matricule')}}">
                    @if ($errors->has('matricule'))
                    <p class="text-danger">{{$errors->first('matricule')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="nom" value="{{old('nom')}}">
                    @if ($errors->has('nom'))
                    <p class="text-danger">{{$errors->first('nom')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="prenom">Prénoms</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="prénoms" value="{{old('prenom')}}">
                    @if ($errors->has('prenom'))
                    <p class="text-danger">{{$errors->first('prenom')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password">
                    @if ($errors->has('password'))
                    <p class="text-danger">{{$errors->first('password')}}</p>
                    @endif
                </div>

                <label for="filiere">Filière</label>
                <select class="form-control form-control-user" id="filiere" name="filiere" required>
                    <option value="Informatique" {{ old('filiere') === 'Informatique' ? 'selected' : '' }}>Informatique</option>
                    <option value="Mathématiques" {{ old('filiere') === 'Mathématiques' ? 'selected' : '' }}>Mathématiques</option>
                    <option value="Physique" {{ old('filiere') === 'Physique' ? 'selected' : '' }}>Physique</option>
                </select>
                

                <!-- Aligner les boutons Annuler et Enregistrer diamétralement opposés -->
                <div class="align-center mt-4">
                    <a href="{{route('gerer-enseignants-locaux', ['id' => $directeur->id])}}" class="btn btn-outline-danger me-auto" style="float: left;">Annuler</a>
                    <button type="submit" class="btn btn-outline-primary btn-lg" style="width: max-content; padding: 5px; font-size: large; float: right;">Enregistrer</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection