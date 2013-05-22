<script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawChart() {

        // Set chart options
        var options = {title: 'Server Load'};

        // Create the data tables.
        <?php
        $serverList = $ObjSG->getServerList($ObjFramework->usernametoid($_SESSION['username']));
        $myuserid = $ObjSG->usernametoid($_SESSION['username']);

        foreach($serverList as $server){
            $firstcount = 0;
            $serverStats = $ObjSG->getServerStats($myuserid, $server['serverid']);
            if($serverStats){
                echo "
                    var graph".$server['serverid']." = google.visualization.arrayToDataTable([\n
                    ['Time', 'CPU Load'],\n";

                        foreach($serverStats as $mystat){

                            $avload = explode(' ',$mystat['loadAverage']);
                            if($avload[0] == ""){
                                $serverload = 0;
                            }
                            else{
                                $serverload = $avload[0];
                            }
                            $timecreated = substr($mystat['dateCreated'], -8, 5);
                            if($firstcount >= 1){
                                echo ",\n";
                            }
                            $firstcount++;
                            echo "['".$timecreated."', ".$serverload."]";
                        }
                    echo" ]);\n";

                // Instantiate and draw our chart, passing in some options.
                echo "var chart".$server['serverid']." = new google.visualization.LineChart(document.getElementById('graph".$server['serverid']."'));\n";

                echo "chart".$server['serverid'].".draw(graph".$server['serverid'].", options);\n";
            }
        }
        ?>

    }
</script>