@extends('base')
@section('title', 'gestion des cours')
@section('content')
@if(session('success'))
<div class="alert alert-success">
 {{ session('success') }}
</div>
@endif

<div class="container mt-5">
    <nav>
        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
            @foreach($niveaux as $index => $niveauFiliere)
                <button class="nav-link {{$index==0 ? 'active' : ''}}" id="nav-{{$niveauFiliere['slug']}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$niveauFiliere['slug']}}" type="button" role="tab" aria-controls="nav-{{$niveauFiliere['slug']}}" aria-selected="{{$index ==0 ? 'true' : 'false'}}">{{$niveauFiliere['niveau']}} - {{$niveauFiliere['filiere']}}</button>
            @endforeach
        </div>
    </nav>
    <div class="tab-content">
        @foreach($niveaux as $index => $niveauFiliere)
            <div class="tab-pane fade {{$index == 0 ? 'show active' : ''}}" id="nav-{{$niveauFiliere['slug']}}" role="tabpanel" aria-labelledby="nav-{{$niveauFiliere['slug']}}-tab" tabindex="0">
                <table class="table table-bordered">
                    <h2 class="mb-4">Emploi du Temps</h2>
                    <thead>
                        <tr>
                            @foreach ($jours as $jour)
                                <th>{{$jour}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($jours as $jour)
                                <td>
                                    @foreach ($emploisDuTemps[$jour] as $plan)
                                        @if ($plan->niveau == $niveauFiliere['niveau'] && $plan->filiere == $niveauFiliere['filiere'])
                                            {{ $plan->date_debut }} - {{ $plan->date_fin }}<br>
                                            {{ $plan->courname }}<br>
                                            {{ $plan->username }} {{ $plan->userfirstname }}<br><br>
                                        @endif
                                    @endforeach
                                </td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>



    <form action="{{route('user.planingStore')}}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{$planing->id ?? ''}}">
        <legend>Disabled fieldset example</legend>
        <div class="mb-3">
            <label for="disabledSelect" class="form-label">choisissez un jour</label>
            <select id="disabledSelect" class="form-select" name="jour">
                @foreach ($jours as $jour)
                    <option value="{{$jour}} ">{{$jour}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">date debut</label>
            <input type="time" class="form-control" name="date_debut" value="{{$planing ? $planing->date_debut : ''}}">
        </div>
        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">date fin</label>
            <input type="time" class="form-control" name="date_fin" value="{{$planing ? $planing->date_fin : ''}}">
        </div>
        <div class="mb-3">
            <label for="disabledSelect" class="form-label">Disabled select filiere</label>
            <select id="disabledSelect" class="form-select" name="filiere">
                @foreach ($filieres as $filiere)
                    <option value="{{$filiere->id}} ">{{$filiere->nom}} {{$filiere->niveau}}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            @foreach ($cours as $filiere)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="{{$filiere->cId}}" name="cours[]" value="{{$filiere->cId}}">
                    <label class="form-check-label" for="{{$filiere->cId}}">
                        {{$filiere->courname}} par {{$filiere->username}} {{$filiere->userfirstname}}
                    </label>
                </div>
            @endforeach
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection
