function graficar_polar(titulo, subtitulo, escala, categorias, series)
{
    $(function () {

        $('#container').highcharts({
            chart: {
                polar: true,
                type: 'line'
            },
            title: {
                //text: 'Budget vs spending'
                text: titulo
            },
            subtitle: {
                //text: '* Jane\'s banana consumption is unknown'
                text: subtitulo
            },
            pane: {
                size: '80%'
            },
            xAxis: {
                //categories: ['Sales', 'Marketing', 'Development', 'Customer Support',
                //'Information Technology', 'Administration'],
                categories: categorias,
                tickmarkPlacement: 'on',
                lineWidth: 0
            },
            yAxis: {
                gridLineInterpolation: 'polygon',
                lineWidth: 0,
                min: 0,
                title: {
                    //text: 'Units'
                    text: escala
                }
            },
            tooltip: {
                shared: true,
                pointFormat: '<span style="color:{series.color}">{series.name}: <b>${point.y:,.0f}</b><br/>'
            },
//            series: [{
//                    name: 'Allocated Budget',
//                    data: [43000, 19000, 60000, 35000, 17000, 10000],
//                    pointPlacement: 'on'
//                }, {
//                    name: 'Actual Spending',
//                    data: [50000, 39000, 42000, 31000, 26000, 14000],
//                    pointPlacement: 'on'
//                }]
            series: series

        });
    });
}

