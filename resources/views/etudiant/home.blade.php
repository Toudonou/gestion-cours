@extends('etudiant.templates.base')

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
<div class="card shadow mb-4" style="width: min-content; margin: 150px auto;">
    <div class="card-body"  style="width: max-content;">
        <div class="table-responsive">
            <a href="{{route('home-etudiant-local', ['id' => $etudiant->id])}}" class="btn btn-outline-primary me-auto">Cours Locaux</a>
            <a href="{{route('home-etudiant-mission', ['id' => $etudiant->id])}}" class="btn btn-outline-primary me-auto">Cours de Missions</a>
        </div>
    </div>
</div>
@endsection