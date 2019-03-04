@extends('admin.layouts.admin')

@section('title', 'Listas de precio')

@section('content')
    <input type="hidden" id="model" value="pricelists">
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
                            <span style="margin-left:2em"><strong>_id</strong>: ObjectId("5c0096e3e621dee36e082a78"),</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "consectetur",</span><br>
                            <span style="margin-left:2em"><strong>company_id</strong>: "5bfb0119e621de04e77fae6a",</span><br>
                            <span style="margin-left:2em"><strong>percent_price</strong>: 34.05,</span><br>
                            <span style="margin-left:2em"><strong>percent_subdist</strong>: 13.28,</span><br>
                            <span style="margin-left:2em"><strong>percent_prevent</strong>: 7.1</span><br>
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
