@extends('enseignantMissionnaire.templates.base')


@section('titre')
Gesion des supports de TDs
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
<h1 class="h3 mb-2 text-gray-800">Liste de vos supports de TDs</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead class="table">
                    <td>Nom</td>
                    <td>Cours</td>
                    <td>Filière</td>
                    <td>Actions</td>
                </thead>
                <tbody>
                    @foreach ($suppCours as $sc)
                    <tr>
                        <td>{{$sc->nom}}</td>
                        <td>{{$sc->intitule}}</td>
                        <td>{{$sc->filiere}}</td>
                        <td style="display: flex;">
                            <form action="{{route('self-enseignant-local-supprimer-td', ['id' => $enseignant->id, 'idTd' => $sc->id])}}" method="post">
                                @method('delete')
                                @csrf
                                <button class="btn btn-outline-danger btn-sm buttonSupprimer" onclick="deleteConfirm(event)">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{$suppCours->links('pagination::bootstrap-5')}}
        </div>
    </div>
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