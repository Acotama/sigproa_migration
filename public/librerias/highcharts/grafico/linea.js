function graficar_linea(titulo, subtitulo, escala, tabla, actual)
{
    if ($('#' + tabla).length) {
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    //text: 'Data extracted from a HTML table in the page'
                    text: titulo
                },
                subtitle: {
                    //text: '* Jane\'s banana consumption is unknown'
                    text: subtitulo
                },
                yAxis: {
                    title: {
                        //text: 'Units'
                        text: escala
                    }
                },
                xAxis: {
                    title: {
                        //text: 'Units'
                        text: 'AÑOS'
                    },
                    plotLines: [{
                            value: actual,
                            color: 'green',
                            dashStyle: 'shortdash',
                            width: 3,
                            label: {
                                text: 'Situacion Actual'
                            }
                        }]
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/> AÑO ' +
                                this.point.x + ' : ' + this.point.y + ' ' + escala;
                    }
                },
                plotOptions: {
                    series: {
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '{point.y}'
                        }
                    }
                },
                data: {
                    table: tabla
                }
            });
        });
    } else {
        $('#container').html('');
        bootbox.alert("<center><strong>MENSAJE</strong></center><center><h4>NO SE ENCONTRARON DATOS</h4></center>", function () {
        });
    }
}


