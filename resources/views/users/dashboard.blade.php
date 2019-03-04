@extends('admin.layouts.admin')

@section('title', 'Users')

@section('content')
    <input type="hidden" id="model" value="users">
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
