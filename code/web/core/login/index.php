<?php

/*
 * Default Page
 */
?>
<div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
            <div class="hero-unit serverGridHero">
                <h1><?php echo $myApp['appTitle']; ?></h1>
                <?php
                if($errors !=""){
                    echo "<strong>".$errors."</strong>";
                }
                ?>
            </div>
            </div>
        </div>
</div>
<div class="row-fluid">
    <div class="span3"></div>
    <div class="span1"><img src="/web/img/serverGridStack.png" alt="ServerGrid Icon" /></div>
    <div class="span5">
      <form class="form-signin" action="/index.php" method="post">
        <h2 class="form-signin-heading">Log In</h2>
        <input type="text" class="input-block-level" placeholder="Username" name="uname">
        <input type="password" class="input-block-level" placeholder="Password" name="pword">
        <button class="btn btn-large btn-primary" type="submit">Sign in</button>
        <input type="hidden" name="x" value="core" />
        <input type="hidden" name="y" value="security" />
        <input type="hidden" name="z" value="login" />
      </form>
    </div>
    <div class="span3"></div>
</div>
