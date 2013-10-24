<?php

/*
 * FRAMEWORK SYSTEM FILE
 * Page Footer and jQuery Loading
 * DB Closed at page end
 */


db::disconnect();

?>
<footer>
    <?php echo $myApp['footerInfo']; ?>
</footer>

        <!-- Bootstrap and jQuery Includes to reduce loading pauses -->
        <script src="/web/js/jquery-1.9.1.min.js"></script>
        <script src="/web/js/bootstrap.min.js"></script>
    <?php
    if(($b == "virtualrack") && ($c == "display")){
    ?>
        <script type="text/javascript">
            var loadUrl = "/web/js/pingserver.php";

            $("#clickForPing").click(function(){
                $.get(
                    loadUrl,
                    {language: "php", version: 5, serverid: <?php echo $d;?>},
                    function(responseText){
                        $("#clickForPingResult").html(responseText);
                    },
                    "html"
                );
            });



        </script>
    <?php
    }
    ?>
</body>
</html>
