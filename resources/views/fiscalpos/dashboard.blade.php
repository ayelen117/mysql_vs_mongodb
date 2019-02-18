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
                            MongoDB example
                        </a>
                    </h4>
                </div>
                <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c0096e3e621dee36e082a72"),</span><br>
                            <span style="margin-left:2em"><strong>number</strong>: "83",</span><br>
                            <span style="margin-left:2em"><strong>pos_type</strong>: "fiscal_printer",</span><br>
                            <span style="margin-left:2em"><strong>alias</strong>: "consequatur",</span><br>
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
