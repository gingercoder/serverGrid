<?php

/*
 * CORE SYSTEM FILE
 * Modify user password
 */

if(isset($_SESSION['username'])){
        
        // If post-back then save new password if it is correct
        if($_POST['save'] == "true"){
            if($_POST['password1'] == $_POST['password2']){
                if($_SESSION['passwd'] == md5($_POST['oldpassword'].$myApp['passwordSeed'])){
                    $changepassword = $ObjFramework->changePassword($_SESSION['username'], $_POST['password1'], $myApp['passwordSeed']);
                    if($changepassword == true){
                        $errormsg = "Password has been changed";
                    }
                    else{
                        $errormsg = "Could not change password at this time, please try again";
                    }
                }
                else{
                    $errormsg = "Incorrect current password";
                }
            }
            else{
                $errormsg = "Passwords do not match";
            }
            
        }
        else{
            $errormsg = "Enter the information to change your password.";
        }

        require_once('web/servergrid/core/navigation.php');
        require_once('web/core/security/password.php');
}
else{
    require_once('view/core/login.php');
}

?>
