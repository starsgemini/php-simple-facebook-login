<?php
    namespace fedecarrizo\Facebook;
    require("facebook-login/Facebook.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>PHP Facebook Login</title>
    </head>

    <body>
        <?php
            if (isset($_GET['access_token'])){

                # get user logged data
                $data = Facebook::getUserInfo($_GET['access_token']);

                # store data
                $name       = $data->name;
                $email      = $data->email;
                $picture    = $data->picture->data->url;

                # use data!

                echo <<<RESPONSE
<img src="$picture" /> <br/>
Hi <b>$name!</b> <i>($email)</i>
RESPONSE;

            }else{
        ?>
            <h1>Login with Facebook</h1>
            <a href="redirect.php?do=login">Click me!</a>
        <?php
            }
        ?>
    </body>
</html>