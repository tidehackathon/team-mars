<!-- KPI number 6 -->
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
   pg_close($db);
   $test = $ret;
   $listaWynikow6 = [];
   while ($rr = pg_fetch_row($test)) {
       array_push($listaWynikow6, $rr);
   }

?>


<!-- KPI number 9 -->
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
   $ret2 = pg_query($db, $sql);
   if(!$ret2) {
      echo pg_last_error($db);
      exit;
   };
   pg_close($db);

$test = $ret2;
$listawynikow = [];
while ($rr = pg_fetch_row($test)) {
    array_push($listawynikow, $rr);
}
?>

<!-- KPI NUMBER 8 -->
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
            io_shortfall_ind,
            sum(s2.cou) / count(s2.cou) as Average_domain_complexity
            from
            (select 
                t.exercise_cycle,
                t.id,
                capability_id,
                t.io_shortfall_ind 
            from 
                testcases t 
            join
                test_participants tp 
            on
                t.id = tp.testcase_id 
            order by t.id asc) s1
            join
            (select 
                capability_id,
                count(operational_domain_id) as cou
            from capability_operational_domains cod 
            group by capability_id 
            order by 1 asc) s2
            on
            s1.capability_id = s2.capability_id
            group by exercise_cycle, io_shortfall_ind
            order by right(exercise_cycle, 4)
   EOF;
   $ret = pg_query($db, $sql);
   if(!$ret) {
      echo pg_last_error($db);
      exit;
   };
   pg_close($db);
   $test = $ret;
   $listaWynikow2 = [];
   while ($rr = pg_fetch_row($test)) {
       array_push($listaWynikow2, $rr);
   }

?>



<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href='navbarCss.css'>
<link rel="stylesheet" href='indexStyle.css'>
<link rel="stylesheet" href='containerFailed.css'>
    <head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    </head>
    <id class = "page" class = "not-selectable">
        <div id = leftNav>
                <div id = headerNav>
                    <div>KPI</div>
                </div>

                <li>
                    <u> World Map</u>
                    <div>
                            <div class = navArrow></div>
                                <a> Nation | Data </a>
                    </div>

                </li>
                <li>
                    <u> Timeline </u>
                    <div>
                        <div class = "openSite">
                            <div class = navArrow>&#8729;</div>
                            <a>Chart | Plots </a>
                        </div>
                    </div>
                </li>

                
    
            </div>
        <div id = rightSite>
            <div id = "wordbarContainer">

                <div id="wordbar">
                    <div class ="mapbarContainer left" style>
                        <div><b>Chart Overview</b></div>
                    </div>
                </div>

            </div>

            <div id = "failedContainer">

              <div id = "avgFailed">
                <div><u><b>Average domains</b></u></div>
                <div><b>IO shortfall indicator</b></div>
                <div id="cwixdj">
                    <div id="year"></div>
                    <div class = "ioContainer">

                      <div id="ionotind"></div>
                      <u><b>not</b> indicated:</u>
                      <div id="ioind"></div>
                      <u>indicated:</u>
                      </div>
                </div>

                <div id="cwixdd">
                    <div id="yeard"></div>
                    <div class = "ioContainer">
                    <div id="ionotindd"></div>
                    <u><b>not</b> indicated:</u>
                    <div id="ioindd"></div>
                    <u>indicated:</u>
                    </div>
              </div>

              </div>

              <div id = "avgFailed">

                <div><u><b>Average domains</b></u></div>
                <div><b>IO shortfall indicator</b></div>
                <div id="cwixdj">
                    <div id="year"></div>
                    <div class = "ioContainer">

                      <div id="ionotind"></div>
                      <u><b>not</b> indicated:</u>
                      <div id="ioind"></div>
                      <u>indicated:</u>
                      </div>
                </div>

                <div id="cwixdd">
                    <div id="yeard"></div>
                    <div class = "ioContainer">
                    <div id="ionotindd"></div>
                    <u><b>not</b> indicated:</u>
                    <div id="ioindd"></div>
                    <u>indicated:</u>
                    </div>
                </div>

              </div>

              <div id = "topFailed">
                <div><u>Most failing</u></div>
                <div>Interoperability standars</div>
                <div id = tabYear2021>
                  <ul>
                    <li>Standard 1</li>
                    <li>Standard 2</li>
                    <li>Standard 3</li>
                    <li>Standard 4</li>
                    <li>Standard 5</li>
                    <li>Standard 6</li>
                  </ul>  
                </div>
                <div id = tabYear2022>
                  <ul>
                    <li>Standard 1</li>
                    <li>Standard 2</li>
                    <li>Standard 3</li>
                    <li>Standard 4</li>
                    <li>Standard 5</li>
                    <li>Standard 6</li>
                  </ul>  
                </div>


              </div>
            </div>

            <div id = "containerTop">
                <div><u>Succes rate</u></div>
                <div>Interdisciplinary domains' capabillity</div>
                <div id="chart"></div>
            </div>

            <div id = "containerMiddle">
              <div><u>Successfull test cases</u></div>
            <div>Capabilities domains</div>
              <div id = "flexMiddle">
                  <div class = "chartMid" id="chart2021"></div>
                  <div class = "chartMid" id="chart2022"></div>
              </div>
            </div>

        </div>

</html>



<!-- KPI 6 -->
<script>
    function wynikowlista(nrwartosci, lista) {
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
        foreach ($listaWynikow6 as $row)  {
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

<!-- KPI 9 -->

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
    const Wynik2021glowna = [];
    const Wynik2022glowna = [];
            <?php
        $licznik = 0;
        foreach ($listawynikow as $row) {
            echo "const omegawynik". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "omegawynik". $licznik. ".push('". $cell. "'); \n";
            }
            if ($licznik < 16) {
                echo "Wynik2021glowna.push(omegawynik". $licznik. "); \n";
            }else{
                echo "Wynik2022glowna.push(omegawynik". $licznik. "); \n";
            }
             
#            print_r($row);
#            echo "<br>";
            $licznik++;
        };

        ?>
    var options2021 = {
          series: [{
          name: 'Success',
          data: listawynikow(2, Wynik2021glowna)
        }, {
          name: 'Limited Successes',
          data: listawynikow(3, Wynik2021glowna)
        }, {
          name: 'Pending',
          data: listawynikow(4, Wynik2021glowna)
        }, {
          name: 'Not Tested',
          data: listawynikow(5, Wynik2021glowna)
        }, {
          name: 'Interoperability Issue',
          data: listawynikow(6, Wynik2021glowna)
        }],
          chart: {
          type: 'bar',
          height: 500,
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
          categories: listawynikow(1, Wynik2021glowna),
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
    data: listawynikow(2, Wynik2022glowna)
  }, {
    name: 'Limited Successes',
    data: listawynikow(3, Wynik2022glowna)
  }, {
    name: 'Pending',
    data: listawynikow(4, Wynik2022glowna)
  }, {
    name: 'Not Tested',
    data: listawynikow(5, Wynik2022glowna)
  }, {
    name: 'Interoperability Issue',
    data: listawynikow(6, Wynik2022glowna)
  }],
    chart: {
    type: 'bar',
    height: 500,
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
    categories: listawynikow(1, Wynik2022glowna),
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

<!-- KPI 8 -->
<script>

    const gWynik2021 = [];
    const gWynik2022 = [];
            <?php
        $licznik = 0;
        foreach ($listaWynikow2 as $row) {
            echo "const wynikKPI6". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "wynikKPI6". $licznik. ".push('". $cell. "'); \n";
            }
            if ($row[0] == "CWIX 2021") {
                echo "gWynik2021.push(wynikKPI6". $licznik. "); \n";
            }else{
                echo "gWynik2022.push(wynikKPI6". $licznik. "); \n";
            }
             
#            print_r($row);
#            echo "<br>";
            $licznik++;
        };

        ?>
        function ReturnTrueFals(arrayofletters) {
    temp = []
    arrayofletters.forEach(element => {
        if (element == "f") {
            temp.push("No IO shortfall");
        }
        if (element == "t"){
            temp.push("Expirinced IO shortfall");
        }
    });
    return temp
}
//document.getElementById("cwixdj").innerHTML =  [glownaWynik2022[0][0], Math.round(glownaWynik2022[0][2]*10000)/10000, Math.round(glownaWynik2022[1][2]*10000)/10000]
document.getElementById("year").innerHTML =  gWynik2021[0][0];
document.getElementById("ionotind").innerHTML +=  Math.round(gWynik2021[0][2]*10000)/10000;
document.getElementById("ioind").innerHTML +=  Math.round(gWynik2021[1][2]*10000)/10000;
document.getElementById("yeard").innerHTML =  gWynik2022[0][0];
document.getElementById("ionotindd").innerHTML +=  Math.round(gWynik2022[0][2]*10000)/10000;
document.getElementById("ioindd").innerHTML +=  Math.round(gWynik2022[1][2]*10000)/10000;


      
</script>



