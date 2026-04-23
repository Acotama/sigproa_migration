<div class="col-md-12">
    <div class="row">
        <div class="col-md-12" id = "top">
        <form name="frmSearchDash" id = "frmSearchDash">            
            <div class="row">
                <div class="col-md-2 form-group">
                    <label class="form-label">
                        Provincia:
                    </label>
                    <select name="cboProv" class="form-control">
                        <option value="">-- Todos --</option>
                        <option value="BARRANCA">BARRANCA</option>
                        <option value="HUARAL">HUARAL</option>
                        <option value="HUAURA">HUAURA</option>
                        <option value="CANTA">CANTA</option>
                        <option value="HUAROCHIRI">HUAROCHIRI</option>
                        <option value="CAJATAMBO">CAJATAMBO</option>
                        <option value="CAÑETE">CAÑETE</option>
                        <option value="YAUYOS">YAUYOS</option>
                    </select>    
                </div>
                <div class="col-md-2 form-group">
                    <label class="form-label">
                        Tipo:
                    </label>
                    <select name="cboTipo" class="form-control">
                        <option value="">-- Todos --</option>
                        <option value="PIC">PIC</option>
                        <option value="PIP">PIP</option>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label class="form-label">
                        C. Snip
                    </label>
                    <input type="text" name="txtSnip" class="form-control">
                </div>
                 <div class="col-md-2 form-group">
                    <label class="form-label">
                        C. Unificado:
                    </label>
                    <input type="text" name="txtUnif" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="form-label">
                        U. Ejecutora:                
                    </label>
                    <select name="cboUE" class="form-control">
                        <option value = ""> -- Todos --</option>
                        <option value = "DRA">DRA</option>
                        <option value = "DRE">DRE</option>
                        <option value = "GRI">GRI</option>
                        <option value = "GRDS">GRDS</option>
                        <option value = "GRDE">GRDE</option>
                        <option value = "DIRESA">DIRESA</option>
                        <option value = "GRRNGMA">GRRNGMA</option>
                    </select>
                </div>
                <div class="col-md-2 form-group">
                    <label class="form-label">
                        Año Ejecución Financiera:
                    </label>
                    <select name="cboAnioEjecFinanc" class="form-control">
                        <option value = "2018">2018</option>
                        <option value = "2017">2017</option>
                        <option value = "2016">2016</option>
                    </select>                    
                </div>
            </div>            
            <div class="row">
                <div class="col-md-4 form-group">
                    <label class="form-label">
                            Por nombre:
                    </label>
                    <input type="text" name="txtSearch" class="form-control" placeholder="Nombre de Proyecto">
                </div>
                <div class="col-md-1 form-group">
                    <label class="form-label"> </label>
                    <button type="submit" class="btn btn-primary form-control"><i class="fa fa-search"></i> Filtrar</button>
                </div>
            </div>            
        </form>
        </div>

    </div>

    <div class="row">
        <div class="col-md-12" id = "middle">
            
        </div>
    </div>

    <div class="row">
        <div class="col-md-12" id = "bottom">
            
        </div>
    </div>


</div>

<script type="text/javascript">
    
    $("#frmSearchDash").submit(function(event){
            event.preventDefault();
            $.ajax({
                url: "principal/dashSearch",
                method: "POST",
                data: $("#frmSearchDash").serialize(),
                success: function(response) {

                    $("#middle").html(response['Resumen']);
                    $("#bottom").html(response['Graphs']);                    
                } // End Success
            });  // End Ajax
    });

    function get(){

    }

</script>