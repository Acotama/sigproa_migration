            <div class="col-lg-12">
                    <div class="row">
                        <div class="col-md-12">
                            <h3>Ejecución Financiera</h3>
                            <div class="row">
                                <div class="col-md-5">
                                   <label>Filtro</label>
                                   <form id = "frmFinancParams">
                                        <label>Año: </label>
                                        <select class="form-comtrol" name="cboYear">
                                           <option value="2020" selected>2020</option>
                                           <option value="2019" >2019</option>
                                           <option value="2018">2018</option>
                                           <option value="2017">2017</option>
                                           <option value="2016">2016</option>
                                           <option value="2015">2015</option>
                                        </select>
                                   </form>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-success" onclick="getFinanc()">Cargar</button>
                                </div>
                            </div>
                           <div style="width:100%">
                               <div id = "Financechart"></div>
                               <script>
                                  var MONTHS = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio","Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                                  var chart;
                                  function getFinanc(){
                                      $.ajax({
                                          url: "/estadistics/chart/line/financiera",
                                          method: "POST",
                                          data: $("#frmFinancParams").serialize(),
                                          success: function(response) {

                                              /*if (config.data.datasets.length > 0) {
                                                  var month = MONTHS[config.data.labels.length % MONTHS.length];
                                                  config.data.labels.push(month);

                                                  config.data.datasets.forEach(function(dataset) {
                                                      dataset.data.push(randomScalingFactor());
                                                  });

                                                  window.myLine.update();
                                              }
                                              */
                                              //config.data.datasets[0].data.push(response['devengado']);
                                              //config.data.datasets[1].data.push(response['devengadoAcumulado']);
                                              //config.data.datasets[2].data.push(response['Pim']);
                                              var count = 0;
                                              var devengado = $.map(response['devengado'], function(value, index) {

                                                  count++;
                                                  if (count == 1){
                                                    return [value];
                                                  } else {
                                                    if(value!=0){
                                                        return [value];
                                                    }
                                                  }

                                              });

                                              devengado.unshift('Devengado Mensual');

                                              count = 0;
                                              var devengadoAcumulado = $.map(response['devengadoAcumulado'], function(value, index) {

                                                count++;
                                                if (count == 1){
                                                  return [value];
                                                } else {
                                                  if(value!=0){
                                                      return [value];
                                                  }
                                                }

                                              });

                                              devengadoAcumulado.unshift('Devengado Acumulado');

                                              var pim = $.map(MONTHS, function(value, index) {
                                                  return response['pim']['pim'];
                                              });

                                              pim.unshift('PIM');

                                              console.log(pim);

                                              chart.load({
                                                columns: [
                                                  devengado,
                                                  devengadoAcumulado,
                                                  pim
                                                ]
                                              });

                                          } // End Success
                                      });  // End Ajax
                                  }
                                  setTimeout(function(){
                                      chart = c3.generate({
                                              bindto:"#Financechart",
                                              /*size: {
                                                  height: 240,
                                                  width: 480
                                              },*/
                                              data: {
                                                  columns: [

                                                  ],
                                                  labels: true,
                                                  labels: {
                                                    format: function (v, id, i, j) { return d3.format(",")(v).replace(/,/g, ','); }
                                                  }
                                              },
                                              axis: {
                                                  x: {
                                                      /*tick: {
                                                          format: function (x) {
                                                               return 'S./ ' + d3.format(",.2f")(x).replace(/,/g, ',');
                                                           }
                                                      },*/
                                                      type: 'category',
                                                      categories: MONTHS
                                                  }
                                              },
                                              point: {
                                                  show: true
                                              },
                                              zoom: {
                                                  enabled: true
                                              },
                                              grid: {
                                                  x: {
                                                      show: true
                                                  },
                                                  y: {
                                                      show: true
                                                  }
                                              },
                                              tooltip: {
                                                  format: {
                                                      value: function(value) {
                                                          return 'S./ ' + d3.format(",.2f")(value).replace(/,/g, ',');
                                                      }
                                                  }
                                              }

                                      });

                                      getFinanc();


                                  },2000);
                               </script>
                           </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="row text-center">
                                <h3>Historial de actualizaciones</h3>
                                <br>
                                <nav id="jnav">
                                    <ul id="daily">

                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row text-center">
                                <div class="col-md-offset-2 col-md-8">
                                    <h3>Información de Proyectos</h3>
                                    <canvas id="myChart" width="100px" height="100px"></canvas>
                                    <script type="text/javascript">
                                        // Any of the following formats may be used
                                        var ctx = document.getElementById("myChart").getContext("2d");
                                        var myChart = new Chart(
                                            ctx, {
                                            type: 'bar',

                                            data: {/*
                                                labels: myLabels,
                                                datasets: [
                                                    {
                                                        label: 'Total de Proyectos',
                                                        data: myData,
                                                        backgroundColor:'#a92d2d',
                                                        borderWidth: 2
                                                    },
                                                    {
                                                        label: 'Priorizados (Sayhuite)',
                                                        data: myDataPrior,
                                                        backgroundColor: '#1d42a2',
                                                        borderWidth: 2
                                                    },
                                                    {
                                                        label: 'Actualizados Quincenal',
                                                        data: myDataUpdated15,
                                                        backgroundColor: '#3c763d',
                                                        borderWidth: 2
                                                    }]*/
                                            },
                                            options: {
                                                responsive: true,
                                                maintainAspectRatio: true,
                                                scales: {
                                                    yAxes: [{
                                                        ticks: {
                                                            beginAtZero:true
                                                        }
                                                    }]
                                                }
                                            }
                                        });
                                    </script>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="ct-chart"></div>
                    </div>
            </div>

        <script>
        $(function(){
            //myChart.update();
            $.ajax({
                url: "principal/chart",
                method: "POST",
                success: function(response) {

                    //HISTORIAL####
                    var html = '';
                    $.each(response.dailyaudit, function( index, value ) {
                        var s = '<li class="list-group-item list-group-item-success">' + value + '</li>';
                        html += s;
                    });

                    $('#daily').html(html);

                    //BAR CHART, TOTAL PRY####
                    var myLabels = [];
                    var myData = [];
                    var myDataPrior = [];
                    var myDataUpdated15 = [];
                    var Total = [];

                    arrUE = {
                        //'SUB GERENCIA REGIONAL LIMA SUR' : 'SGRLS',
                        'DIRECCION REGIONAL DE AGRICULTURA' : 'DRA',
                        'DIRECCION REGIONAL DE EDUCACION' : 'DRE',
                        'DIRECCION REGIONAL DE TRANSPORTE Y COMUNICACIONES':'DRTC',
                        'DIRECCION REGIONAL DE TRABAJO':'GRT',
                        'GERENCIA REGIONAL DE RECURSOS NATURALES Y GESTION DEL MEDIO AMBIENTE': 'GRRNGMA',
                        'GERENCIA SUB REGIONAL LIMA SUR' : 'GSRLS',
                        'GERENCIA REGIONAL DE DESARROLLO ECONOMICO' :'GRDE',
                        'GERENCIA REGIONAL DE DESARROLLO SOCIAL' : 'GRDS',
                        'GERENCIA REGIONAL DE INFRAESTRUCTURA' : 'GRI',
                        'DIRECCION REGIONAL DE SALUD' : 'DRS',
                        //'DIRECCION REGIONAL DE EDUCACION' : 'DRE',
                        'PROGRAMA DE DESARROLLO PRODUCTIVO AGRARIO RURAL - AGRORURAL':'AGRORURAL',
                        '':'NO ESPECIFICADO',
                        'PRESIDENCIA REGIONAL':'NO ESPECIFICADO'
                    };

                    //console.log(response);

                    for(var i in response.pxg.t) {
                        if(arrUE[response.pxg.t[i].c]!='NO ESPECIFICADO') {
                            myLabels.push(arrUE[response.pxg.t[i].c]);
                            myData.push(response.pxg.t[i].count);
                            myDataPrior.push(response.pxg.t[i].p)
                            myDataUpdated15.push(response.pxg.t[i].pri);
                        }
                    }
                    //console.log(myLabels);
                    var myCHartdatasets =   [
                                                    {
                                                        label: 'Total de Proyectos',
                                                        data: myData,
                                                        backgroundColor:'#a92d2d',
                                                        borderWidth: 2
                                                    },
                                                    {
                                                        label: 'Publicados (Sayhuite)',
                                                        data: myDataPrior,
                                                        backgroundColor: '#1d42a2',
                                                        borderWidth: 2
                                                    },
                                                    {
                                                        label: 'Actualizados Quincenal',
                                                        data: myDataUpdated15,
                                                        backgroundColor: '#3c763d',
                                                        borderWidth: 2
                                                    }];
                    myChart.data.labels = myLabels;
                    myChart.data.datasets = myCHartdatasets;
                    myChart.update();



                } // End Success
            });  // End Ajax
        });

        </script>

        <script type="text/javascript">
            <!--// LOAD MODAL FUNCTION -->
            function loadModal(url,modaltype,CRUD,opc) {
                $modal = $('#' + modaltype);
                //clean errors
                $(".m-message").html('<div></div>');
                switch (CRUD) {
                    case '1':
                        //data = JSON.parse(opc);
                        //var id = opc['id'];
                        //$.parseJSON(opc);
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: {'id': opc.idproyecto},
                            beforeSend: function () {
                                // $("#error").fadeOut();
                            },
                            success: function (response) {
                                $('#' + modaltype + ' .modal-title').html($(response).filter('.cabecera'));
                                $('#' + modaltype + ' .modal-body').html($(response).filter('#container'));
                                $('#' + modaltype + ' .modal-footer').append($(response).filter('.pie'));
                                $('#' + modaltype).modal('show', {backdrop: 'true'});
                            }
                        }).done(function(e){

                            $.ajax({
                                url: 'audit/piptotalpriori/getAuditChanges',
                                type: 'POST',
                                data: {'id': opc.id},
                                beforeSend: function () {
                                    // $("#error").fadeOut();
                                },
                                success: function (response) {
                                   //console.log($.parseJSON(response.new));
                                   $.each($.parseJSON(response.new),function(key,value){
                                        $("input[name="+key+"]").css('background-color','rgb(142, 218, 124)');
                                   });
                                }
                            });

                        });
                        break;
                }
            }

        </script>
