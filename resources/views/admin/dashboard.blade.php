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
                    <input type="checkbox" id="random-data" name="random-data"/>
                </div>
            </div>

            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                <canvas id="myChart"></canvas>
            </div>

            <input type="hidden" id="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
            <input type="hidden" id="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
            <input type="hidden" id="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
            @if(isset($comparison['mongo']['time']))
                {{$comparison['mongo']['time']}}
            @endif
            <div class="form-group">
                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                    <a class="btn btn-primary" href="{{ URL::previous() }}">Reset</a>
                    <button type="submit" class="btn btn-success"> Enviar</button>
                </div>
            </div>
            {{ Form::close() }}

            <div>
                <pre>
                    @if(isset($comparison['data'])) {{json_decode(json_encode($comparison['data']), true)}} @endif
                </pre>
            </div>
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
                labels: ["Insertion " + qty, 'Other'],
                datasets: [
//                        {
//                    label: "MongoDB vs MySQL insertion",
//                    backgroundColor: [
//                        '#4BC0C0',
//                        '#FF9F40',
//                    ],
//                    data: [mongo_time, mysql_time],
//                    borderWidth: 0
//                },
                    {
                        label: "MongoDB",
                        backgroundColor: '#4BC0C0',
                        data: [mongo_time, mongo_time],
                    },
                    {
                        label: "MySQL",
                        backgroundColor: '#FF9F40',
                        data: [mysql_time, mysql_time],
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
    </script>
@endsection
