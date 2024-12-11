@extends('base')
@section('content')



<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Bulletin</h1>
            @if ($bulletin->isNotEmpty())
                <h2>{{ $bulletin->first()->nom }} {{ $bulletin->first()->prenom }}</h2>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Matière</th>
                            <th>Note 1</th>
                            <th>Note 2</th>
                            <th>Note Générale</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bulletin as $key => $bull)
                            <tr>
                                <th>{{ $loop->iteration }}</th>
                                <td>{{ $bull->corname }}</td>
                                <td>{{ $bull->note1 }}</td>
                                <td>{{ $bull->note2 }}</td>
                                <td>{{ $bull->notegen }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-end ">
                <strong>Moyenne: {{ $bulletin->first()->moyenne }}</strong>
            </div>
        </div>
</div>












@endsection
