@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" id="general">
                <div class="form-group">
                    <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                        Cantidad de registros
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                    </div>
                </div>

                <div class="form-group center-block">
                    <div class="col-md-12">
                        <input type="reset" class="btn btn-primary" value="Reset">
                        <input type="button" class="btn btn-success" href="javascript:;" onclick="addAllDatasets( $('#general .qty:first-child').val());return false;" value="Calcular"/>
                        <input type="button" class="btn btn-success" href="javascript:;" onclick="removeAllDatasets();return false;" value="Eliminar"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12" id="insertion">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Insertion<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {{--<h4>App Versions</h4>--}}
                    {{ Form::open(['route'=>['entities.store'],'method' => 'post','class'=>'form-horizontal form-label-left']) }}

                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                            Cantidad de registros
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                            Generar registros aleatorios
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="checkbox" class="random_data" name="random_data"/>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <canvas id="insertionChart"></canvas>
                        <div class="result"></div>
                    </div>

                    <input type="hidden" class="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
                    <input type="hidden" class="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
                    <input type="hidden" class="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
                    @if(isset($comparison['mongo']['time']))
                        {{$comparison['mongo']['time']}}
                    @endif
                    <div class="form-group center-block">
                        <div class="col-md-12">
                            <input type="reset" class="btn btn-primary" value="Reset">
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset( $('#insertion .qty:first-child').val(), $('#insertion .random-data:first-child').val(), 'insertion');return false;" value="Calcular"/>
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData('insertion');return false;" value="Eliminar"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>


        <div class="col-sm-6 col-xs-12" id="update">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {{--<h4>App Versions</h4>--}}
                    {{ Form::open(['route'=>['entities.store'],'method' => 'post','class'=>'form-horizontal form-label-left']) }}

                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                            Cantidad de registros
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <canvas id="updateChart"></canvas>
                        <div class="result"></div>
                    </div>

                    <input type="hidden" class="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
                    <input type="hidden" class="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
                    <input type="hidden" class="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
                    @if(isset($comparison['mongo']['time']))
                        {{$comparison['mongo']['time']}}
                    @endif
                    <div class="form-group center-block">
                        <div class="col-md-12">
                            <input type="reset" class="btn btn-primary" value="Reset">
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset( $('#update .qty:first-child').val(), $('#insertion .random_data:first-child').val(), 'update');return false;" value="Calcular"/>
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData('update');return false;" value="Eliminar"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-6 col-xs-12" id="reading">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Reading<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {{--<h4>App Versions</h4>--}}
                    {{ Form::open(['route'=>['entities.store'],'method' => 'post','class'=>'form-horizontal form-label-left']) }}

                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                            Cantidad de registros
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <canvas id="readingChart"></canvas>
                        <div class="result"></div>
                    </div>

                    <input type="hidden" class="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
                    <input type="hidden" class="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
                    <input type="hidden" class="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
                    @if(isset($comparison['mongo']['time']))
                        {{$comparison['mongo']['time']}}
                    @endif
                    <div class="form-group center-block">
                        <div class="col-md-12">
                            <input type="reset" class="btn btn-primary" value="Reset">
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset( $('#reading .qty:first-child').val(), $('#reading .random-data:first-child').val(), 'reading');return false;" value="Calcular"/>
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData('reading');return false;" value="Eliminar"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xs-12" id="deleting">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Delete<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Settings 1</a>
                                </li>
                                <li><a href="#">Settings 2</a>
                                </li>
                            </ul>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    {{--<h4>App Versions</h4>--}}
                    {{ Form::open(['route'=>['entities.store'],'method' => 'post','class'=>'form-horizontal form-label-left']) }}

                    <div class="form-group">
                        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
                            Cantidad de registros
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="lala" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <canvas id="deletingChart"></canvas>
                        <div class="result"></div>
                    </div>

                    <input type="hidden" class="mongo_time" name="mongo_time" value="@if(isset($comparison['mongo']['time'])) {{$comparison['mongo']['time']}} @endif">
                    <input type="hidden" class="mysql_time" name="mysql_time" value="@if(isset($comparison['mysql']['time'])) {{$comparison['mysql']['time']}} @endif">
                    <input type="hidden" class="last_qty" name="last_qty" value="@if(isset($comparison['qty'])) {{$comparison['qty']}} @endif">
                    @if(isset($comparison['mongo']['time']))
                        {{$comparison['mongo']['time']}}
                    @endif
                    <div class="form-group center-block">
                        <div class="col-md-12">
                            <input type="reset" class="btn btn-primary" value="Reset">
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset( $('#deleting .qty:first-child').val(), $('#deleting .random_data:first-child').val(), 'deleting');return false;" value="Calcular"/>
                            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData('deleting');return false;" value="Eliminar"/>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    <script>

        var insertion_ctx = document.getElementById('insertionChart').getContext('2d');
        var insertion_chart = new Chart(insertion_ctx, {
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

        var update_ctx = document.getElementById('updateChart').getContext('2d');
        var update_chart = new Chart(update_ctx, {
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

        var reading_ctx = document.getElementById('readingChart').getContext('2d');
        var reading_chart = new Chart(reading_ctx, {
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

        var deleting_ctx = document.getElementById('deletingChart').getContext('2d');
        var deleting_chart = new Chart(deleting_ctx, {
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

        var datasets = ['insertion', 'update', 'reading', 'deleting'];

        function addAllDatasets(qty){
            datasets.forEach(function(dataset) {
                addDataset( qty, false, dataset);
            });
        }

        function removeAllDatasets(){
            datasets.forEach(function(dataset) {
                removeData(dataset);
            });
        }

        function addDataset(qty, random_data, id){

            console.log('Adding '+id+' dataset.');
            var data = {
                "qty" : qty,
                "random_data" : random_data
            };

            var type;
            var parameter = '';
            switch(id) {
                case 'insertion':
                    type = 'post';
                    break;
                case 'update':
                    type = 'put';
                    parameter = '/1';
                    break;
                case 'reading':
                    type = 'get';
                    break;
                case 'deleting':
                    type = 'delete';
                    parameter = '/1';
                    break;
                default:
                    type = 'get';
            }

            $.ajax({
                data:  data,
                url:   'api/entities' + parameter,
                type:  type,
                beforeSend: function () {
                    $("#"+id+" .result").html("Procesando, espere por favor...");
                },
                success:  function (response) {
                    $("#"+id+" .result").html("");
                    var mongo_time = response.mongo.time;
                    var mysql_time = response.mysql.time;
                    var qty = response.data;
                    var chart_name = window[id + '_chart'];
                    addData(chart_name, qty, [mongo_time,mysql_time])
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

        function removeData(id) {
            console.log('Removing last '+id+' dataset.');
            var chart = window[id + '_chart'];
            chart.data.labels.pop();
            chart.data.datasets.forEach(function(dataset) {
                dataset.data.pop();
            });
            chart.update();
        }

    </script>
@endsection
