
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
   $sql21 =<<<EOF
        select 
        n,
        test_fail_propability_2021
        from 
        (select 
            s1.name as n,
            (s1.cwix_2021_bad::float / nullif(s2.cwix_2021_all,0)) as test_fail_propability_2021,
            (s1.cwix_2022_bad::float / nullif(s2.cwix_2022_all,0)) as test_fail_propability_2022
        from
            (select 
                s1.name,
                count(case when s1.exercise_cycle = 'CWIX 2021' then 1 end) as CWIX_2021_bad,
                count(case when s1.exercise_cycle = 'CWIX 2022' then 1 end) as CWIX_2022_bad
            from 
                (select 
                    s2.id,
                    s1.name,
                    s2.exercise_cycle,
                    s2.overall_result
                from 
                    (select 
                        s.name,
                        ts.testcase_id
                    from 
                        standards s 
                    join
                        testcase_standards ts 
                    on
                        s.id = ts.standard_id) s1
                join 
                    (select 
                        t.id,
                        exercise_cycle,
                        t.overall_result 
                    from 
                        testcases t 
                    where 
                        overall_result != 'Success' and not io_shortfall_ind) s2
                on
                    s1.testcase_id = s2.id) s1
            join 
                (select
                    tic.testcase_id,
                    ic.name	
                from 
                    issue_categories ic 
                join
                    testcase_issue_categories tic 
                on
                    ic.id = tic.issue_category_id 
                where 
                    ic.id != 9 and ic.id != 12) s2
            on
                s1.id = s2.testcase_id
            group by 
                1) s1
        join	
            (select 
                s1.name,
                count(case when s1.exercise_cycle = 'CWIX 2021' then 1 end) as CWIX_2021_all,
                count(case when s1.exercise_cycle = 'CWIX 2022' then 1 end) as CWIX_2022_all
            from 
                (select 
                    s2.id,
                    s1.name,
                    s2.exercise_cycle,
                    s2.overall_result
                from 
                    (select 
                        s.name,
                        ts.testcase_id
                    from 
                        standards s 
                    join
                        testcase_standards ts 
                    on
                        s.id = ts.standard_id) s1
                join 
                    (select 
                        t.id,
                        exercise_cycle,
                        t.overall_result 
                    from 
                        testcases t 
                    where 
                        not io_shortfall_ind) s2
                on
                    s1.testcase_id = s2.id) s1
            join 
                (select
                    tic.testcase_id,
                    ic.name
                from 
                    issue_categories ic 
                join
                    testcase_issue_categories tic 
                on
                    ic.id = tic.issue_category_id ) s2
            on
                s1.id = s2.testcase_id
            group by 
                1) s2 
        on
            s1.name = s2.name) s1
        where 
        test_fail_propability_2021 = 1
   EOF;
   $sql22 =<<<EOF
    select 
        n,
        test_fail_propability_2022
    from 
        (select 
            s1.name as n,
            (s1.cwix_2021_bad::float / nullif(s2.cwix_2021_all,0)) as test_fail_propability_2021,
            (s1.cwix_2022_bad::float / nullif(s2.cwix_2022_all,0)) as test_fail_propability_2022
        from
            (select 
                s1.name,
                count(case when s1.exercise_cycle = 'CWIX 2021' then 1 end) as CWIX_2021_bad,
                count(case when s1.exercise_cycle = 'CWIX 2022' then 1 end) as CWIX_2022_bad
            from 
                (select 
                    s2.id,
                    s1.name,
                    s2.exercise_cycle,
                    s2.overall_result
                from 
                    (select 
                        s.name,
                        ts.testcase_id
                    from 
                        standards s 
                    join
                        testcase_standards ts 
                    on
                        s.id = ts.standard_id) s1
                join 
                    (select 
                        t.id,
                        exercise_cycle,
                        t.overall_result 
                    from 
                        testcases t 
                    where 
                        overall_result != 'Success' and not io_shortfall_ind) s2
                on
                    s1.testcase_id = s2.id) s1
            join 
                (select
                    tic.testcase_id,
                    ic.name	
                from 
                    issue_categories ic 
                join
                    testcase_issue_categories tic 
                on
                    ic.id = tic.issue_category_id 
                where 
                    ic.id != 9 and ic.id != 12) s2
            on
                s1.id = s2.testcase_id
            group by 
                1) s1
        join	
            (select 
                s1.name,
                count(case when s1.exercise_cycle = 'CWIX 2021' then 1 end) as CWIX_2021_all,
                count(case when s1.exercise_cycle = 'CWIX 2022' then 1 end) as CWIX_2022_all
            from 
                (select 
                    s2.id,
                    s1.name,
                    s2.exercise_cycle,
                    s2.overall_result
                from 
                    (select 
                        s.name,
                        ts.testcase_id
                    from 
                        standards s 
                    join
                        testcase_standards ts 
                    on
                        s.id = ts.standard_id) s1
                join 
                    (select 
                        t.id,
                        exercise_cycle,
                        t.overall_result 
                    from 
                        testcases t 
                    where 
                        not io_shortfall_ind) s2
                on
                    s1.testcase_id = s2.id) s1
            join 
                (select
                    tic.testcase_id,
                    ic.name
                from 
                    issue_categories ic 
                join
                    testcase_issue_categories tic 
                on
                    ic.id = tic.issue_category_id ) s2
            on
                s1.id = s2.testcase_id
            group by 
                1) s2 
        on
            s1.name = s2.name) s1
    where
        test_fail_propability_2022 = 1
EOF;
   $ret21 = pg_query($db, $sql21);
   if(!$ret21) {
      echo pg_last_error($db);
      exit;
   };
   $ret22 = pg_query($db, $sql22);
   if(!$ret22) {
      echo pg_last_error($db);
      exit;
   };
   pg_close($db);
   $listaWynikow21 = [];
   while ($rr = pg_fetch_row($ret21)) {
       array_push($listaWynikow21, $rr);
   }
   $listaWynikow22 = [];
   while ($rr = pg_fetch_row($ret22)) {
       array_push($listaWynikow22, $rr);
   }
?>
<!DOCTYPE html>
<html lang="en">
    <head>

    </head>
   <body>
    <ul>
    <li>2021</li>
    <?php 
        for ($i=0; $i < 16; $i++) { 
            echo "<li>".$listaWynikow21[$i][0]."</li>";
        }
        ?>
    </ul> 
    <ul>
        <li>2022</li>
        <?php 
        for ($i=0; $i < 16; $i++) { 
            echo "<li>".$listaWynikow22[$i][0]."</li>";
        }
        ?>
    </ul> 
   </body>

</html>

      
</script>

