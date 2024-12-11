@extends('base')
@section('title', 'gestion des cours')
@section('content')
@if(session('success'))
<div class="alert alert-success">
 {{ session('success') }}
</div>
@endif




<div class="container">
    <div class="row g-3 d-flex flex-inline">
        <div class="col-6">
            <h2>Liste des utilisateurs</h2>
            <table class="table table-bordered"
                   id="table"
                   data-toggle="table"
                   data-pagination="true"
                   data-search="true"
                   data-sortable="true">
                <thead>
                    <tr>
                        <th data-field="col">#</th>
                        <th data-field="nom">nom</th>
                        <th data-field="niveau">niveau</th>
                        {{-- <th data-field="cour">cour</th> --}}
                        {{-- <th data-field="email">email</th> --}}
                        {{-- <th data-field="password">mot de passe ,,,</th> --}}
                        {{-- <th data-field="libelle">profil</th> --}}
                    {{-- @foreach ($users as $key=> $us) --}}

                       {{-- @if ($us->enseignts_id || $us->etudiants_id) --}}
                       {{-- <th data-field="matricule">matricule</th> --}}

                       {{-- @endif --}}
                    {{-- @endforeach --}}
                        <th dta-field="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($filieres as $key=> $fil)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{$fil->nom}}</td>
                        <td>{{$fil->niveau}}</td>
                        {{-- <td class="{{ $loop->index % 3 === 0 ? 'couleur1' : ($loop->index % 3 === 1 ? 'couleur2' : 'couleur3') }}">
                            {{ $fil->cour->nom }}
                        </td> --}}
                        <td>
                            <a class="btn btn-secondary m-1 p-1" href="{{ route('admin.filiere', ['id' => $fil->id]) }}"><i class="fas fa-edit"></i></a>
                            {{-- <a class="btn btn-secondary m-1 p-1" href="{{ route('admin.filiere', ['id' => $fil->cId]) }}"><i class="fas fa-edit"></i></a> --}}
                            <form action="{{ route('user.delateFiliere', ['id' => $fil->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger m-1 p-1"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <form action="{{route('user.filiereStore')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$filiere->id ?? ''}}">
                <div class="mb-3">
                    <label class="form-label" for="nom">nom de la filière</label>
                    <input class="form-control" type="text" name="nom" id="nom" value="{{$filiere? $filiere->nom : ''}}">
                </div>
                <div class="bm-3">
                    <label for="proffesseur" class="form-label">niveau</label>
                    <select class="form-select" name="niveau">
                        <option value="">veuillez selectionner un niveau</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        {{-- <option @if($filiere->niveau == 1) selected @endif value="3">1</option>
                        <option @if($filiere->niveau == 2) selected @endif value="2">2</option>
                        <option @if($filiere->niveau == 3) selected @endif value="3">3</option> --}}
                    </select>
                </div>
                <div class="mb-3 d-flex justify-content-end">
                    <button class="btn btn-primary col-sm-4 m-1 " type="submit">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
