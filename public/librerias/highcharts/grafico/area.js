function graficar_area(titulo, subtitulo, escala, categorias, series)
{
    $(function () {
        $('#container').highcharts({
            chart: {
                type: 'area'
            },
            title: {
                //text: 'Fruit consumption *'
                text: titulo
            },
            subtitle: {
                //text: '* Jane\'s banana consumption is unknown'
                text: subtitulo
            },
            xAxis: {
                //categories: ['Apples', 'Pears', 'Oranges', 'Bananas', 'Grapes', 'Plums', 'Strawberries', 'Raspberries']
                categories: categorias
            },
            yAxis: {
                title: {
                    //text: 'Y-Axis'
                    text: escala
                },
                labels: {
                    formatter: function () {
                        return this.value;
                    }
                }
            },
            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + '</b><br/>' +
                            this.x + ': ' + this.y;
                }
            },
            plotOptions: {
                area: {
                    fillOpacity: 0.5
                }
            },
//            series: [{
//                    name: 'John',
//                    data: [0, 1, 4, 4, 5, 2, 3, 7]
//                }, {
//                    name: 'Jane',
//                    data: [1, 0, 3, 6, 3, 1, 2, 1]
//                }]
            series: series
        });
    });
}

