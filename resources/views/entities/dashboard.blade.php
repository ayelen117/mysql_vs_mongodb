@extends('admin.layouts.admin')

@section('title', 'Entidades')

@section('content')
    <input type="hidden" id="model" value="entities">
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
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c0096e2e621dee36e082a70"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "Clifton Leffler",</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfaffb7e621de04e77f8c3b",</span><br>
                            <span style="margin-left:2em"><strong>author_id</strong>: "5bdb8f95e621de6996024637",</span><br>
                            <span style="margin-left:2em"><strong>identification_id</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>identification_number</strong>: "42591491",</span><br>
                            <span style="margin-left:2em"><strong>contact_name</strong>: "Shemar",</span><br>
                            <span style="margin-left:2em"><strong>street_name</strong>: "Quigley Hollow",</span><br>
                            <span style="margin-left:2em"><strong>street_number</strong>: "990",</span><br>
                            <span style="margin-left:2em"><strong>latitude</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>longitude</strong>: 0,</span><br>
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
                            <span style="margin-left:2em"><strong>parent</strong>: null,</span><br>
                            <span style="margin-left:2em"><strong>children</strong>: [],</span><br>
                            <span style="margin-left:2em"><strong>ancestors</strong>: [],</span><br>
                            <span style="margin-left:2em"><strong>transactions</strong>: [</span><br>
                            <span style="margin-left:4em">"5c009506e621dee3056867be",</span><br>
                            <span style="margin-left:4em">"5c009506e621dee3056867bf"</span><br>
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
