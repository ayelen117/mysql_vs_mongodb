@extends('admin.layouts.admin')

@section('title', 'Compañías')

@section('content')
    <input type="hidden" id="model" value="companies">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion_mongo" role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne_mongo">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne_mongo"
                           aria-expanded="true" aria-controls="collapseOne_mongo">
                            MongoDB example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_mongo" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne_mongo">
                    <div class="panel-body">
                        <code>
                            Compañía:<br>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong> :ObjectId("5bfaffb7e621de04e77f74c0"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong> :"Cisco Systems",</span><br>
                            <span style="margin-left:2em"><strong>status</strong> :"activated",</span><br>
                            <span style="margin-left:2em"><strong>user_id</strong> :"5bcba1b4e621de24cb5ab8c1",</span><br>
                            <span style="margin-left:2em"><strong>currencies</strong> :[</span><br>
                            <span style="margin-left:4em">5bfafe66e621de18f119b4bd",</span><br>
                            <span style="margin-left:4em">5bfafe66e621de18f119b4be"</span><br>
                            <span style="margin-left:2em">],</span><br>
                            <span style="margin-left:2em"><strong>abbreviation</strong> :"Cisco",</span><br>
                            <span style="margin-left:2em"><strong>description</strong> :"Cisco es el líder mundial en TI y red. ",</span><br>
                            <span style="margin-left:2em"><strong>cuit</strong> :"2735663969",</span><br>
                            <span style="margin-left:2em"><strong>legal_name</strong> :"Cisco Systems, Inc.",</span><br>
                            <span style="margin-left:2em"><strong>street_name</strong> :" W Tasman",</span><br>
                            <span style="margin-left:2em"><strong>street_number</strong> :175,</span><br>
                            <span style="margin-left:2em"><strong>phone</strong> :"+1 408-526-4000",</span><br>
                            <span style="margin-left:2em"><strong>fiscal_ws</strong> :"",</span><br>
                            <span style="margin-left:2em"><strong>fiscal_ws_status</strong> :0,</span><br>
                            <span style="margin-left:2em"><strong>responsibility_id</strong> :"5bfafe66e621de18f119b4f5"</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                        <br>

                        <code>
                            Monedas:<br>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id </strong> : 5bfafe66e621de18f119b4bd ,</span><br>
                            <span style="margin-left:2em"><strong>name </strong> : "PESOS " ,</span><br>
                            <span style="margin-left:2em"><strong>code_iso </strong> : "ARS" ,</span><br>
                            <span style="margin-left:2em"><strong>code_afip </strong> : "PES" ,</span><br>
                            <span style="margin-left:2em"><strong>symbol </strong> : "" ,</span><br>
                            <span style="margin-left:2em"><strong>quotation_usd </strong> : "15",</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id </strong> : 5bfafe66e621de18f119b4be ,</span><br>
                            <span style="margin-left:2em"><strong>name </strong> : "Dólar ESTADOUNIDENSE  " ,</span><br>
                            <span style="margin-left:2em"><strong>code_iso </strong> : "USD" ,</span><br>
                            <span style="margin-left:2em"><strong>code_afip </strong> : "DOL" ,</span><br>
                            <span style="margin-left:2em"><strong>symbol </strong> : "" ,</span><br>
                            <span style="margin-left:2em"><strong>quotation_usd </strong> : "1",</span><br>
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
                            Mysql example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_mysql" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne_mysql">
                    <div class="panel-body" style="overflow: auto;">

                        <code>
                            <span style="margin-left:0em">
                                Tiene muchas/os: entidades, puntos de venta, productos, categorías, documentos, listas de precios<br><br>
                            </span>
                        </code>

                        <code>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>status</th>
                                    <th>user_id</th>
                                    <th>abbreviation</th>
                                    <th>description</th>
                                    <th>cuit</th>
                                    <th>legal_name</th>
                                    <th>street_name</th>
                                    <th>street_number</th>
                                    <th>responsibility_id</th>
                                    <th>phone</th>
                                    <th>fiscal_ws</th>
                                    <th>fiscal_ws_status</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Cisco Systems</td>
                                    <td>activated</td>
                                    <td>14</td>
                                    <td>Cisco</td>
                                    <td>Cisco es el líder mundial en TI y red.</td>
                                    <td>2735663969</td>
                                    <td>Cisco Systems, Inc.</td>
                                    <td>W Tasman</td>
                                    <td>175</td>
                                    <td>1</td>
                                    <td>+1408-526-4000</td>
                                    <td></td>
                                    <td></td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                            </table>
                        </code>
                        <br>
                        <code>
                            Monedas:<br>
                            <table class="mysql"  border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>code_iso</th>
                                    <th>code_afip</th>
                                    <th>symbol</th>
                                    <th>quotation_usd</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>PESOS</td>
                                    <td>ARS</td>
                                    <td>PES</td>
                                    <td></td>
                                    <td>15</td>
                                    <td>2019-03-07 01:53:35</td>
                                    <td>2019-03-07 01:53:35</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Dólar ESTADOUNIDENSE</td>
                                    <td>USD</td>
                                    <td>DOL</td>
                                    <td></td>
                                    <td>1</td>
                                    <td>2019-03-07 01:53:35</td>
                                    <td>2019-03-07 01:53:35</td>
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
        @include('partials.dashboard.crud_graphs', ['type' => 'reading'])
        @include('partials.dashboard.crud_graphs', ['type' => 'insertion'])
    </div>
    <div class="row">
        @include('partials.dashboard.crud_graphs', ['type' => 'update'])
        @include('partials.dashboard.crud_graphs', ['type' => 'deleting'])
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    {{ Html::script('js/crud_graphs.js') }}
@endsection
