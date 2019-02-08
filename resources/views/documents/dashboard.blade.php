@extends('admin.layouts.admin')

@section('title', 'Documentos')

@section('content')
    <input type="hidden" id="model" value="documents">
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne"
                           aria-expanded="true" aria-controls="collapseOne">
                            MongoDB example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
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
                            <span style="margin-left:2em"><strong>total_cost</strong>: 376.74,</span><br>
                            <span style="margin-left:2em"><strong>total_net_price</strong>: 7659.81,</span><br>
                            <span style="margin-left:2em"><strong>total_final_price</strong>: 8495.59,</span><br>
                            <span style="margin-left:2em"><strong>emission_date</strong>: "2018-11-30 01:32:11",</span><br>
                            <span style="margin-left:2em"><strong>cae</strong>: "62326085376",</span><br>
                            <span style="margin-left:2em"><strong>cae_expiration_date</strong>: "2018-12-30 01:32:11",</span><br>
                            <span style="margin-left:2em"><strong>observation</strong>: "Voluptatum repellendus deleniti voluptates atque cum beatae.",</span><br>
                            <span style="margin-left:2em"><strong>status</strong>: "failed",</span><br>
                            <span style="margin-left:2em"><strong>details</strong>: [</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "42",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe7ce621de04e77f746e",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 46.38,</span><br>
                            <span style="margin-left:6em"><strong>subdist_price</strong>: 31.13,</span><br>
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 52.43,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 56.99,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 88.46</span><br>
                            <span style="margin-left:4em">},</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "81",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe72e621de04e77f744f",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 97.67,</span><br>
                            <span style="margin-left:6em"><strong>subdist_price</strong>: 26.07,</span><br>
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 94.88,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 55.52,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 88.62</span><br>
                            <span style="margin-left:4em">},</span><br>
                            <span style="margin-left:4em">{</span><br>
                            <span style="margin-left:6em"><strong>qty</strong>: "09",</span><br>
                            <span style="margin-left:6em"><strong>product_id</strong>: "5bfafe7ce621de04e77f7472",</span><br>
                            <span style="margin-left:6em"><strong>calculated_inventory_cost</strong>: 83.06,</span><br>
                            <span style="margin-left:6em"><strong>subdist_price</strong>: 94.76,</span><br>
                            <span style="margin-left:6em"><strong>net_unit_price</strong>: 43.64,</span><br>
                            <span style="margin-left:6em"><strong>final_unit_price</strong>: 23.39,</span><br>
                            <span style="margin-left:6em"><strong>commission</strong>: 37.75</span><br>
                            <span style="margin-left:4em">}</span><br>
                            <span style="margin-left:2em">],</span><br>
                            <span style="margin-left:2em"><strong>parent_id</strong>: null,</span><br>
                            <span style="margin-left:2em"><strong>fiscal_observation</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>canceled</strong>: false,</span><br>
                            <span style="margin-left:2em"><strong>show_amounts</strong>: true,</span><br>
                            <span style="margin-left:2em"><strong>children</strong>: [],</span><br>
                            <span style="margin-left:2em"><strong>ancestors</strong>: [],</span><br>
                            <span style="margin-left:2em"><strong>transactions</strong>: []</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
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
        @include('partials.dashboard.crud_graphs', ['type' => 'insertion'])
        @include('partials.dashboard.crud_graphs', ['type' => 'update'])
    </div>
    <div class="row">
        @include('partials.dashboard.crud_graphs', ['type' => 'reading'])
        @include('partials.dashboard.crud_graphs', ['type' => 'deleting'])
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js"></script>
    {{ Html::script('js/crud_graphs.js') }}
@endsection
