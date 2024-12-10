@extends('base')
@section('title', 'profil')
@section('content')
@if(session('success'))
<div class="alert alert-success">
 {{ session('success') }}
</div>
@endif
<div class="container">
    <div class="row">
        <div class="col-6">
            <h2>Liste des profiles</h2>
            <table  class="table table-bordered"
                    id="table"
                    data-toggle="table"
                    data-pagination="true"
                    data-search="true"
                    data-sortable="true"
                    data-sortable ="true">
                <thead>
                    <tr>
                        <th data-field="col">#</th>
                        <th data-field="lebelle">profil</th>
                        <th dtat-field="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($profils as $key => $prof)
                    <tr>
                        <td scope="row">{{ $key + 1 }}</td>
                        <td>{{ $prof->libelle }}</td>
                        <td>
                            <a class="btn btn-secondary" href="{{ route('supadmin.profil', ['id' => $prof->id]) }}"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger" href="{{ route('supadmin.deleteProfil', ['id' => $prof->id]) }}"><i class="fas fa-trash"></i></a>
                            {{-- <form action="{{ route('supadmin.deleteProfil', ['id' => $prof->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                            </form> --}}
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="col-6">
            <h2>Formulaire d'ajout</h2>
            <form action="{{route('supadmin.storeprofil')}}" method="post">
                @csrf
                <input type="hidden" name="id" value="{{$profil->id ?? ''}}">
                <div class="mb-3">
                    <label for="libelle">Profil</label>
                    <input type="text" name="libelle" id="libelle" value="{{$profil ? $profil->libelle : ''}}">
                </div>
                <button type="submit" class="btn btn-secondary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection
