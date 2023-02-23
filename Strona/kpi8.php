
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
   $listaWynikow = [];
   while ($rr = pg_fetch_row($test)) {
       array_push($listaWynikow, $rr);
   }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <style>
#cwixdd, #cwixdj {
    box-shadow: 0 0 5px 5px #4d4b4b56, 0 0 0 0 #66ccff;
    margin: 1%;
    width: 45%;
    font-size: larger;
    float: left;
    text-align: center;
}
#ionotind, #ionotindd{
    font-size:large;
    float: left;
    width: 50%;
    text-align: center;
}
#ioind, #ioind {
  font-size:large;
    float: left;
    width: 50%;
    text-align: center;
}
    </style>

    </head>
   <body>
        <div id="cwixdj">
          <div id="year">
          </div>
          <div id="ionotind">IO <b>not</b> indicated: </div>
          <div id="ioind"> OI indicated: </div>
        </div>
        <div id="cwixdd">
        <div id="yeard">
          </div>
          <div id="ionotindd">IO <b>not</b> indicated: </div>
          <div id="ioindd">IO indicated: </div>
        </div>
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
        foreach ($listaWynikow as $row) {
            echo "const wynik". $licznik. " = [];\n";       
            foreach($row  as $cell) {
                echo "wynik". $licznik. ".push('". $cell. "'); \n";
            }
            if ($row[0] == "CWIX 2021") {
                echo "glownaWynik2021.push(wynik". $licznik. "); \n";
            }else{
                echo "glownaWynik2022.push(wynik". $licznik. "); \n";
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
document.getElementById("year").innerHTML =  glownaWynik2021[0][0];
document.getElementById("ionotind").innerHTML +=  Math.round(glownaWynik2021[0][2]*10000)/10000;
document.getElementById("ioind").innerHTML +=  Math.round(glownaWynik2021[1][2]*10000)/10000;
document.getElementById("yeard").innerHTML =  glownaWynik2022[0][0];
document.getElementById("ionotindd").innerHTML +=  Math.round(glownaWynik2022[0][2]*10000)/10000;
document.getElementById("ioindd").innerHTML +=  Math.round(glownaWynik2022[1][2]*10000)/10000;


      
</script>

