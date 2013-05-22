<?php

/*
 *  __  __ _                ______                                           _    
 * |  \/  (_)              |  ____|                                         | |   
 * | \  / |_  ___ _ __ ___ | |__ _ __ __ _ _ __ ___   _____      _____  _ __| | __
 * | |\/| | |/ __| '__/ _ \|  __| '__/ _` | '_ ` _ \ / _ \ \ /\ / / _ \| '__| |/ /
 * | |  | | | (__| | | (_) | |  | | | (_| | | | | | |  __/\ V  V / (_) | |  |   < 
 * |_|  |_|_|\___|_|  \___/|_|  |_|  \__,_|_| |_| |_|\___| \_/\_/ \___/|_|  |_|\_\
 * Core Application system - Main System Control Methods - Core program heart
 */

class MicroFramework {
    
        /*
         * 
         * Log events in the system, passed parameters from each module
         * 
         */
         
        public function logevent($logArea, $logAction)
        {
            $sql = "INSERT INTO logs
                    SET
                    logged=NOW(),
                    userid='" . $this->usernametoid($_SESSION['username']) . "',
                    userAction='" . db::escapechars($logAction) . "'
                    ";
            
            $result = db::execute($sql);
        }

        /*
         * Function to log faults in the system
         * If write-error with the DB, this generates a logfile and
         * appends information for the day to it.
         */
        public function logfault($logArea, $logAction)
        {
            $sql = "INSERT INTO faultlog
                    SET
                    logged=NOW(),
                    userid='" . $this->usernametoid($_SESSION['username']) ."',
                    userAction='" . db::escapechars($logAction) . "'";
            $result = db::execute($sql);
            if(!$result){
                $logfile = 'log/err_log_'.date('Ymd').'.txt';
                file_put_contents($logfile, $sql, FILE_APPEND | LOCK_EX);
            }
        }
    
        /*
         * return the user ID for a particular user name
         * used in several functions throughout the system
         * 
         */
        public function usernametoid($username){
            $userName = db::escapechars($username);
            $sql = "SELECT * FROM users WHERE username = '$userName'";
            $result = db::returnrow($sql);
            return $result['userid'];
        }
        
        /*
         * return the user ID for a particular user name
         * used in several functions throughout the system
         * 
         */
        public function useridtoname($userid){
            $userid = db::escapechars($userid);
            $sql = "SELECT username FROM users WHERE userid = '$userid'";
            $result = db::returnrow($sql);
            return $result['emailAddress'];
        }
        
        
        /*
        * Function to get user information
        * 
        */
       public function getUserInfo($userid)
       {
           $username = db::escapechars($userid);

           $sql = "SELECT * FROM 
                       users 
                   WHERE
                       userid='$userid'
                   ";
           $result = db::returnrow($sql);
           return $result;
       }
        
    
        /*
         * Email a user with some information
         * 
         */
        public function emailUser($userid, $subject, $message='')
        {
            // Get user information
            $userid = db::escapechars($userid);
            $userinfo = $this->getUserInfo($userid);
            $to = $userinfo['emailaddress'];
            // set headers and pretty mail formatting
            $headers = $this->prettyEmail($plainmessage, $subject);
            // send the email to the user
            $sendmail = mail($to, $subject, '', $headers);
            if($sendmail){
                // successful event so log
                $logmessage = $subject.' email sent by '.$_SESSION['username'];
                $this->logevent('Email System', $logmessage);
            }
            else{
                $errortoggle = 1;
            }
            
            // verify state and return
            if($errortoggle == 1){
                return false;
            }
            else{
                return true;
            }
        }
    
        /*
         * Function to beautify the email sent from the system
         * Creates a nice HTML email instead of plain text
         */
        
        public function prettyEmail($mymessage, $subject)
        {              
                // App settings
                $myApp = $this->getAppSettings();

                // PLAIN TEXT INFORMATION FOR EMAIL
                $bodyt = $mymessage;

                // HTML BODY FOR EMAIL
                $bodyh = "
                      <html><head><title>".$subject."</title></head>
                      <body><p style=\"font-size: 24pt; font-family: helvetica, arial, sans-serif; background-color: #6699cc; color: #fff; display: block; width: 100%; padding: 15px;\">" . $subject . "</p>
                            <p>".$mymessage."</p>
                            <p style=\"font-size: 18pt; font-family: helvetica, arial, sans-serif; background-color: #6699cc; color: #fff; display: block; width: 100%; padding: 15px;\">".$myApp['appTitle']."</p>
                            <p>".$myApp['emailFooter']."</p>
                       </body></html>";


                // Main settings for the email
                $semi_rand = md5(time());
                $mime_boundary = "MULTIPART_BOUNDARY_$semi_rand";

                $fromemailsetting = "From: ".$myApp['emailSentFrom'];
                $replyemailsetting = "Reply-To: ".$myApp['emailSentFrom'];
                $returnpath = "Return-Path:<".$myApp['emailSentFrom'].">";

                // Start Email content ( all stored in header for multi part encoding )

                $headers =  $fromemailsetting . "\n" . $replyemailsetting  . "\n" . $returnpath . "\n". 'X-Mailer: PHP/' . phpversion() . "\n";

                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: multipart/alternative; boundary=" . $mime_boundary . "\r\n";
                $headers .= "\n--$mime_boundary\n";
                $headers .= "Content-Type: text/plain; charset=iso-8859-1\r\n";
                $headers .= "Content-Transfer-Encoding: 7bit\r\n";
                $headers .= "$bodyt";
                $headers .= "\n--$mime_boundary\n";
                $headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
                $headers .= "Content-Transfer-Encoding: 7bit\r\n";
                $headers .= "$bodyh";
            
            return $headers;
        }
        
        
        
        /*
         * Modify password for a user
         * 
         */
        public function changePassword($username, $password, $seededpassword)
        {
            $username = db::escapechars($username);
            
            $passwordmd5 = md5($password.$seededpassword);
            $sql = "UPDATE 
                        users 
                    SET 
                        password='$passwordmd5' 
                    WHERE 
                        username='$username' 
                    LIMIT 1";
            $result = db::execute($sql);
            if($result){
                $_SESSION['passwd'] = $passwordmd5;
                return true;
            }
            else{
                return false;
            }
        }
        
        /*
     * Reset password
     * Autogenerates a new password and emails the user
     * 
     */
    public function resetPassword($userid, $seededpassword, $newpasswd='')
    {
        $userid = db::escapechars($userid);
        $newpasswd = db::escapechars($newpasswd);
        if(is_null($newpasswd)){
            $newpassword = $this->generatePassword();
        }
        else{
            $newpassword = $newpasswd;
        }
        
        $newpasswordmd5 = md5($newpassword.$seededpassword);
        $sql = "UPDATE 
                    users
                SET
                    password='$newpasswordmd5'
                WHERE
                    userid='$userid'
                LIMIT 1";
        
        $resetpass = db::execute($sql);
        if($resetpass){
            // Log the activity
            $logType = "Reset Password";
            $IPAddress = $_SERVER["REMOTE_ADDR"];
            $myusername = $_SESSION['username'];
            $theirusername = $this->useridtoname($userid);
            $logValue = "$myusername reset user password for user ( $theirusername )";
                   
            $this->logevent($logType, $logValue);
            
            $message = "<h2>Password Reset</h2><p>Hi, a reset password request was sent for your account ($theirusername).</p><p>Your new password is $newpassword</p><p>You should change this as soon as possible</p>";
            $this->emailUser($userid, 'Password Reset', $message);
            return true;
        }
        else{
            
            return false;
        }
        
    }
    
    /*
     * Function to generate a random password
     * 
     */
    public function generatePassword()
    {
        
        $keyfields = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ01234567890";
        $apassword = "";
        $seed = floor(time() /86400);
        srand($seed);
        for($i=0;$i<7;$i++){
            
            $randstart = rand(0,strlen($keyfields));
            
            $apassword .= substr($keyfields, $randstart, 1);
        }
        
        return $apassword;
    }
    
    /*
     * Get the main application settings for the system
     *
     */
    public function getAppSettings()
    {
        // Pull all settings from the database
        $sql = "SELECT * FROM framework_settings";
        $settings = db::returnallrows($sql);
        $myApp = array();

        foreach($settings as $setting){
            // Load Setting into myApp array
            $myApp[$setting['settingName']] = $setting['settingValue'];
        }
        return $myApp;
    }
}

?>
