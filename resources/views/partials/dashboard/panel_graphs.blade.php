<div class="x_panel" id="general">
    <div class="form-group">
        <label class="control-label col-md-6 col-sm-6 col-xs-12" for="name" >
            Cantidad de registros
        </label>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <input type="number" class="qty form-control col-md-7 col-xs-12" name="qty" value="10" required>
        </div>
    </div>

    <div class="form-group center-block">
        <div class="col-md-12">
            <input type="reset" class="btn btn-primary" value="Reset">
            <input type="button" class="btn btn-success" href="javascript:;" onclick="addAllDatasets( $('#general .qty:first-child').val());return false;" value="Calcular"/>
            <input type="button" class="btn btn-success" href="javascript:;" onclick="removeAllDatasets();return false;" value="Eliminar"/>
        </div>
    </div>
</div>