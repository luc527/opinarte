<?php
function gerarGrafico($notas_cnt, $nome) {

  // Transformação do fetchAll para vetor apropriado
  $notas = array();
  for ($i=1; $i <= 10; $i++) {
    for ($j=0; $j < count($notas_cnt); $j++) {
      if($notas_cnt[$j]['nota'] == $i) {
        $notas[$i] = $notas_cnt[$j]['qtd'];
        break;
      } else {
        $notas[$i] = 0;
      }
    }
  }

  //var_dump($notas);

  ?>
  <script type="text/javascript" src="js/googlegraph-loader.js"></script>
  <div id="notas_grafico"></div>

  <script type="text/javascript">
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Nota', 'Obras'],
        <?php for ($i=1; $i <= 10; $i++) {
          echo "[".$i.", ".$notas[$i]."]";
          if ($i != count($notas)) echo ",";
        } ?>
      ]);

      var options = {
        vAxis: { ticks: [1,2,3,4,5,6,7,8,9,10] },
        bars: 'vertical',
        height: 400
      };

      var chart = new google.charts.Bar(document.getElementById('notas_grafico'));

      chart.draw(data, google.charts.Bar.convertOptions(options));
    }
  </script>
<?php }
?>
