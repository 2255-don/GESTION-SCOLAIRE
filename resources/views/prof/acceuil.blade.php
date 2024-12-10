<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Card de Sélection de Semestre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 24rem;
        }
        .card-icon {
            font-size: 4rem;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container card-center">
        <div class="card text-center">
            <div class="card-body">
                <div class="card-icon">
                    <i class="bi bi-calendar3"></i> <!-- Utilisation de l'icône Bootstrap -->
                </div>
                <h5 class="card-title mt-3">Sélectionnez un Semestre</h5>
                <form action="{{route('prof.filiere')}}" method="POST">
                    @csrf
                    {{-- <input type="hidden" name=""> --}}
                <select class="form-select mt-3" aria-label="Sélectionnez un semestre" name="periode">
                    <option selected>Choisir...</option>
                    <option value="1">Semestre 1</option>
                    <option value="2">Semestre 2</option>
                    <option value="3">Semestre 3</option>
                    <option value="4">Semestre 4</option>
                </select>
                <button class="btn btn-primary mt-3" type="submit">Valider</button>
            </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
