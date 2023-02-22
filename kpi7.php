
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        s3.exercise_cycle,
        s3.perm,
        coalesce(s2.con, 0) as number_of_happenings
        from 
        (select
            s2.perm,
            tp.exercise_cycle,
            count(s2.capability_id) as con
        from
            test_participants tp 
            join
                (select 
                    cod.capability_id, 
                    string_agg(cod.operational_domain_id::varchar(100), '') as perm
                    from
                        capability_operational_domains cod 
                    group by capability_id
                    order by capability_id  asc) as s2
            on
                tp.capability_id = s2.capability_id
        group by
            s2.perm, tp.exercise_cycle 
        order by
            perm asc, right(exercise_cycle, 4) asc) s2
        right join
        (select
            *
        from 
            (select
                t.exercise_cycle 
            from 
                testcases t 
            group by
                1
            order by 
                1) s1
        join
            (select
                s1.perm
            from
                (select 
                    cod.capability_id as cid, 
                    string_agg(cod.operational_domain_id::varchar(100), '') as perm
                from
                    capability_operational_domains cod 
                group by capability_id
                order by capability_id  asc) s1
            group by 1
            order by s1.perm::numeric) s2
        on
            true) s3
        on
        s2.exercise_cycle = s3.exercise_cycle and s2.perm = s3.perm



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
        Legend:<br>
        1	Air<br>
        2	Land<br>
        3	Maritime<br>
        4	Cyberspace<br>
        5	Space<br>
        6	Other Support Services<br>
        <?php
        $test = $ret;
        $listaWynikow = [];
        while ($rr = pg_fetch_row($test)) {
            array_push($listaWynikow, $rr);
        }
         ?> 
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
    function listawynikow2(nrwartosci, lista) {
        const temp = []
        lista.forEach(element => {
            array.forEach(element2 => {
                temp.push(element2[nrwartosci])
            });
        });
        return temp
    }
    function wynikirow(nrrow) {
        return glownaWynik[nrrow].slice(1);
    }
    const glownaWynik = [];

            <?php
        $licznik = 0;
        foreach ($listaWynikow as $row) {
            echo "const wynik". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "wynik". $licznik. ".push('". $cell. "'); \n";
            }
                echo "glownaWynik.push(wynik". $licznik. "); \n";;
                $licznik++;
        }
        while($row = pg_fetch_row($ret)) {
            echo "const wynik". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "wynik". $licznik. ".push('". $cell. "'); \n";
            }
                echo "glownaWynik.push(wynik". $licznik. "); \n";;
                $licznik++;
            };
#            print_r($row);
#            echo "<br>";
            
        

        ?>
    //console.log(listawynikow(0, glownaWynik2021));
    //console.log(listawynikow(0, glownaWynik2022));
    //console.log(listawynikow(2, glownaWynik2021));
    //console.log(listawynikow(2, glownaWynik2022));

        var options = {
          series: [{
          name: 'CWIX 2021',
          data: [<?php 
          $licznik = 1;
          foreach ($listaWynikow as $key) {

                if ($key[0] == "CWIX 2021") {
                    echo "{
                        x: '".$licznik."',
                        y: '".$key[2]."'
                    },
                        ";
                        $licznik++;
                }
          } 
          ?>{
                x:62,
                y:0
            }
          ],
        },{
            name: "CWIX 2022",
            data: [<?php 
            $licznik2 = 1;
          foreach ($listaWynikow as $key) {
                if ($key[0] == "CWIX 2022") {
                    echo '{
                        x: '.$licznik2.',
                        y: "'.$key[2].'"
                    },
                        ';
                    $licznik2++;
                    }
          }
          ?>{
                x:62,
                y:0
          }]
        }

        ],
          chart: {
          type: 'area',
          height: 350,
          animations: {
            enabled: true
          }
        },
        xaxis: {
            type: "category",
            tickAmount: 'dataPoints',
            categories:[ <?php 
            $licznik = 0;
                foreach ($listaWynikow as $key) {
                    if ($licznik < 62) {
                        echo $key[1].",";
                        $licznik++;
                    }
                }
            ?>]
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    
      
</script>

