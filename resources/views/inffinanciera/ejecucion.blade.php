<span class="cabecera">
    Ejecución
</span>

<div id="container" class="container-fluid">

    <form id="frmEjecucion" action = "#">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Tipo de Proyecto</label>
                            <select name = "tip_pry">
                                <option value = "all">- Todos -</option>
                                <option value = "pip">Proyecto de Inversión Pública</option>
                                <option value = "pic">Programa de Inversión Concertado</option>
                                <option value = "procompite">PROCOMPITE</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="checkbox">
                            <input type="hidden" name = "chkrango" value = "false">
                            <label><input type="checkbox" name = "chkrango" id="chkrango" value = "true" onchange="setRango();"> Rango</label>
                        </div>
                    </div>
                    <div class = "row">
                        <div class="col-md-6">
                            <label for="year_ini">Año </label>
                            <input class="form-contro" type="text" name="year_ini" required/>
                        </div>
                        <div class="col-md-6" id = "rangeControl" style="display: none;">
                            <label for="year_fin">Hasta </label>
                            <input class="form-contro" type="text" name="year_fin" />
                        </div>
                    </div><br>
                    <div class="row">
                        <button class="btn btn-primary pull-right" type="submit"> Procesar</button>
                    </div>
                    <div class="row">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>PIM</td>
                                    <td>DEV</td>
                                    <td>% EJECUTADO</td>
                                </tr>
                            </thead>
                            <tbody id="tblEject">

                            </tbody>
                        </table>
                    </div>
                    <script>
                        function setRango(){
                            if($("#chkrango").is(":checked")){
                                $("#rangeControl").css('display','block');
                            } else {
                                $("#rangeControl").css('display','none');
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
    </form>

</div>


<div class="pie">
    <script>
    $("#frmEjecucion").submit(
        function (e) {
            e.preventDefault();
            url = "infFinanciera/getEjecucion";
            $.ajax({
                url: url,
                type: 'POST',
                data: $("#frmEjecucion").serialize(),
                beforeSend: function () {

                },
                success: function (response) {
                    try {

                        var ejecutado =  response[0].ejecutado;
                        html = "<tr><td>"+ response[0].pim +"</td><td>"+ response[0].dev +"</td><td>"+ ejecutado +"</td></tr>"

                    } catch(Exception){
                        html = ""
                    }
                    //html = "<tr><td>"+ response[0].pim +"</td><td>"+ response[0].dev +"</td><td>"+ ejecutado.toPrecision(4) +"</td></tr>"
                    $("#tblEject").html(html);


                }
            });
        }
    );
    </script>
</div>




