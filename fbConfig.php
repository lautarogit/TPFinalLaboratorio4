<?php
if(!session_id()){
    session_start();
}



// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuración de Facebook SDK
 */
$appId         = '389883145488149'; //Identificador de la Aplicación
$appSecret     = '0177caa4852e175a25fa20db1016d64f'; //Clave secreta de la aplicación
$redirectURL   = 'root'; //Callback URL
$fbPermissions = array('');  //Permisos opcionales

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.9',
));

// Obtener el apoyo de logueo
$helper = $fb->getRedirectLoginHelper();

// Try para obtener el token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
          $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}

?>