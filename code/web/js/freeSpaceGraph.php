<?php
/**
 * Free Space Pie Chart
 * For information on the / partition of a server
 */

if($d){
$usedSpace = $ObjSG->getUsedSpace($d);
$freeSpace = 100 - $usedSpace;
?>
<script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1.0', {'packages':['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawFreeSpaceChart);

    // Callback that creates and populates a data table,
    // instantiates the pie chart, passes in the data and
    // draws it.
    function drawFreeSpaceChart() {

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Space');
        data.addColumn('number', 'Percent');
        data.addRows([
            ['Used', <?php echo $usedSpace;?>],
            ['Free', <?php echo $freeSpace;?>]
        ]);

        // Set chart options
        var options = {'title':'Disk utilisation on / partition',
            'width':250,
            'height':250,
            'colors':['#df8505','#336699'],
            'pieHole': 0.3
        };

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('freespace_graph_div'));
        chart.draw(data, options);
    }
</script>
<?
}
?>