@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            {{ Form::open(['route'=>['entities.store'],'method' => 'post','class'=>'form-horizontal form-label-left']) }}

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                    Cantidad de registros
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input id="qty" type="number" class="form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name" >
                    Generar registros aleatorios
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="checkbox" id="random_data" name="random_data"/>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <canvas id="myChart"></canvas>
                <div id="result"></div>
            </div>

            <input type="hidden" id="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
            <input type="hidden" id="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
            <input type="hidden" id="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
            @if(isset($comparison['mongo']['time']))
                {{$comparison['mongo']['time']}}
            @endif
            <div class="form-group center-block">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <input type="reset" class="btn btn-primary" value="Reset">
                    <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset($('#qty').val(), $('#random-data').val());return false;" value="Calcular"/>
                    <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData();return false;" value="Eliminar"/>

                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script>

        var mongo_time = parseFloat(document.getElementById('mongo_time').value);
        var mysql_time = parseFloat(document.getElementById('mysql_time').value);
        var qty = parseInt(document.getElementById('last_qty').value);
        var ctx = document.getElementById('myChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: [],
                datasets: [
                    {
                        label: "MongoDB",
                        backgroundColor: '#4BC0C0',
                        data: [],
                    },
                    {
                        label: "MySQL",
                        backgroundColor: '#FF9F40',
                        data: [],
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero:true
                        }
                    }]
                }
            }
        });

        function addDataset(qty, random_data){
            var data = {
                "qty" : qty,
                "random_data" : random_data
            };
            $.ajax({
                data:  data,
                url:   'api/entities',
                type:  'post',
                beforeSend: function () {
                    $("#result").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                    $("#result").html("");
                    var mongo_time = response.mongo.time;
                    var mysql_time = response.mysql.time;
                    var qty = response.data;
                    addData(chart, qty, [mongo_time,mysql_time])
                }
            });
        }

        function addData(chart, label, data) {
            chart.data.labels.push(label);
            chart.data.datasets.forEach(function(dataset, key, mapObj) {
                dataset.data.push(data[key]);
            });
            chart.update();
        }

        function removeData() {
            chart.data.labels.pop();
            chart.data.datasets.forEach(function(dataset) {
                dataset.data.pop();
            });
            chart.update();
        }

    </script>
@endsection
