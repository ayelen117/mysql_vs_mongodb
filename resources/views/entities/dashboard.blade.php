@extends('admin.layouts.admin')

@section('title', 'Entidades')

@section('content')
    <input type="hidden" id="model" value="entities">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion" role="tablist"
             aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            MongoDB example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c0096e2e621dee36e082a70"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "Clifton Leffler",</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfaffb7e621de04e77f8c3b",</span><br>
                            <span style="margin-left:2em"><strong>author_id</strong>: "5bdb8f95e621de6996024637",</span><br>
                            <span style="margin-left:2em"><strong>identification_id</strong>: "5bdb8f95e621de6996024639",</span><br>
                            <span style="margin-left:2em"><strong>identification_number</strong>: "20327936221",</span><br>
                            <span style="margin-left:2em"><strong>contact_name</strong>: "Clifton",</span><br>
                            <span style="margin-left:2em"><strong>street_name</strong>: "Mitre",</span><br>
                            <span style="margin-left:2em"><strong>street_number</strong>: "990",</span><br>
                            <span style="margin-left:2em"><strong>latitude</strong>: "12º 21' 33''",</span><br>
                            <span style="margin-left:2em"><strong>longitude</strong>: "12º 21' 33''",</span><br>
                            <span style="margin-left:2em"><strong>additional_info</strong>: "Hic nulla sint doloribus consequuntur.",</span><br>
                            <span style="margin-left:2em"><strong>email</strong>: "levi.hegmann@hotmail.com",</span><br>
                            <span style="margin-left:2em"><strong>phone</strong>: "(208) 295-0785 x729",</span><br>
                            <span style="margin-left:2em"><strong>pricelist_id</strong>: "5bfafe75e621de04e77f7459",</span><br>
                            <span style="margin-left:2em"><strong>entity_type</strong>: "client",</span><br>
                            <span style="margin-left:2em"><strong>responsibility_id</strong>: "5bfafe66e621de18f119b4ec",</span><br>
                            <span style="margin-left:2em"><strong>observations</strong>: "Ipsum non quidem dolor nesciunt iste.",</span><br>
                            <span style="margin-left:2em"><strong>has_account</strong>: false,</span><br>
                            <span style="margin-left:2em"><strong>balance</strong>: 6943.96,</span><br>
                            <span style="margin-left:2em"><strong>balance_at</strong>: "2018-11-29 00:00:00",</span><br>
                            {{--<span style="margin-left:2em"><strong>parent</strong>: null,</span><br>--}}
                            {{--<span style="margin-left:2em"><strong>children</strong>: [],</span><br>--}}
                            {{--<span style="margin-left:2em"><strong>ancestors</strong>: [],</span><br>--}}
                            <span style="margin-left:2em"><strong>transactions</strong>: [</span><br>
                            <span style="margin-left:4em">"5c009506e621dee3056867be",</span><br>
                            <span style="margin-left:4em">"5c009506e621dee3056867bf"</span><br>
                            <span style="margin-left:2em">]</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                        <br>

                        <code>
                            Transacciones:<br>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id </strong> : 5c009506e621dee3056867be ,</span><br>
                            <span style="margin-left:2em"><strong>due_date </strong> : "2017-03-11 02:37:40 " ,</span><br>
                            <span style="margin-left:2em"><strong>amount </strong> : "789" ,</span><br>
                            <span style="margin-left:2em"><strong>currency_id </strong> : "5c009506e621dee3056867b9" ,</span><br>
                            <span style="margin-left:2em"><strong>observations </strong> : "" ,</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id </strong> : 5c009506e621dee3056867bf ,</span><br>
                            <span style="margin-left:2em"><strong>due_date </strong> : "2017-03-11 02:37:40" ,</span><br>
                            <span style="margin-left:2em"><strong>amount </strong> : "89" ,</span><br>
                            <span style="margin-left:2em"><strong>currency_id </strong> : "5c009506e621dee305686ab9" ,</span><br>
                            <span style="margin-left:2em"><strong>observations </strong> : "" ,</span><br>
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
                                Tiene muchos: documentos y transacciones<br><br>
                            </span>
                        </code>

                        <code>
                            Entidad:<br>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>company_id</th>
                                    <th>author_id</th>
                                    <th>identification_id</th>
                                    <th>identification_number</th>
                                    <th>contact_name</th>
                                    <th>street_name</th>
                                    <th>street_number</th>
                                    <th>latitude</th>
                                    <th>longitude</th>
                                    <th>additional_info</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>pricelist_id</th>
                                    <th>entity_type</th>
                                    <th>responsibility_id</th>
                                    <th>observations</th>
                                    <th>has_account</th>
                                    <th>balance</th>
                                    <th>balance_at</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Clifton Leffler</td>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>2</td>
                                    <td>20327936221</td>
                                    <td>Clifton</td>
                                    <td>Mitre</td>
                                    <td>990</td>
                                    <td>12º 21' 33''</td>
                                    <td>12º 21' 33''</td>
                                    <td>Qui pariatur nesciunt quos.</td>
                                    <td>evi.hegmann@hotmail.com</td>
                                    <td>+1.628.974.1661</td>
                                    <td>47</td>
                                    <td>client</td>
                                    <td>5</td>
                                    <td>Ipsum non quidem dolor nesciunt iste.</td>
                                    <td>0</td>
                                    <td>6943.96,</td>
                                    <td>2019-03-10 00:00:00</td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                            </table>
                        </code>
                        <br>
                        <code>
                            Entidad:<br>

                            <table border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>entity_id</th>
                                    <th>due_date</th>
                                    <th>amount</th>
                                    <th>currency_id</th>
                                    <th>observations</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>2017-03-11 02:37:40</td>
                                    <td>789</td>
                                    <td>1</td>
                                    <td>.</td>
                                    <td>2018-03-11 02:37:59</td>
                                    <td>2018-03-11 02:38:04</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1</td>
                                    <td>2017-03-11 02:37:40</td>
                                    <td>89</td>
                                    <td>2</td>
                                    <td>.</td>
                                    <td>2018-03-11 02:37:59</td>
                                    <td>2018-03-11 02:38:04</td>
                                </tr>
                            </table>
                            </body>
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
