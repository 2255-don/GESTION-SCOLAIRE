@extends('base')
@section('title','dashboard super-admin')
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
                        <th data-field="prenom">prenom</th>
                        <th data-field="email">email</th>
                        <th data-field="libelle">profil</th>
                        <th data-field="matricule">matricule</th>
                        <th dta-field="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key=> $us)
                        <tr>
                            <th scope="row">{{$loop->iteration}}</th>
                            <td>{{$us->nom}}</td>
                            <td>{{$us->prenom}}</td>
                            <td>{{$us->email}}</td>
                            <td>{{$us->profil->libelle}}</td>
                            <td>{{$us->enseignants_id  ? $us->enseignant->matricule :($us->etudiants_id? $us->etudiant->matricule :'numero non assigné')}}</td>
                            <td><a class="btn btn-secondary m-1 p-1" href="{{ route('admin.dashboard', ['id' => $us->id]) }}"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('supadmin.adminUserDelateUser', ['id' => $us->id]) }}" method="POST" style="display:inline;">
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
            <form action="{{route('supadmin.adminUserStore')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$user->id ?? ''}}">
                <div class="mb-3">
                    <label class="form-label" for="nom">nom</label>
                    <input class="form-control" type="text" name="nom" id="nom" value="{{$user ? $user->nom : ''}}">
                </div>
                <div class="mb-3">
                    <label class="form-label"  for="prenom">prenom</label>
                    <input class="form-control" type="text" name="prenom" value="{{$user ? $user->prenom : ''}}">
                </div>

                <div class="mb-3">
                    <label class="form-label"  for="email">email</label>
                    <input class="form-control" type="email" name="email" value="{{$user ? $user->email : ''}}">
                </div>
                @if (!$user)
                <div class="mb-3">
                    <label class="form-label"  for="password">password</label>
                    <input class="form-control" type="password" name="password" >
                </div>
                @endif
                <div class="bm-3">
                    <label for="profil" class="form-label">profil</label>
                    <select class="form-select" name="profil" value= "{{$user ? $user->profils_id : ''}}">
                        <option value="">veuillez selectionner un profil</option>
                        @foreach ($profils as $profil)
                            <option value="{{$profil->id}}"
                                @if(isset($user) && $user->profils_id == $profil->id)
                                    selected
                                @endif>
                                {{$profil->libelle}}
                            </option>
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

