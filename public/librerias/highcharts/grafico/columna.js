function graficar_columna(titulo, subtitulo, escala, tabla)
{
    if ($('#' + tabla).length) {
        $(function () {
            $('#container').highcharts({
                chart: {
                    type: 'column'
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
                    allowDecimals: false,
                    title: {
                        //text: 'Units'
                        text: escala
                    }
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.point.name + '</b><br/>' +
                                this.series.name + ' : ' + this.point.y + ' ' + escala;
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
    }else{
        $('#container').html('');
        bootbox.alert("<center><strong>MENSAJE</strong></center><center><h4>NO SE ENCONTRARON DATOS</h4></center>", function() {});
    }
}


