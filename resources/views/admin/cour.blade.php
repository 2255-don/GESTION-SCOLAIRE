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
        <div class="col-lg-4">
            <h2>Liste des utilisateurs</h2>
            <table class="table table-bordered"
                   id="table"
                   data-toggle="table"
                   {{-- data-pagination="true" --}}
                   data-search="true"
                   data-sortable="true">
                <thead>
                    <tr>
                        <th data-field="col">#</th>
                        <th data-field="courname">nom</th>
                        <th data-field="nom">proffesseur</th>
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
                    @foreach ($cours as $key=> $us)
                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{$us->courname}}</td>
                        <td>{{$us->userfirstname}} {{$us->username}}</td>
                        <td>
                            <a class="btn btn-secondary m-1 p-1" href="{{ route('user.cour', ['id' => $us->cId]) }}"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('user.delateCour', ['id' => $us->cId]) }}" method="POST" style="display:inline;">
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
        <div class="col-md-4 offset-md-1 mt-5">
            <form action="{{route('user.courStore')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$cour->id ?? ''}}">
                <div class="mb-3">
                    <label class="form-label" for="nom">nom du cour</label>
                    <input class="form-control" type="text" name="nom" id="nom" value="{{$cour? $cour->nom : ''}}">
                </div>
                <div class="bm-3">
                    <label for="proffesseur" class="form-label">proffesseur</label>
                    <select class="form-select" name="prof" value= "{{$cour ? $cour->enseignants_id : ''}}">
                        <option value="">veuillez selectionner un proffesseur</option>
                        @foreach ($users as $user)
                        <option value="{{$user->ids}}" @if(isset($cour) && $cour->enseignants_id == $user->ids) selected
                        @endif> {{$user->nom}} {{$user->prenom}}</option>
                        @endforeach
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

