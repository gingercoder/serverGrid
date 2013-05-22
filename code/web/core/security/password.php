<?php

/*
 * Change Password
 */


?><br/><br/>
<div class="container-fluid">
      <div class="row-fluid">
          <div class="span6">
              <br/>
              <h2>System Messages</h2>
              <p><?php echo $errormsg; ?></p>
          </div>
          
          <div class="span6">
              <br/>
            <h1>Change Password</h1>
            <form name="passwordform" action="/index.php" method="post">
                <p>
                <label for="oldpassword"><strong>Old Password:</strong></label>
                <input type="password" name="oldpassword" id="oldpassword" class="input-block-level" />
                </p>
                <p>
                <label for="password1"><strong>New Password:</strong></label>
                <input type="password" name="password1" id="password1" class="input-block-level" />
                </p>
                <p>
                <label for="password2"><strong>Confirm New Password:</strong></label>
                <input type="password" name="password2" id="password2" class="input-block-level" />
                </p>
                <p>
                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-large" />
                </p>
                <input type="hidden" name="x" value="core" />
                <input type="hidden" name="y" value="system" />
                <input type="hidden" name="z" value="password" />
                <input type="hidden" name="save" id="save" value="true" />
            </form>
          </div>
          
          
          
        </div>
      </div>
    </div>