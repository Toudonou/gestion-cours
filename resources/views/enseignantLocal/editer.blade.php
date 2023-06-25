@extends('enseignantLocal.templates.base')

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
<div class="card shadow mb-4" style="max-width: 800px; margin: auto;">
    <div class="card-body">
        <div class="table-responsive">
            <h2 class="center-text mb-4">Edition</h2>
            <form action="{{route('self-editer-enseignant-local', ['id' => $enseignant->id])}}" method="post">
                @csrf
                <div class="mb-3 form-floating">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" name="nom" id="nom" placeholder="nom" value="{{$enseignant->nom}}" required>
                    @if ($errors->has('nom'))
                    <p class="text-danger">{{$errors->first('nom')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="prenom">Prénoms</label>
                    <input type="text" class="form-control" name="prenom" id="prenom" placeholder="prénoms" value="{{$enseignant->prenom}}" required>
                    @if ($errors->has('prenom'))
                    <p class="text-danger">{{$errors->first('prenom')}}</p>
                    @endif
                </div>
                <div class="mb-3 form-floating">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" value="{{$enseignant->email}}" required>
                    @if ($errors->has('email'))
                    <p class="text-danger">{{$errors->first('email')}}</p>
                    @endif
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" name="modifierPassword" id="modifierPassword">
                    <label class="form-check-label" for="modifierPassword">Modifier le mot de passe</label>
                </div>
                <div class="mb-3 form-floating hidden" id="passwordContainer">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="nouveau mot de passe">
                    @if ($errors->has('password'))
                    <p class="text-danger">{{$errors->first('password')}}</p>
                    @endif
                </div>
                <!-- Aligner les boutons Annuler et Enregistrer diamétralement opposés -->
                <div class="align-center mt-4">
                    <a href="{{route('home-enseignant-local', ['id' => $enseignant->id])}}" class="btn btn-outline-danger me-auto" style="float: left;">Annuler</a>
                    <button type="submit" class="btn btn-outline-primary btn-lg" style="width: max-content; padding: 5px; font-size: large; float: right;">Enregistrer</button>
                </div>
        </div>

        </form>

    </div>
</div>
<script>
    const modifierPasswordCheckbox = document.getElementById('modifierPassword');
    const passwordContainer = document.getElementById('passwordContainer');

    modifierPasswordCheckbox.addEventListener('change', function() {
        if (modifierPasswordCheckbox.checked) {
            passwordContainer.classList.remove('hidden');
        } else {
            passwordContainer.classList.add('hidden');
        }
    });
</script>
@endsection