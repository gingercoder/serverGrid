<script type="text/javascript">


    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawMemChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawMemChart() {

        // Set chart options
        var options = {title: 'Memory Usage'};

        // Create the data tables.
        <?php
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        $myuserid = $ObjSG->usernametoid($_SESSION['username']);

        foreach($serverList as $server){
            $firstcount = 0;
            $serverStats = $ObjSG->getServerStats($myuserid, $server['serverid']);
            if($serverStats){
                echo "
                    var graphmem".$server['serverid']." = google.visualization.arrayToDataTable([\n
                    ['Time', 'Free Mem'],\n";

                        foreach($serverStats as $mystat){

                            $freemem = explode(' ',$mystat['freemem']);

                            if($freemem[6] == ""){
                                $memfree = 0;
                            }
                            else{
                                $memfree = $freemem[6];
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
        ?>

    }
</script>