@extends('admin.layouts.admin')

@section('title', 'Documentos')

@section('content')
    <input type="hidden" id="model" value="documents">
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
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c00931be621dee28d2d20dd"),</span><br>
                            <span style="margin-left:2em"><strong>author_id</strong>: "5bcba1b4e621de24cb5ab8b7",</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfb0119e621de04e77fb573",</span><br>
                            <span style="margin-left:2em"><strong>entity_id</strong>: "5bfafe6fe621de04e77f7449",</span><br>
                            <span style="margin-left:2em"><strong>seller_id</strong>: "5bfafe6fe621de04e77f7445",</span><br>
                            <span style="margin-left:2em"><strong>currency_id</strong>: "5bfafe66e621de18f119b4c8",</span><br>
                            <span style="margin-left:2em"><strong>receipt_id</strong>: "5bfafe66e621de18f119b480",</span><br>
                            <span style="margin-left:2em"><strong>section</strong>: "purchases",</span><br>
                            <span style="margin-left:2em"><strong>receipt_type</strong>: "credit",</span><br>
                            <span style="margin-left:2em"><strong>receipt_volume</strong>: "7",</span><br>
                            <span style="margin-left:2em"><strong>receipt_number</strong>: "00000227",</span><br>
                            <span style="margin-left:2em"><strong>total_commission</strong>: 4163.49,</span><br>
                            <span style="margin-left:2em"><strong>total_cost</strong>: 6416.01,</span><br>
                            <span style="margin-left:2em"><strong>total_net_price</strong>: 7659.81,</span><br>
                            <span style="margin-left:2em"><strong>total_final_price</strong>: 8495.59,</span><br>
                            <span style="margin-left:2em"><strong>emission_date</strong>: "2018-11-30 01:32:11",</span><br>
                            <span style="margin-left:2em"><strong>cae</strong>: "62326085376",</span><br>
                            <span style="margin-left:2em"><strong>cae_expiration_date</strong>: "2018-12-30 01:32:11",</span><br>
                            <span style="margin-left:2em"><strong>observation</strong>: "Voluptatum repellendus deleniti voluptates atque cum beatae.",</span><br>
                            <span style="margin-left:2em"><strong>status</strong>: "draft",</span><br>
                            <span style="margin-left:2em"><strong>details</strong>: [</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "3",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe7ce621de04e77f746e",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 46.38,</span><br>
                            {{--<span style="margin-left:6em"><strong>subdist_price</strong>: 31.13,</span><br>--}}
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 52.43,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 56.99,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 88.46</span><br>
                            <span style="margin-left:4em">},</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "1",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe72e621de04e77f744f",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 97.67,</span><br>
                            {{--<span style="margin-left:6em"><strong>subdist_price</strong>: 26.07,</span><br>--}}
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 94.88,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 55.52,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 88.62</span><br>
                            <span style="margin-left:4em">},</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "5",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe7ce621de04e77f7472",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 83.06,</span><br>
                            {{--<span style="margin-left:6em"><strong>subdist_price</strong>: 94.76,</span><br>--}}
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 43.64,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 23.39,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 37.75</span><br>
                            <span style="margin-left:4em">}</span><br>
                            <span style="margin-left:2em">],</span><br>
                            {{--<span style="margin-left:2em"><strong>parent_id</strong>: null,</span><br>--}}
                            <span style="margin-left:2em"><strong>fiscal_observation</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>canceled</strong>: false,</span><br>
                            <span style="margin-left:2em"><strong>show_amounts</strong>: true,</span><br>
                            {{--<span style="margin-left:2em"><strong>children</strong>: [],</span><br>--}}
                            {{--<span style="margin-left:2em"><strong>ancestors</strong>: [],</span><br>--}}
                            {{--<span style="margin-left:2em"><strong>transactions</strong>: []</span><br>--}}
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
                                Tiene muchas/os: detalles, documentos e inventarios<br><br>
                            </span>
                        </code>

                        <code>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    {{--<th>parent_id</th>--}}
                                    <th>author_id</th>
                                    <th>company_id</th>
                                    <th>entity_id</th>
                                    <th>seller_id</th>
                                    <th>currency_id</th>
                                    <th>receipt_id</th>
                                    <th>section</th>
                                    <th>receipt_type</th>
                                    <th>receipt_volume</th>
                                    <th>receipt_number</th>
                                    <th>total_commission</th>
                                    <th>total_cost</th>
                                    <th>total_net_price</th>
                                    <th>total_final_price</th>
                                    <th>emission_date</th>
                                    <th>cae</th>
                                    <th>cae_expiration_date</th>
                                    <th>observation</th>
                                    <th>fiscal_observation</th>
                                    <th>canceled</th>
                                    <th>show_amounts</th>
                                    <th>status</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    {{--<td>NULL</td>--}}
                                    <td>42</td>
                                    <td>51</td>
                                    <td>18</td>
                                    <td>17</td>
                                    <td>41</td>
                                    <td>9</td>
                                    <td>purchases</td>
                                    <td>credit</td>
                                    <td>8</td>
                                    <td>00000227</td>
                                    <td>4163.49</td>
                                    <td>6416.01</td>
                                    <td>2240.06</td>
                                    <td>8495.59,</td>
                                    <td>2019-03-11</td>
                                    <td>62326085376</td>
                                    <td>2018-11-30 01:32:11</td>
                                    <td>Voluptatum repellendus deleniti voluptates atque cum beatae.</td>
                                    <td></td>
                                    <td>0</td>
                                    <td>1</td>
                                    <td>draft</td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                            </table>
                        </code>
                        <br>
                        <code>
                            Detalles:<br>
                            <table class="mysql" border="1" style="border-collapse:collapse">
                                <tr>
                                    <th>id</th>
                                    <th>qty</th>
                                    <th>document_id</th>
                                    <th>product_id</th>
                                    <th>calculated_inventory_cost</th>
                                    <th>net_unit_price</th>
                                    <th>final_unit_price</th>
                                    <th>commission</th>
                                    <th>created_at</th>
                                    <th>updated_at</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>3</td>
                                    <td>8</td>
                                    <td>4</td>
                                    <td>46.38</td>
                                    <td>52.43</td>
                                    <td>88.79</td>
                                    <td>88.46</td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>8</td>
                                    <td>5</td>
                                    <td>97.67</td>
                                    <td>94.88</td>
                                    <td>55.52</td>
                                    <td>88.62</td>
                                    <td>2019-01-06 00:00:00</td>
                                    <td>2019-01-16 00:00:00</td>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>5</td>
                                    <td>8</td>
                                    <td>1</td>
                                    <td>83.06</td>
                                    <td>43.64</td>
                                    <td>23.39</td>
                                    <td>37.75</td>
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
