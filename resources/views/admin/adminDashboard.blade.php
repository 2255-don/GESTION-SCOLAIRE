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


<style>
#chartdiv {
  width: 100%;
  height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
// https://www.amcharts.com/docs/v5/getting-started/#Root_element
var root = am5.Root.new("chartdiv");

// Set themes
// https://www.amcharts.com/docs/v5/concepts/themes/
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
// https://www.amcharts.com/docs/v5/charts/xy-chart/
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: true,
  panY: true,
  wheelX: "panX",
  wheelY: "zoomX",
  pinchZoomX: true,
  paddingLeft:0,
  paddingRight:1
}));

// Add cursor
// https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
cursor.lineY.set("visible", false);


// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xRenderer = am5xy.AxisRendererX.new(root, {
  minGridDistance: 30,
  minorGridEnabled: true
});

xRenderer.labels.template.setAll({
  rotation: -90,
  centerY: am5.p50,
  centerX: am5.p100,
  paddingRight: 15
});

xRenderer.grid.template.setAll({
  location: 1
})

var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
  maxDeviation: 0.3,
  categoryField: "nom",
  renderer: xRenderer,
  tooltip: am5.Tooltip.new(root, {})
}));

var yRenderer = am5xy.AxisRendererY.new(root, {
  strokeOpacity: 0.1
})

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  maxDeviation: 0.3,
  renderer: yRenderer
}));

// Create series
// https://www.amcharts.com/docs/v5/charts/xy-chart/series/
var series = chart.series.push(am5xy.ColumnSeries.new(root, {
  name: "Series 1",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "id",
  sequencedInterpolation: true,
  categoryXField: "nom",
  tooltip: am5.Tooltip.new(root, {
    labelText: "{valueY}"
  })
}));

series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5, strokeOpacity: 0 });
series.columns.template.adapters.add("fill", function (fill, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});

series.columns.template.adapters.add("stroke", function (stroke, target) {
  return chart.get("colors").getIndex(series.columns.indexOf(target));
});


// Set data
fetch('/fetchdata')
                .then(response => response.json())
                .then(datas => {
                    series.data.setAll(datas);
                    xAxis.data.setAll(datas);
                    series.appear(1000);
                    chart.appear(1000, 100); });




// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()
</script>

<!-- HTML -->
<div id="chartdiv"></div>

@endsection

