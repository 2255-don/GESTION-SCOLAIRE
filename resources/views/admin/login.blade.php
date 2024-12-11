@extends('layout.head')
@if(session('success'))
<div class="alert alert-success">
 {{ session('success') }}
</div>
@endif
    <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-3">
            <h2>veuillez vous authentifié</h2>
            <form action="{{route('user.login')}}" method="post">
                @csrf
                <div class="bm-3">
                    <label class="form-label" for="nom">email</label>
                    <input class="form-control" type="email" name="email">
                    @error('email')
                        {{$message}}
                    @enderror
                </div>
                <div class="bm-3">
                    <label class="form-label" for="nom">mot de passe</label>
                    <input class="form-control" type="password" name="password">
                    @error('password')
                        {{$message}}
                    @enderror
                </div>
            <button class="btn btn-secondary m-3">enregistrer</button>
            </form>
        </div>
    </div>
