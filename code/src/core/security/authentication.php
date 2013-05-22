<?php

/*
 * Core System Authentication
 */

class authentication extends MicroFramework{
    
    
    public function doauth($username, $password, $seededpassword)
    {
        // Authenticate from the main login form
        
        $username = db::escapechars($username);
        $password = db::escapechars($password);
        
        /* --- Firewall IDS Detection Routine -- 
         * check how many failed authentications have taken place
         * in the past five minutes to auto-lock spam attempts
         */
        $startTime = date('Y-m-d H:i:s',mktime(date('H'), (date('i')-5), date('s'))); // five minutes ago
        $nowTime = date ('Y-m-d H:i:s'); // now

        $todayDate = date('Y-m-d'); // today
        $sql = "SELECT
                    *
                FROM
                    logs
                WHERE
                    logValue
                        LIKE '$username Failed auth%'
                AND
                    (
                    logged
                        BETWEEN '$startTime' AND '$nowTime'
                    )";
        
        $numFailedAuths = 0;
        $numFailedAuths = db::getnumrows($sql);
        // If less than maximum of 5 failed authentications reached do auth, else give a message.
        if($numFailedAuths < 5)
        {
            $sql = "SELECT * FROM users WHERE username = '$username'";
            $result = db::returnrow($sql);
            if($result)
            {
                $resultArray = db::returnrow($sql);
                // If there is a match set the session variables
                $md5Pass = md5($password.$seededpassword);
                if($md5Pass == $resultArray['password'])
                {
                    $userID = $resultArray['userid'];
                    $userType = $resultArray['usertype'];

                    // Set the session variables
                    $_SESSION['username']= $username;
                    $_SESSION['passwd'] = $md5Pass;
                    $_SESSION['utype'] = $userType;

                    // Log the activity
                    $logType = "System Auth";
                    $IPAddress = $_SERVER["REMOTE_ADDR"];
                    $logValue = "$username Successful auth from $IPAddress";
                    
                    $this->logevent($logType, $logValue);

                    // return success of auth
                    $successcode = "ok";
                    return $successcode;
                }
                else
                {
                    // Log the activity
                    $logType = "System Auth";
                    $IPAddress = $_SERVER["REMOTE_ADDR"];
                    $logValue = "$username Failed auth from $IPAddress - Incorrect Password";
                   
                    $this->logevent($logType, $logValue);

                    // return failure
                    $failcode = "fail";
                    return $failcode;
                }
             }
             else
                 {
                     // Couldn't find the username in the database
                     // Log the activity
                     $logType = "System Auth";
                     $IPAddress = $_SERVER["REMOTE_ADDR"];
                     $logValue = "$username Failed auth from $IPAddress - I could not find that user";

                     $this->logevent($logType, $logValue);

                     // Return the failure code
                     $failcode = "fail";
                     return $failcode;
                 }
       }
       else
       {
            // Maximum failure attempts reached - return failure code
           $failcode = "toomany";
           return $failcode;
       }
        
    }
    
    
    
    
    
    /*
     * 
     * Maintain authentication of the system throughout page loads
     * re-check the session variables against the system in case of
     * injection or manipulation
     * 
     */
    
    
    public function maintainauth()
    {
        
        // Maintain Authentication using session variables and a connection to the DB
        
        if(($_SESSION['username'] == "") || ($_SESSION['passwd'] == "") || ($_SESSION['utype'] == ""))
        {
            if(($_POST['username'] !== "") && ($_POST['passwd'] !== "") && ($_POST['z'] == "login"))
            {
                // Authenticating against scripts so allow through this check script
                return 'authing';
            }
            else
            {
                // Log in form required
                return 'noauth';    
            }
        }
        else
        {
            /*
            *
            * Should be authenticated ok but always check the authentication
            * in case SESSION vars are being tampered with
            *
            */
            $username = strip_tags(stripslashes($_SESSION['username']));
            $sql = "SELECT * FROM users WHERE username = '".$username."'";
            $result = db::returnrow($sql);
            if($result){
                    // If there is a match set the session variables
                    if($_SESSION['passwd'] == $result['password']){
                            $_SESSION['username'] = $username;
                            $_SESSION['passwd'] = $_SESSION['passwd'];
                            $_SESSION['utype'] = $result['usertype'];
                            return 'auth';
                    }
                    else{
                            // Stored data doesn't match that passed to it
                            // Kill the session variables and give an error message
                            $_SESSION['username'] = "";
                            $_SESSION['passwd'] = "";
                            $_SESSION['utype'] = "";
                            session_destroy();
                            return 'noauth';
                    }
            }
            else{
                    // Couldn't get the username - need to authenticate again because something is wrong
                    return 'noauth';
            }
         }
        }
        
        
        
        
        
        
        /*
         * LOG OUT OF THE SYSTEM
         * Kill all session variables
         * 
         */
        public function logout()
        {
            // Kill the session variables and give an error message
            $_SESSION['username'] = "";
            $_SESSION['passwd'] = "";
            $_SESSION['utype'] = "";
            session_destroy();
        }
        
}
?>
