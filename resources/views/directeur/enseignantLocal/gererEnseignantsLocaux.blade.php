@extends('directeur.templates.base')

@section('titre')
Gesion des enseignants locaux
@endsection

@section('coursStatus1')
collapsed
@endsection

@section('enseignantStatus2')
show
@endsection

@section('enseignantLocalStatus')
active
@endsection

@section('contenu')
<h1 class="h3 mb-2 text-gray-800">Liste des enseignants locaux</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="table">
                    <td>Nom</td>
                    <td>Prénoms</td>
                    <td>Email</td>
                    <td>Vacataire</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    @foreach ($enseignants as $enseignant)
                    <tr>
                        <td>{{$enseignant->nom}}</td>
                        <td>{{$enseignant->prenom}}</td>
                        <td style="color: #0066cc;">{{$enseignant->email}}</td>
                        <td class="text-center">{{$enseignant->vacataire == 1 ? "✅" : "❌"}}</td>
                        <td style="display: flex;">
                            <a class="btn btn-outline-primary btn-sm" style="margin-right: 10px;" href="{{route('editer-enseignant-local', ['idDirecteur' => $directeur->id, 'idEnseignant' => $enseignant->id])}}"> Editer</a>
                            <form action="{{route('supprimer-enseignant-local', ['idDirecteur' => $directeur->id, 'idEnseignant' => $enseignant->id])}}" method="post">
                                @method('delete')
                                @csrf
                                <button class="btn btn-outline-danger btn-sm buttonSupprimer" onclick="deleteConfirm(event)">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$enseignants->links('pagination::bootstrap-5')}}
        </div>
    </div>
    <a class="btn btn-outline-primary btn-sm" style="margin: 0 auto; margin-bottom: 10px; margin-top: -10px; max-width: max-content;" href="{{route('ajouter-enseignant-local', ['id' => $directeur->id])}}"> Ajouter un enseignant local</a>
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