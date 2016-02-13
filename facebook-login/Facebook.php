<?php
/**
 * PHP Simple Facebook Login
 *
 * @author Federico Carrizo <carrizofg@gmail.com>
 * @url http://github.com/justfede/php-simple-facebook-login
 */

    namespace fedecarrizo\Facebook;

    class Facebook{

        private $appId          = '';
        private $appSecret      = '';
        private $redirectUri    = '';
        private $scope          = '';
        private $code           = '';
        private $context        = '';
        private $accessToken    = null;
        private $homePage       = '';
        /**
         * Class constructor
         * @param array config
         */
        function __construct(array $config = null){
            # load settings
            $this->appId        = $config['app_id'];
            $this->redirectUri  = urlencode($config['redirect_uri']);
            $this->appSecret    = $config['app_secret'];
            $this->homePage     = $config['home_page'];

            # generate scope
            foreach ($config['scope'] as $permission){
                $this->scope .= $permission . ',';
            }
            rtrim($this->scope,',');

            # generate context for requests
            $this->context = stream_context_create(array(
                'http' => array('ignore_errors' => true)
            ));
        }

        /**
         * Perform login
         */
        function login(){
            header("Location: https://www.facebook.com/dialog/oauth?client_id={$this->appId}&redirect_uri={$this->redirectUri}&scope={$this->scope}");
            return;
        }

        /**
         * Exchange auth code for access token
         * @param code
         */
        function exchangeCode($code){
            $this->code = $code;
            $exchangeUrl = "https://graph.facebook.com/v2.3/oauth/access_token?client_id={$this->appId}&redirect_uri={$this->redirectUri}&client_secret={$this->appSecret}&code={$this->code}";
            $response = json_decode(file_get_contents($exchangeUrl,false,$this->context));
            if (isset($response->access_token)){
                $this->accessToken = $response->access_token;
                header("Location: {$this->homePage}?access_token={$this->accessToken}");
            }else{
                echo json_encode($response);
            }
        }

        /**
         * Handle static calls
         */
        public static function __callStatic($name,$arguments){
            switch ($name){
                case 'getUserInfo':
                    $accessToken = $arguments[0];

                    if (!$accessToken){
                        die("invalid access token. Please re-login");
                    }

                    $response = json_decode(file_get_contents("https://graph.facebook.com/v2.2/me/?access_token={$accessToken}&fields=id,name,email,picture"));

                    if (!isset($response->id)){
                        die("<b>Please re-login</b>");
                    }

                    return $response;
                default:
                    die("x_x");
            }
        }


    }
