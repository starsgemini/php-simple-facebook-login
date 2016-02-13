<?php
/**
 * PHP Simple Facebook Login
 *
 * @author Federico Carrizo <carrizofg@gmail.com>
 * @url http://github.com/justfede/php-simple-facebook-login
 */

    namespace fedecarrizo\Facebook;

    require("facebook-login/Facebook.php");
    $fb = new Facebook(require("facebook-login/config.php"));

    if (isset($_GET['do'])){
        $do = $_GET['do'];
        $fb->$do();
    }

    if (isset($_GET['code'])){
        $fb->exchangeCode($_GET['code']);
    }