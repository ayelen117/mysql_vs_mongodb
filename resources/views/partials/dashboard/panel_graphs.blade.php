<div class="x_panel" id="general">
    <div class="form-group row">
        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
            Cantidad total de registros : <span class="total_records"></span>
        </label>
    </div>
    <div class="form-group row">
        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
            Cantidad de registros a comparar
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="10" required>
        </div>
    </div>

    <div class="form-group center-block row">
        <div class="col-md-12">
            <input type="reset" class="btn btn-primary" value="Reset">
            <input type="button" class="btn btn-success" href="javascript:;" onclick="addAllDatasets( $('#general .qty:first-child').val());return false;" value="Calcular"/>
            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeAllDatasets();return false;" value="Eliminar"/>
        </div>
    </div>
</div>