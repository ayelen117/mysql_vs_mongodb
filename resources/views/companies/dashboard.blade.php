@extends('admin.layouts.admin')

@section('title', 'Compañías')

@section('content')
    <input type="hidden" id="model" value="companies">
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
                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
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
                            <span style="margin-left:2em"><strong>description</strong> :"Tempora pariatur minima soluta occaecati.",</span><br>
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
