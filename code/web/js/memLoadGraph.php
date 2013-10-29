<script type="text/javascript">

    google.load("visualization", "1", {packages:["corechart"]});
    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawMemChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawMemChart() {

        // Set chart options
        var options = {'title': 'Free Memory'};

        // Create the data tables.
        <?php
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        $myuserid = $ObjSG->usernametoid($_SESSION['username']);

        foreach($serverList as $server){
            if(($limitToServer == false)||($limitToServer == $server['serverid'])){
                $firstcount = 0;
                $serverStats = $ObjSG->getServerStats($myuserid, $server['serverid']);
                if($serverStats){
                    echo "
                        var graphmem".$server['serverid']." = google.visualization.arrayToDataTable([\n
                        ['Time', 'Free Mem'],\n";

                            foreach($serverStats as $mystat){
                                    $mymemdirty = $mystat['freemem'];
                                    $mymem = preg_replace('!\s+!', ' ', $mymemdirty);

                                    $freemem = explode(' ',$mymem);

                                    if($freemem[1] == ""){
                                        $memfree = 0;
                                    }
                                    else{
                                        $memfree = $freemem[1];
                                    }
                                    $timecreated = substr($mystat['dateCreated'], -8, 5);
                                    if($firstcount >= 1){
                                        echo ",\n";
                                    }
                                    $firstcount++;
                                    echo "['".$timecreated."', ".$memfree."]";
                            }
                        echo" ]);\n";

                    // Instantiate and draw our chart, passing in some options.
                    echo "var chartmem".$server['serverid']." = new google.visualization.LineChart(document.getElementById('graphmem".$server['serverid']."'));\n";

                    echo "chartmem".$server['serverid'].".draw(graphmem".$server['serverid'].", options);\n";
                }
            }
        }
        ?>

    }
</script>