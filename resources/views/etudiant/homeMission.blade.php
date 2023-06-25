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
<h1 class="h3 mb-2 text-gray-800">Votre programmation pour les cours de mission</h1>
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
                    <td>Actions</td>
                </thead>
                <tbody>
                    @foreach ($cours as $uc)
                    <tr>
                        <td>{{$uc->intitule}}</td>
                        <td>{{$uc->masseHoraire}}h</td>
                        <td>{{$uc->semestre}}</td>
                        <td>{{$uc->filiere}}</td>
                        <td style="display: flex;">
                            <a class="btn btn-outline-primary btn-sm openFormBtn1" style="margin-right: 20px;" href="{{route('self-cours-etudiant', ['id' => $etudiant->id, 'idCours' => $uc->id, 'type' => 'mission'])}}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 24 24" id="download">
                                    <path d="M21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Zm-9.71,1.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V3a1,1,0,0,0-2,0v9.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                </svg> Cours</a>
                            <a class="btn btn-outline-primary btn-sm openFormBtn2" style="margin-right: -20px;" href="{{route('self-td-etudiant', ['id' => $etudiant->id, 'idCours' => $uc->id, 'type' => 'mission'])}}"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="22" viewBox="0 0 24 24" id="download">
                                    <path d="M21,14a1,1,0,0,0-1,1v4a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V15a1,1,0,0,0-2,0v4a3,3,0,0,0,3,3H19a3,3,0,0,0,3-3V15A1,1,0,0,0,21,14Zm-9.71,1.71a1,1,0,0,0,.33.21.94.94,0,0,0,.76,0,1,1,0,0,0,.33-.21l4-4a1,1,0,0,0-1.42-1.42L13,12.59V3a1,1,0,0,0-2,0v9.59l-2.29-2.3a1,1,0,1,0-1.42,1.42Z"></path>
                                </svg> TD</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$cours->links('pagination::bootstrap-5')}}
        </div>
    </div>
    <div style="margin: 0 auto; margin-bottom: 10px; margin-top: -10px; max-width: max-content;">
        <a class="btn btn-outline-primary btn-sm" href="{{route('home-etudiant-local', ['id' => $etudiant->id])}}">Cours Locaux</a>
        <a class="btn btn-outline-primary btn-sm" href="{{route('home-etudiant-mission', ['id' => $etudiant->id])}}">Cours de Missions</a>
    </div>
</div>

@endsection