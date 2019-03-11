@extends('admin.layouts.admin')

@section('title', 'Users')

@section('content')
    <input type="hidden" id="model" value="users">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion_mongo" role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne_mongo">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion_mongo" href="#collapseOne_mongo"
                           aria-expanded="true" aria-controls="collapseOne_mongo">
                            MongoDB example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne_mongo" class="panel-collapse collapse" role="tabpanel"
                     aria-labelledby="headingOne_mongo">
                    <div class="panel-body">

                        <code>
                            <span style="margin-left:0em">
                                Tiene muchas/os: compañías, productos, documentos y entidades.<br><br>
                            </span>
                        </code>

                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5bcba1aee621de24cb5ab894"),</span><br>
                            <span style="margin-left:2em"><strong>first_name</strong>: "Daenerys",</span><br>
                            <span style="margin-left:2em"><strong>last_name</strong>: "Targaryen",</span><br>
                            <span style="margin-left:2em"><strong>email</strong>: "daenerys.targaryen@example.org",</span><br>
                            <span style="margin-left:2em"><strong>password</strong>: "$2y$10$aPdVffSp0/20ecvv8PdACOhMjetmqI.A8gNdIxvFwILo0bso6o6qO",</span><br>
                            <span style="margin-left:2em"><strong>remember_token</strong>: "MYY53YLxnv",</span><br>
                            <span style="margin-left:2em"><strong>activated</strong>: 1,</span><br>
                            <span style="margin-left:2em"><strong>banned</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>super_admin</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>activation_code</strong>: null,</span><br>
                            <span style="margin-left:2em"><strong>activated_at</strong>: "2018-11-21 00:00:00",</span><br>
                            <span style="margin-left:2em"><strong>last_login</strong>: "2018-11-22 12:42:00"</span><br>
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
                                Tiene muchas/os: compañías, productos, documentos y entidades.<br><br>
                            </span>
                        </code>

                        <code>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>first_name</th>
                                    <th>last_name</th>
                                    <th>email</th>
                                    {{--<th>entity_id</th>--}}
                                    <th>password</th>
                                    <th>remember_token</th>
                                    <th>activated</th>
                                    <th>banned</th>
                                    <th>super_admin</th>
                                    <th>activation_code</th>
                                    <th>activated_at</th>
                                    <th>last_login</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>7</td>
                                    <td>Daenerys</td>
                                    <td>Targaryen</td>
                                    <td>daenerys.targaryen@example.org</td>
                                    {{--<td>NULL</td>--}}
                                    <td>$2y$10$aPdVffSp0/20ecvv8PdACOhMjetmqI.A8gNdIxvFwILo0bso6o6qO</td>
                                    <td>MYY53YLxnv</td>
                                    <td>1</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>NULL</td>
                                    <td>2019-03-06 00:00:00</td>
                                    <td>2019-03-07 03:38:40</td>
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
