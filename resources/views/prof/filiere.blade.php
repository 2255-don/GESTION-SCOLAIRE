<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cards avec Liens et Images</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            width: 18rem;
            margin: 1rem;
        }
        .card-img-overlay {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .card-title {
            color: white;
            font-size: 1.5rem;
        }
        .card:hover{
            transition: all 0.2s;
            /* width: 10%; */
            box-shadow: 0 4px 8px 0 yellowgreen, 0 6px 20px 0;
        }
    </style>
</head>
<body>
    <div class="container card-center">
        <div class="row">
            @foreach ($filiere as $fil )

            <div class="col-md-4">
                <a href="{{route('prof.note')}}" class="text-decoration-none">
                    <div class="card">
                        <img src="https://www.senenews.com/wp-content/uploads/2013/09/IAM.png" class="card-img" alt="Image 1">
                        <div class="card-img-overlay">
                            <h5 class="card-title">{{$fil->nom}}-{{$fil->niveau}}</h5>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach

            {{-- <div class="col-md-4">
                <a href="page2.html" class="text-decoration-none">
                    <div class="card">
                        <img src="image2.jpg" class="card-img" alt="Image 2">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Semestre 2</h5>
                        </div>
                    </div>
                </a>
            </div> --}}
            {{-- <div class="col-md-4">
                <a href="page3.html" class="text-decoration-none">
                    <div class="card">
                        <img src="image3.jpg" class="card-img" alt="Image 3">
                        <div class="card-img-overlay">
                            <h5 class="card-title">Semestre 3</h5>
                        </div>
                    </div>
                </a>
            </div> --}}
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
