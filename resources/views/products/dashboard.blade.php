@extends('admin.layouts.admin')

@section('title', 'Productos')

@section('content')
    <input type="hidden" id="model" value="products">
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
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c00931de621dee28d2d20ec"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "voluptatem",</span><br>
                            <span style="margin-left:2em"><strong>description</strong>: "Quibusdam quasi est aliquam porro ut.",</span><br>
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
                            <span style="margin-left:2em"><strong>stock</strong>: "00",</span><br>
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
