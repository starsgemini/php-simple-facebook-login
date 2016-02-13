# USAGE

## SET UP YOUR FACEBOOK APP

1) Create your APP: https://developers.facebook.com/apps/

2) Skip "quick start".

3) Go to "Settings" menu (on the left side-bar).

4) Click on "+ Add Platform" and select "Website".

5) Now, under "Site url" input type the location of your proyect. Example: http://localhost/myapp.


## SET UP THE CLASS

1) Open facebook-login/config.php file and modify it:

  "app_id" and "app_secret" could be found at your APP Dashboard.
  
  "redirect_uri" is the location of your proyect. Must be the same of "Site url" + "redirect.php". Example: http://localhost/myapp/redirect.php
  
  "scope" are the permissions you need. https://developers.facebook.com/docs/facebook-login/permissions
  
  "home_page" page you will redirected after login.
  
  
## EXAMPLE CODE
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
