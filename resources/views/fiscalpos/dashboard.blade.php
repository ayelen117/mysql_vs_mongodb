@extends('admin.layouts.admin')

@section('title', 'Fiscal pos')

@section('content')
    <input type="hidden" id="model" value="fiscalpos">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            Ejemplo de MongoDB
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c0096e3e621dee36e082a72"),</span><br>
                            <span style="margin-left:2em"><strong>number</strong>: "83",</span><br>
                            <span style="margin-left:2em"><strong>pos_type</strong>: "fiscal_printer",</span><br>
                            <span style="margin-left:2em"><strong>alias</strong>: "punto de venta 01",</span><br>
                            <span style="margin-left:2em"><strong>status</strong>: false,</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfb0141e621de04e77fd012",</span><br>
                            <span style="margin-left:2em"><strong>default</strong>: true,</span><br>
                            <span style="margin-left:2em"><strong>fiscaltoken</strong>: ""</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion_mysql" role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne_mysql">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion_mysql" href="#collapseOne_mysql"
                           aria-expanded="true" aria-controls="collapseOne_mysql">
                            Ejemplo de Mysql
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_mysql" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne_mysql">
                    <div class="panel-body" style="overflow: auto;">

                        <code>
                            <span style="margin-left:0em">
                                Tiene muchos: productos<br><br>
                            </span>
                        </code>

                        <code>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>number</th>
                                    <th>pos_type</th>
                                    <th>alias</th>
                                    <th>status</th>
                                    <th>company_id</th>
                                    <th>default</th>
                                    <th>fiscaltoken</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>83</td>
                                    <td>fiscal_printer</td>
                                    <td>punto de venta 01</td>
                                    <td>0</td>
                                    <td>2</td>
                                    <td>1</td>
                                    <td></td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                            </table>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            @include('partials.dashboard.panel_graphs')
        </div>
    </div>
    <div class="row">
        @include('partials.dashboard.crud_graphs', ['type' => 'reading', 'name' => 'Lectura'])
        @include('partials.dashboard.crud_graphs', ['type' => 'insertion', 'name' => 'Inserción'])
    </div>
    <div class="row">
        @include('partials.dashboard.crud_graphs', ['type' => 'update', 'name' => 'Actualización'])
        @include('partials.dashboard.crud_graphs', ['type' => 'deleting', 'name' => 'Eliminación'])
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    {{ Html::script('js/crud_graphs.js') }}
@endsection
