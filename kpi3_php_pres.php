
<?php
  $host        = "host=tidehackathon.postgres.database.azure.com";
   $port        = "port=5432";
   $dbname      = "dbname = iodashboard";
   $credentials = "user = tidereader password=ioH@ck@thonReader2023!";

   $db = pg_connect( "$host $port $dbname $credentials"  );
  /* if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }*/
   $sql =<<<EOF
   select
   exercise_cycle,
   (sum(Success_To_All_Ratio) / count(name))*100 as Average_success_rate
     from 
       (select 
         c."name",
         exercise_cycle,
         cast(count(case when participant_result = 'Success' or participant_result = 'Limited Success' then 1 end) as float)/cast(count(participant_result) as float) as Success_To_All_Ratio
           from 
             capabilities c 
           join 
             (select capability_id, participant_result, exercise_cycle from test_participants tp where participant_result = 'Success' or participant_result = 'Limited Success' or participant_result = 'Interoperability Issue') as s1 
           on 
             c.id = s1.capability_id
           group by c."name", exercise_cycle) as s1
   group by exercise_cycle
   order by right(exercise_cycle, 4) asc
   EOF;
   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
      exit;
   } 

   pg_close($db);

?>

<!DOCTYPE html>
<html lang="en">
   <head>
   <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  </head>
  <?php 
    $wynik[] = NULL;
     while($row = pg_fetch_row($ret)) {
      array_push($wynik, $row);

   }
   
  ?>
             
  <div id="chart">
  </div>
  <script>
    var wynik1 = <?php print_r($wynik[1][1]); ?>;
    wynik1 = Math.round(wynik1*100000)/100000;
    var wynik2 = <?php print_r($wynik[2][1]); ?>;
    wynik2 = Math.round(wynik2*100000)/100000;
    var options = {
          series: [  wynik1, wynik2],
          chart: {
          height: 350,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '16px',
              }
              
            }
          }
        },
        labels: [<?php print_r('"' .$wynik[1][0]. '", "' .($wynik[2][0]). '"');?>],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
      
    
      
      
    
    

  </script>
  <?php print_r($wynik[1][0]. ", " .($wynik[2][1])); ?>
</html>