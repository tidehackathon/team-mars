
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
        exercise_cycle, fa."name", success, limited_success, pending, not_tested, interoperability_issue
        from
        focus_areas fa 
        join
        (select
        s1.exercise_cycle,
        focus_area_id,
        count(case when s1.overall_result = 'Success' then 1 end) as Success,
        count(case when s1.overall_result = 'Limited Success' then 1 end) as Limited_success,
        count(case when s1.overall_result = 'Pending' then 1 end) as Pending,
        count(case when s1.overall_result = 'Not Tested' then 1 end) as Not_Tested,
        count(case when s1.overall_result = 'Interoperability Issue' then 1 end) as Interoperability_Issue
        from
        objectives o 
        join
        (select
            t.exercise_cycle,
            t.id,
            to2.objective_id,
            t.overall_result 
        from 
            testcases t 
        join
            test_objectives to2 
        on
            t.id = to2.testcase_id ) s1
        on 
        o.id = s1.objective_id
        group by 
        s1.exercise_cycle, focus_area_id
        order by 
        focus_area_id  asc) s1
        on
        fa.id = s1.focus_area_id
        order by 
        right(exercise_cycle, 4), 2
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
        <div id="chart2021"></div>
        <div id="chart2022"></div>
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
            if ($licznik < 16) {
                echo "glownaWynik2021.push(wynik". $licznik. "); \n";
            }else{
                echo "glownaWynik2022.push(wynik". $licznik. "); \n";
            }
             
#            print_r($row);
#            echo "<br>";
            $licznik++;
        };

        ?>
    var options2021 = {
          series: [{
          name: 'Success',
          data: listawynikow(2, glownaWynik2021)
        }, {
          name: 'Limited Successes',
          data: listawynikow(3, glownaWynik2021)
        }, {
          name: 'Pending',
          data: listawynikow(4, glownaWynik2021)
        }, {
          name: 'Not Tested',
          data: listawynikow(5, glownaWynik2021)
        }, {
          name: 'Interoperability Issue',
          data: listawynikow(6, glownaWynik2021)
        }],
          chart: {
          type: 'bar',
          height: 700,
          stacked: true,
          stackType: '100%'
        },
        plotOptions: {
          bar: {
            horizontal: true,
          },
        },
        stroke: {
          width: 1,
          colors: ['#fff']
        },
        title: {
          text: '100% Stacked Bar'
        },
        xaxis: {
          categories: listawynikow(1, glownaWynik2021),
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + ""
            }
          }
        },
        fill: {
          opacity: 1
        
        },
        legend: {
          position: 'top',
          horizontalAlign: 'left',
          offsetX: 40
        }
        };

        var chart2021 = new ApexCharts(document.querySelector("#chart2021"), options2021);
        chart2021.render();



        var options2022 = {
            series: [{
    name: 'Success',
    data: listawynikow(2, glownaWynik2022)
  }, {
    name: 'Limited Successes',
    data: listawynikow(3, glownaWynik2022)
  }, {
    name: 'Pending',
    data: listawynikow(4, glownaWynik2022)
  }, {
    name: 'Not Tested',
    data: listawynikow(5, glownaWynik2022)
  }, {
    name: 'Interoperability Issue',
    data: listawynikow(6, glownaWynik2022)
  }],
    chart: {
    type: 'bar',
    height: 700,
    stacked: true,
    stackType: '100%'
  },
  plotOptions: {
    bar: {
      horizontal: true,
    },
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  title: {
    text: '100% Stacked Bar'
  },
  xaxis: {
    categories: listawynikow(1, glownaWynik2022),
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + ""
      }
    }
  },
  fill: {
    opacity: 1
  
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left',
    offsetX: 40
  }
        };

        var chart2022 = new ApexCharts(document.querySelector("#chart2022"), options2022);
        chart2022.render();


</script>

