@extends('base')
@section('title', 'bulletin')
@section('content')

<div class="container">
    <div class="row">
        <form action="{{route('admin.infoEtudiant')}}" method="post">
            @csrf
            <div class="mb3">
            <label for="" class="form-label">periode</label>
            <select name="periode" id="" class="form-select">
                <option value="">selctionnez une periode</option>
                <option value="1">semestre 1</option>
                <option value="2">semestre 2</option>
            </select>
            </div>
            <div class="mb3">
                <label for="" class="form-label">filiere</label>
                <select name="filiere" id="" class="form-select">
                    <option value="">selctionnez une filiere</option>
                    @foreach ($filieres as $filiere)
                    <option value="{{$filiere->id}}">{{$filiere->nom}}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb3">
                <label for="" class="form-label">niveau</label>
                <select name="niveau" id="" class="form-select">
                    <option value="">selctionnez un niveau</option>
                    @foreach ($filieres as $filiere)
                    <option value="{{$filiere->niveau}}">{{$filiere->niveau}}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-secondary">envoyer</button>
        </form>
    </div>
</div>


@endsection

