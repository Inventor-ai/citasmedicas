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
  
function fetchData() {
  // fetch API
  fetch('../../charts/doctors/column/data')
      .then(function (response) {
         return response.json();
      })
      .then(function (myJson) {
         console.log(myJson);
      });
}