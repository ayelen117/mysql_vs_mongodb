@extends('admin.layouts.admin')

@section('title', 'Otros modelos')

@section('content')
    <h3>MongoDB example</h3>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion1" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion1" href="#collapse-1"
                           aria-expanded="true" aria-controls="collapseOne">
                            Monedas
                        </a>
                    </h4>
                </div>
                <div id="collapse-1" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "5913b06e4ff91e17027757d8" },</span><br>
                            <span style="margin-left:2em"><strong>code_afip</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "BITCOIN",</span><br>
                            <span style="margin-left:2em"><strong>code_iso</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>symbol</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>quotation_usd</strong>: ""</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion2" href="#collapse-2"
                           aria-expanded="true" aria-controls="collapseOne">
                            Inventarios
                        </a>
                    </h4>
                </div>
                <div id="collapse-2" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "597b9f614ff91e46741bc171" },</span><br>
                            <span style="margin-left:2em"><strong>qty</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>current_stock_qty</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>product_id</strong>: "597ae99c4ff91e2a304616af",</span><br>
                            <span style="margin-left:2em"><strong>detail_id</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>unit_price</strong>: 7792.5,</span><br>
                            <span style="margin-left:2em"><strong>total_price</strong>: 0,</span><br>
                            <span style="margin-left:2em"><strong>total</strong>: 0</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion3" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion3" href="#collapse-3"
                           aria-expanded="true" aria-controls="collapseOne">
                            Tipos de documentos
                        </a>
                    </h4>
                </div>
                <div id="collapse-3" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "5913b06e4ff91e1702775799" },</span><br>
                            <span style="margin-left:2em"><strong>code_afip</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "DOCUMENTO NO FISCAL",</span><br>
                            <span style="margin-left:2em"><strong>receipt_type</strong>: "",</span><br>
                            <span style="margin-left:2em"><strong>letter</strong>: "X"</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion4" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion4" href="#collapse-4"
                           aria-expanded="true" aria-controls="collapseOne">
                            Responsabilidades
                        </a>
                    </h4>
                </div>
                <div id="collapse-4" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "5913b06e4ff91e17027757e6" },</span><br>
                            <span style="margin-left:2em"><strong>code_afip</strong>: "14",</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "Pequeño Contribuyente Eventual Social",</span><br>
                            <span style="margin-left:2em"><strong>abbreviation</strong>: "PS"</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion5" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion5" href="#collapse-5"
                           aria-expanded="true" aria-controls="collapseOne">
                            Transacciones
                        </a>
                    </h4>
                </div>
                <div id="collapse-5" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "597cf04e4ff91e7d0c587912" },</span><br>
                            <span style="margin-left:2em"><strong>due_date</strong>: "2017-07-29",</span><br>
                            <span style="margin-left:2em"><strong>amount</strong>: 25.42,</span><br>
                            <span style="margin-left:2em"><strong>currency_id</strong>: "5913b06e4ff91e17027757a9",</span><br>
                            <span style="margin-left:2em"><strong>observations</strong>: "Consequatur molestiae ab sed."</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion7" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion7" href="#collapse-7"
                           aria-expanded="true" aria-controls="collapseOne">
                            Identificaciones
                        </a>
                    </h4>
                </div>
                <div id="collapse-7" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>: { "$oid</strong>: "5913b06e4ff91e1702775746" },</span><br>
                            <span style="margin-left:2em"><strong>code_afip</strong>: "88",</span><br>
                            <span style="margin-left:2em"><strong>name</strong>: "Usado por Anses para Padrón"</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-group col-md-12 col-sm-12 col-xs-12" id="accordion8" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default">
                <div class="panel-heading" role="tab" id="headingOne">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion8" href="#collapse-8"
                           aria-expanded="true" aria-controls="collapseOne">
                            Impuestos
                        </a>
                    </h4>
                </div>
                <div id="collapse-8" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                    <div class="panel-body">
                        <code>
                            <span style="margin-left:0em">{</span><br>
                            <span style="margin-left:2em"><strong>_id</strong>:"5c0ae6cde621dea68f6717e8",</span><br>
                            <span style="margin-left:2em"><strong>code_afip</strong>:"1",</span><br>
                            <span style="margin-left:2em"><strong>name</strong>:"No Gravado",</span><br>
                            <span style="margin-left:2em"><strong>percent_value</strong>:0</span><br>
                            <span style="margin-left:0em">},</span><br>
                            </span>
                        </code>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection