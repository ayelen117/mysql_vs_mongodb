
<div class="col-sm-6 col-xs-12" id="{{$type}}">
    <div class="x_panel">
        <div class="x_title">
            <h2>{{ucfirst($type)}}<small></small></h2>
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
                    <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="10" max="" required>
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
                <canvas id="{{$type}}Chart"></canvas>
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
                    <input type="button" class="btn btn-success" href="javascript:;" onclick="addDataset( $('#{{$type}} .qty:first-child').val(), $('#{{$type}} .random-data:first-child').val(), '{{$type}}');return false;" value="Calcular"/>
                    <input type="button" class="btn btn-success" href="javascript:;" onclick="removeData('{{$type}}');return false;" value="Eliminar"/>
                </div>
            </div>
            {{ Form::close() }}

            <div class="row">
                <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion_mysql_query_{{$type}}" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div class="panel-heading" role="tab" id="headingOne">
                            <h4 class="panel-title">
                                <a role="button" data-toggle="collapse" data-parent="#accordion_mysql_query" href="#collapseOne_mysql_query_{{$type}}"
                                   aria-expanded="true" aria-controls="collapseOne_mysql_query_{{$type}}">
                                    MySQL query
                                </a>
                            </h4>
                        </div>
                        <div id="collapseOne_mysql_query_{{$type}}" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <code>
                                    <span class="query" style="margin-left:0em"></span><br>
                                </code>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
