const chart = Highcharts.chart('container', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Médicos más activos'
                },
                xAxis: {
                    categories: [
                        'Médico A',
                        'Médico B',
                        'Médico C'
                    ],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Citas médicas atendidas'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                        '<td style="padding:0"><b>{point.y}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0
                    }
                },
                series: []
              });

let $start, $end;

function fetchData() {
  const dateStart = $start.val();
  const dateEnd   = $end.val();
  const url       = '../../charts/doctors/column/data'
                  + `?startDate=${dateStart}`
                  + `&endDate=${dateEnd}`;
  // fetch API
  fetch(url).then( response => 
    response.json()
  ).then( data => {
    chart.xAxis[0].setCategories(data.categories);
    if (chart.series.length > 0 ) {
        chart.series[0].remove();
        chart.series[0].remove();
    }
    chart.addSeries(data.series[0]);
    chart.addSeries(data.series[1]);
  });
}

$(function () {
    $start = $("#dateStart");
    $end = $("#dateEnd");
    fetchData();
    $start.on("change", fetchData);
    $end.on("change", fetchData);
});
