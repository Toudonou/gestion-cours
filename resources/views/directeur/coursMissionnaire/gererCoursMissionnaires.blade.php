@extends('directeur.templates.base')

@section('titre')
Gesion des cours de mission
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
<h1 class="h3 mb-2 text-gray-800">Liste des cours de mission</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Intitulé</th>
                        <th>Masse horaire</th>
                        <th>Semestre</th>
                        <th>Filière</th>
                        <th>UE (Crédit)</th>
                        <th>Enseignant</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($infos as $info)
                    <tr>
                        <td>{{$info->intitule}}</td>
                        <td>{{$info->masseHoraire}}h</td>
                        <td>{{$info->semestre}}</td>
                        <td>{{$info->filiere}}</td>
                        <td>{{$info->intituleUE}} ({{$info->credit}})</td>
                        <td>{{$info->nom}} {{$info->prenom}}</td>
                        <td style="display: flex;">
                            <a class="btn btn-outline-primary btn-sm" style="margin-right: 10px;" href="{{route('editer-cours-missionnaire', ['idDirecteur' => $directeur->id, 'idCours' => $info->id])}}"> Editer</a>
                            <form action="{{route('supprimer-cours-missionnaire', ['idDirecteur' => $directeur->id, 'idCours' => $info->id])}}" method="post">
                                @method('delete')
                                @csrf
                                <button class="btn btn-outline-danger btn-sm buttonSupprimer" onclick="deleteConfirm(event)">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$infos->links('pagination::bootstrap-5')}}
        </div>
    </div>
    <a class="btn btn-outline-primary btn-sm" style="margin: 0 auto; margin-bottom: 10px; margin-top: -10px; max-width: max-content;" href="{{route('ajouter-cours-missionnaire', ['id' => $directeur->id])}}"> Ajouter un cours de mission</a>
</div>
<script>
    window.deleteConfirm = function(e) {
            e.preventDefault();
            var form = e.target.form;
            Swal.fire({
                title: 'Etes vous sûre?',
                text: "Cette action est inréversible!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Oui, supprimer!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            })
        }
</script>
@endsection