@extends('base')
@section('content')
<div class="container">
    <div class="row">
        <h2>liete des etudiants</h2>
        <div class="table-responsive">
            <table class="table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>prenom</th>
                        {{-- <th>pSTATUrenom</th> --}}
                        <th>matricule</th>
                        <th>bulletin</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @foreach ($etudiants as $index => $etudiant)
                            <th>{{ $loop->iteration }}</th>
                            <td>{{$etudiant->username}}</td>
                            <td>{{$etudiant->userfirstname}}</td>
                            <td>{{$etudiant->matricule}}</td>
                            <td>{{$etudiant->statut}}</td>
                            <td>
                            <a class="btn btn-secondary m-1 p-1" href="{{ route('admin.show-bulletin', ['id' => $etudiant->id]) }}"><i class="far fa-newspaper"></i></a>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
