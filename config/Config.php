<?php 
    namespace Config;

    define("ROOT", dirname(__DIR__) . "/");
    define("FRONT_ROOT", "C:/xampp/htdocs/TPFinalMoviePass/");

    define("VIEWS_PATH", "views/");
    define("IMG_PATH", FRONT_ROOT.VIEWS_PATH."assets/img/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH."assets/js/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH."assets/layouts/styles/");
    
    define("DB_HOST", "localhost");
    define("DB_NAME", "MoviePass");
    define("DB_USER", "root");
    define("DB_PASS", "");
?>