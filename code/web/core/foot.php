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


</body>
</html>
