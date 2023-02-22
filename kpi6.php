
<?php
  $host        = "host=tidehackathon.postgres.database.azure.com";
   $port        = "port=5432";
   $dbname      = "dbname = iodashboard";
   $credentials = "user = tidereader password=ioH@ck@thonReader2023!";

   $db = pg_connect( "$host $port $dbname $credentials"  );
 /*  if(!$db) {
      echo "Error : Unable to open database\n";
   } else {
      echo "Opened database successfully\n";
   }*/
   $sql =<<<EOF
        select
        exercise_cycle,
        dom_count,
        sum(success_to_all_ratio) / count(s1.capability_id) as Averafe_succes_rate_in_domain
            from
            (select 
                capability_id,
                count(operational_domain_id) as dom_count
                    from 
                        capability_operational_domains cod 
                    group by
                        capability_id ) s1
            join 
            (select 
                exercise_cycle,
                capability_id,
                cast(count(case when participant_result = 'Success' or participant_result = 'Limited Success' then 1 end) as float)/cast(count(participant_result) as float) as Success_To_All_Ratio
                    from 
                        capabilities c 
                    join 
                        (select capability_id, participant_result, exercise_cycle from test_participants tp where participant_result = 'Success' or participant_result = 'Limited Success' or participant_result = 'Interoperability Issue') as s1 
                    on 
                        c.id = s1.capability_id
                    group by exercise_cycle, capability_id) s2
            on
                s1.capability_id = s2.capability_id
        group by exercise_cycle, dom_count 
        order by right(exercise_cycle , 4) asc, dom_count asc
   EOF;
   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
      exit;
   };
   pg_close($db);


?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    </head>
   <body>
        <div id="chart"></div>
   </body>

</html>
<script>
    function listawynikow(nrwartosci, lista) {
        const temp = []
        lista.forEach(element => {
            temp.push(element[nrwartosci])
        });
        return temp
    }
    function wynikirow(nrrow) {
        return glownaWynik[nrrow].slice(1);
    }
    const glownaWynik2021 = [];
    const glownaWynik2022 = [];
            <?php
        $licznik = 0;
        while($row = pg_fetch_row($ret)) {
            echo "const wynik". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "wynik". $licznik. ".push('". $cell. "'); \n";
            }
            if ($licznik < 5) {
                echo "glownaWynik2021.push(wynik". $licznik. "); \n";
            }else{
                echo "glownaWynik2022.push(wynik". $licznik. "); \n";
            }
             
#            print_r($row);
#            echo "<br>";
            $licznik++;
        };

        ?>

var options = {
          series: [{
          name: "Percentage of success",
          data: [{
            x: '1',
            y: (Math.round(glownaWynik2021[0][2]*100000))/1000
          }, {
            x: '2',
            y: (Math.round(glownaWynik2021[1][2]*100000))/1000
          }, {
            x: '3',
            y: (Math.round(glownaWynik2021[2][2]*100000))/1000
          }, {
            x: '4',
            y: (Math.round(glownaWynik2021[3][2]*100000))/1000
          }, {
            x: '5',
            y: (Math.round(glownaWynik2021[4][2]*100000))/1000
          }, {
            x: '1',
            y: (Math.round(glownaWynik2022[0][2]*100000))/1000
          }, {
            x: '2',
            y: (Math.round(glownaWynik2022[1][2]*100000))/1000
          }, {
            x: '3',
            y: (Math.round(glownaWynik2022[2][2]*100000))/1000
          }, {
            x: '4',
            y: (Math.round(glownaWynik2022[3][2]*100000))/1000
          }, {
            x: '5',
            y: (Math.round( glownaWynik2022[4][2]*100000))/1000
          }]
        }],
        dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + " %"
            }
        },

          chart: {
          type: 'bar',
          height: 380
        },
        xaxis: {
          type: 'category',
          labels: {
            formatter: function(val) {
              return val + " domain/s"
            }
          },
          group: {
            style: {
              fontSize: '10px',
              fontWeight: 700
            },
            groups: [
              { title: 'CWIX 2021', cols: 5 },
              { title: 'CWIX 2022', cols: 5 }
            ]
          }
        },
        yaxis: {
            min: 90,
            max: 100,
        forceNiceScale: false,
        },
        colors:['#F44336', '#E91E63', '#9C27B0', "#B2331A", "#AF7ACD"],
        plotOptions: {
          bar: {
            columnWidth: '45%',
            distributed: true,
          }
        },
        title: {
            text: 'Success rate of capabilities testing in X amount of domains ',
        },
        tooltip: {
          x: {
            formatter: function(val) {
              return val + " domain/s"
            }  
          }
        },
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
  
</script>

