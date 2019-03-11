@extends('admin.layouts.admin')

@section('title', 'Productos')

@section('content')
    <input type="hidden" id="model" value="products">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion" role="tablist"
             aria-multiselectable="true">
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
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c00931de621dee28d2d20ec"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "Cuaderno",</span><br>
                            <span style="margin-left:2em"><strong>description</strong>: "Cuaderno de tapa dura.",</span><br>
                            <span style="margin-left:2em"><strong>barcode</strong>: "6274442332",</span><br>
                            <span style="margin-left:2em"><strong>product_type</strong>: "product",</span><br>
                            <span style="margin-left:2em"><strong>stock_type</strong>: "negative",</span><br>
                            <span style="margin-left:2em"><strong>duration</strong>: 1,</span><br>
                            <span style="margin-left:2em"><strong>replacement_cost</strong>: "1",</span><br>
                            <span style="margin-left:2em"><strong>author_id</strong>: "5bcba1b7e621de24cb5ab91e",</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfaffb7e621de04e77f7dcf",</span><br>
                            <span style="margin-left:2em"><strong>category_id</strong>: "5c008f9de621dee1d52e7a74",</span><br>
                            <span style="margin-left:2em"><strong>tax_id</strong>: "5bfafe66e621de18f119b4f9",</span><br>
                            <span style="margin-left:2em"><strong>currency_id</strong>: "5bfafe66e621de18f119b4ca",</span><br>
                            <span style="margin-left:2em"><strong>stock</strong>: "27",</span><br>
                            <span style="margin-left:2em"><strong>stock_alert</strong>: "24",</span><br>
                            <span style="margin-left:2em"><strong>stock_desired</strong>: "52",</span><br>
                            <span style="margin-left:2em"><strong>high</strong>: "0.00",</span><br>
                            <span style="margin-left:2em"><strong>width</strong>: "0.00",</span><br>
                            <span style="margin-left:2em"><strong>length</strong>: "0",</span><br>
                            <span style="margin-left:2em"><strong>weight</strong>: "0",</span><br>
                            <span style="margin-left:2em"><strong>weight_element</strong>: "0",</span><br>
                            <span style="margin-left:2em"><strong>pricelists</strong>: [</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>pricelist_id</strong>: "",</span><br>
                            <span style="margin-left:6em"><strong>price</strong>: 72.78,</span><br>
                            <span style="margin-left:6em"><strong>percent_subdist</strong>: 4.96,</span><br>
                            <span style="margin-left:6em"><strong>percent_prevent</strong>: 41.27,</span><br>
                            <span style="margin-left:6em"><strong>activated</strong>: true</span><br>
                            <span style="margin-left:4em">},</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>pricelist_id</strong>: "5bfafe75e621de04e77f7459",</span><br>
                            <span style="margin-left:6em"><strong>price</strong>: 74.99,</span><br>
                            <span style="margin-left:6em"><strong>percent_subdist</strong>: 46.77,</span><br>
                            <span style="margin-left:6em"><strong>percent_prevent</strong>: 37.3,</span><br>
                            <span style="margin-left:6em"><strong>activated</strong>: false</span><br>
                            <span style="margin-left:4em">}</span><br>
                            <span style="margin-left:2em"><strong>]</span><br>
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
                                Tiene muchas/os: detalles e inventarios<br><br>
                            </span>
                        </code>

                        <code>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>description</th>
                                    <th>barcode</th>
                                    <th>product_type</th>
                                    <th>duration</th>
                                    <th>stock_type</th>
                                    <th>replacement_cost</th>
                                    <th>author_id</th>
                                    <th>company_id</th>
                                    <th>category_id</th>
                                    <th>tax_id</th>
                                    <th>currency_id</th>
                                    <th>stock</th>
                                    <th>stock_alert</th>
                                    <th>stock_desired</th>
                                    <th>high</th>
                                    <th>width</th>
                                    <th>length</th>
                                    <th>weight</th>
                                    <th>weight_element</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Cuaderno</td>
                                    <td>Cuaderno de tapa dura.</td>
                                    <td>6274442332</td>
                                    <td>product</td>
                                    <td>1</td>
                                    <td>negative</td>
                                    <td>1</td>
                                    <td>44</td>
                                    <td>54</td>
                                    <td>42</td>
                                    <td>3</td>
                                    <td>31</td>
                                    <td>27</td>
                                    <td>24</td>
                                    <td>52</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>0</td>
                                    <td>NULL</td>
                                    <td>NULL</td>
                                </tr>
                            </table>
                        </code>
                        <br>
                        <code>
                            Listas de precio:<br>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>pricelist_id</th>
                                    <th>price</th>
                                    <th>product_id</th>
                                    <th>percent_subdist</th>
                                    <th>percent_prevent</th>
                                    <th>activated</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>2</td>
                                    <td>72.78</td>
                                    <td>1</td>
                                    <td>4.96</td>
                                    <td>41.27</td>
                                    <td>1</td>
                                    <td>2019-03-07 01:53:35</td>
                                    <td>2019-03-07 01:53:35</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>1</td>
                                    <td>74.99</td>
                                    <td>1</td>
                                    <td>46.77</td>
                                    <td>37.3</td>
                                    <td>0</td>
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
