<style>
    .col-md-4 { margin-top: 20px; }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@extends('base')
@section('title','dashboard super-admin')
@section('content')
@if(session('success'))
<div class="alert alert-success">
 {{ session('success') }}
</div>
@endif

{{-- <div class="card mb-4">
    <div class="card-header border-0">
        <h3 class="card-title">Products</h3>
        <div class="card-tools"> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-download"></i> </a> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a> </div>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Sales</th>
                    <th>More</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <img src="../../dist/assets/img/default-150x150.png" alt="Product 1" class="rounded-circle img-size-32 me-2">
                        Some Product
                    </td>
                    <td>$13 USD</td>
                    <td> <small class="text-success me-1"> <i class="bi bi-arrow-up"></i>
                            12%
                        </small>
                        12,000 Sold
                    </td>
                    <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                </tr>
                <tr>
                    <td> <img src="../../dist/assets/img/default-150x150.png" alt="Product 1" class="rounded-circle img-size-32 me-2">
                        Another Product
                    </td>
                    <td>$29 USD</td>
                    <td> <small class="text-info me-1"> <i class="bi bi-arrow-down"></i>
                            0.5%
                        </small>
                        123,234 Sold
                    </td>
                    <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                </tr>
                <tr>
                    <td> <img src="../../dist/assets/img/default-150x150.png" alt="Product 1" class="rounded-circle img-size-32 me-2">
                        Amazing Product
                    </td>
                    <td>$1,230 USD</td>
                    <td> <small class="text-danger me-1"> <i class="bi bi-arrow-down"></i>
                            3%
                        </small>
                        198 Sold
                    </td>
                    <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                </tr>
                <tr>
                    <td> <img src="../../dist/assets/img/default-150x150.png" alt="Product 1" class="rounded-circle img-size-32 me-2">
                        Perfect Item
                        <span class="badge text-bg-danger">NEW</span>
                    </td>
                    <td>$199 USD</td>
                    <td> <small class="text-success me-1"> <i class="bi bi-arrow-up"></i>
                            63%
                        </small>
                        87 Sold
                    </td>
                    <td> <a href="#" class="text-secondary"> <i class="bi bi-search"></i> </a> </td>
                </tr>
            </tbody>
        </table>
    </div>
</div> --}}

<div class="app-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7">
                <div class="card mb-4 mt-5">
                    <div class="card-header border-0">
                        <h3 class="card-title">Liste des utilisateurs</h3>
                    <div class="card-tools"> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-download"></i> </a> <a href="#" class="btn btn-tool btn-sm"> <i class="bi bi-list"></i> </a> </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped align-middle"
                                id="table"
                                data-toggle="table"
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
                                    <td>{{$us->profil ? $us->profil->libelle : 'null'}}</td>
                                @if ($us->enseignants_id || $us->etudiants_id)
                                        <td>{{$us->enseignants_id  ? $us->enseignant->matricule :($us->etudiants_id? $us->etudiant->matricule :'numero non assigné')}}</td>
                                    @else
                                    <td>numero non assigné</td>
                                    @endif
                                    <td><a class="btn btn m-1 p-1" href="{{ route('supadmin.user', ['id' => $us->id]) }}"><i class="fas fa-edit text-success"></i></a>
                                        <form action="{{ route('supadmin.deleteProfil', ['id' => $us->id]) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn m-1 p-1"><i class="fas fa-trash text-danger"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-4 offset-md-1 mt-5 ">
                <div class="card mb-4">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">formulaires d'insertion</h3>
                        </div>
                    </div>
                    <div class="car-body p-3">
                        <form action="{{route('supadmin.userStore')}}" method="post">
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
        </div>
    </div>
</div>
{{-- <canvas id="myChart" width="400" height="200"></canvas>

<script>
    const ctx = document.getElementById('myChart').getContext('2d');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Valeurs des Données',
                data: [],
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    }); --}}

    {{-- //tout se passe ici:
    //ses au niveau des items que nous devons mettre les diiferents valeurs qui doivent contenir les données de statistique
    //le premier item, c'est la ligne horizontal. et le deuxieme item, c'est pour la partie verticale --}}
    {{-- // function fetchData() {
    //     fetch('/fetchdata')
    //         .then(response => response.json())
    //         .then(data => {
    //             myChart.data.labels = data.map(item => item.nom);
    //             myChart.data.datasets[0].data = data.map(item => item.id);
    //             myChart.update();
    //             console.log(data);
    //         });

    // }

    // setInterval(fetchData, 5000); // Récupérer des données toutes les 5 secondes --}}
{{-- </script> --}}

@endsection
