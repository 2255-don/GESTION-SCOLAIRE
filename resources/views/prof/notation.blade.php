<script> document.addEventListener('DOMContentLoaded', function() { var filiereSelect = document.getElementById('filiere'); if (filiereSelect) { filiereSelect.addEventListener('change', function() { var filiere = this.value.trim(); if (filiere) { fetch(`/etudiants/${filiere}`) .then(response => response.json()) .then(data => { var matriculeSelect = document.getElementById('matricule'); matriculeSelect.innerHTML = ''; // Vider les options existantes
    data.forEach(etudiant => { var option = document.createElement('option'); option.value = etudiant.id; option.text = etudiant.matricule; matriculeSelect.appendChild(option); }); }) .catch(error => console.error('Erreur:', error)); } }); } }); </script>
    @extends('base')
    @section('title', 'gestion des cours')
    @section('content')
    @if(session('success'))
    <div class="alert alert-success">
     {{ session('success') }}
    </div>
    @endif

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <nav>
                        <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                            @foreach($niveaux as $index => $niveauFiliere)
                                <button class="nav-link {{$index==0 ? 'active' : ''}}" id="nav-{{$niveauFiliere['slug']}}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{$niveauFiliere['slug']}}" type="button" role="tab" aria-controls="nav-{{$niveauFiliere['slug']}}" aria-selected="{{$index ==0 ? 'true' : 'false'}}">{{$niveauFiliere['niveau']}} - {{$niveauFiliere['filiere']}} - {{$niveauFiliere['courname']}}</button>
                            @endforeach
                        </div>
                </nav>
                <div class="tab-content">
                    @foreach($niveaux as $index => $niveauFiliere)
                        <div class="tab-pane fade {{$index == 0 ? 'show active' : ''}}" id="nav-{{$niveauFiliere['slug']}}" role="tabpanel" aria-labelledby="nav-{{$niveauFiliere['slug']}}-tab" tabindex="0">
                            <h2>Liste des utilisateurs</h2>
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0" id="table" data-toggle="table" data-pagination="true" data-search="true" data-sortable="true">
                                    <thead>
                                        <tr>
                                            <th data-field="col">#</th>
                                            <th data-field="nom">nom</th>
                                            <th data-field="prenom">prenom</th>
                                            <th data-field="libelle">profil</th>
                                            <th data-field="matricule">matricule</th>
                                            <th data-field="statut">statut</th>
                                            <th data-field="filiere">filiere</th>
                                            <th data-field="note">notes</th>
                                            <th data-field="notes">notes2</th>
                                            <th data-field="cours">cours</th>
                                            <th data-field="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users->filter(function ($user) use ($niveauFiliere) {
                                            return $user->courname == $niveauFiliere['courname'];
                                        }) as $key => $us)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$us->nom}}</td>
                                                <td>{{$us->prenom}}</td>
                                                <td>{{$us->libelle}}</td>
                                                <td>{{$us->matricule}}</td>
                                                <td>{{$us->satut}}</td>
                                                <td>{{$us->filiere}}</td>
                                                <td>{{$us->note}}</td>
                                                <td>{{$us->notes}}</td>
                                                <td>{{$us->courname}}</td>
                                                <td>
                                                    <a class="btn btn-secondary m-1 p-1" href="{{ route('prof.note', ['id' => $us->noteId]) }}"><i class="fas fa-edit"></i></a>
                                                    {{-- <form action="{{ route('supadmin.adminUserDelateUser', ['id' => $us->id]) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger m-1 p-1"><i class="fas fa-trash"></i></button>
                                                    </form> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            <div class="col-md-4 offset-md-1 mt-5 ">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="noteForm" action="{{route('prof.noteStore')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{$note ? $note->noteId : ''}}">
                    <input type="hidden" name="id_enseignant" value="{{auth()->user()->enseignants_id ?? ''}}">
                    <legend>Disabled fieldset example</legend>
                    {{-- <div class="mb-3">
                        <label for="disabledSelect" class="form-label">choisissez le filiere</label>
                        <select id="filiere" class="form-select" name="filieres">
                            @foreach ($filiere as $jour)
                                <option value="{{$jour->id}} ">{{$jour->nom}} {{$jour->niveau}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- {{-- <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">date debut</label>
                        <input type="time" class="form-control" name="date_debut" value="{{$planing ? $planing->date_debut : ''}}">
                    </div> --}}
                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">note</label>
                        <input type="text" class="form-control" name="note" value="{{ $note ? $note->note : ''}}">
                    </div>
                    <div class="mb-3">
                        <label for="disabledTextInput" class="form-label">note</label>
                        <input type="text" class="form-control" name="note2" value="{{ $note ? $note->notes : ''}}">
                    </div>

                    <div class="mb-3">
                    <select id="filiere" class="form-select" name="filieres" value="{{$note ? $note->filiereId : ''}}">
                        <option value="">hein</option>
                        @foreach ($filiere as $jour)
                            <option value="{{ $jour->id }}"
                            @if (isset($note->filiereId) && $note->filiereId == $jour->id)
                                selected
                            @else
                            @endif>
                            {{ $jour->nom }} {{ $jour->niveau }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <select id="matricule" class="form-select" name="etudiant" value = "">
                        <!-- Les options seront ajoutées dynamiquement -->
                    </select>
                </div>
                    <div class="mb-3">
                        @foreach ($cours as $filiere)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="{{$filiere->cId}}" name="cours" value="{{$filiere->cId}}" @if (isset($note->courId) && $note->courId == $filiere->cId)
                                 @checked(true)
                                @endif>
                                <label class="form-check-label" for="{{$filiere->cId}}">
                                    {{$filiere->courname}}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>


</div>
    <script>

document.addEventListener('DOMContentLoaded', function() {
    var filiereSelect = document.getElementById('filiere');
    var matriculeSelect = document.getElementById('matricule');
    var selectedMatricule = "{{ $note ? $note->etudiants_id : '' }}";

    if (filiereSelect) {
        filiereSelect.addEventListener('change', function() {
            var filiere = this.value.trim();
            if (filiere) {
                fetch(`/etudiants/${filiere}`)
                    .then(response => response.json())
                    .then(data => {
                        matriculeSelect.innerHTML = '';
                        if (Array.isArray(data)) {
                            data.forEach(etudiant => {
                                var option = document.createElement('option');
                                option.value = etudiant.id;
                                option.text = etudiant.matricule;
                                if (etudiant.id == selectedMatricule) {
                                    option.selected = true;
                                }
                                matriculeSelect.appendChild(option);
                            });
                        } else {
                            console.error('La réponse de l\'API n\'est pas un tableau:', data);
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
            }
        });

        // Déclencher l'événement change pour charger les options au chargement de la page si une filière est déjà sélectionnée
        if (filiereSelect.value.trim()) {
            filiereSelect.dispatchEvent(new Event('change'));
        }
    }
});

    </script>


    @endsection
