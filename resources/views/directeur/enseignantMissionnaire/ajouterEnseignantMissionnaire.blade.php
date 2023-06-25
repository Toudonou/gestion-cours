@extends('directeur.templates.base')

@section('titre')
Ajouter un enseignant missionnaire
@endsection

@section('coursStatus1')
collapsed
@endsection

@section('enseignantStatus2')
show
@endsection

@section('enseignantMissionStatus')
active
@endsection

@section('contenu')
<!-- DataTales Example -->
<div class="card shadow mb-4" style="max-width: 800px; margin: auto;">
    <div class="card-body">
        <div class="table-responsive">
            <h2 class="center-text mb-4">Ajouter un enseignant missionnaire</h2>
            <form action="{{route('ajouter-enseignant-missionnaire', ['id' => $directeur->id])}}" method="post">
                @csrf
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
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="{{old('email')}}">
                    @if ($errors->has('email'))
                    <p class="text-danger">{{$errors->first('email')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="password">
                    @if ($errors->has('password'))
                    <p class="text-danger">{{$errors->first('password')}}</p>
                    @endif
                </div>

                <div class="mb-3 form-floating">
                    <label for="universite">Université</label>
                    <input type="text" class="form-control" name="universite" id="universite" placeholder="universite" value="{{old('email')}}">
                    @if ($errors->has('universite'))
                    <p class="text-danger">{{$errors->first('universite')}}</p>
                    @endif
                </div>

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