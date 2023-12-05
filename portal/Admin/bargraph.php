<!DOCTYPE html>
<html lang="en">
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        $.ajax({
          url: "bardata.php",
          dataType: "json",
          success: function (jsonData) {
            // Convert JSON data to DataTable
            var data = google.visualization.arrayToDataTable(jsonData);

            var options = {
              title: 'Bargraph Showing Number Of applications on each Job posted',
              vAxis: { title: 'Number Applications Received', minValue: 0, format: '0',  gridlines: { count: 2 } }, // Set minValue to 1
              hAxis: { title: 'Job Posted' },
              bars: 'vertical', // Display vertical bars
              colors: ['#008000', '#34A853', '#FBBC05', '#EA4335'], // Customize bar colors
              bar: { groupWidth: '50%' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));

            chart.draw(data, options);
          },
          error: function (error) {
            console.log('Error fetching data:', error);
          }
        });
      }
    </script>
  </head>
  <body>
    <div id="columnchart" style="width: 400px; height: 300px;"></div>
  </body>
</html>
