<?php 
    namespace Config;

    define("ROOT", dirname(__DIR__) . "/");
    define("FRONT_ROOT", "/TPFinalMoviePass/");
    
    define("VIEWS_PATH", "Views/");
    define("IMG_PATH", FRONT_ROOT.VIEWS_PATH."assets/img/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH."assets/js/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH."assets/css/");
    
    define("DB_HOST", "localhost");
    define("DB_NAME", "MoviePass");
    define("DB_USER", "root");
    define("DB_PASS", "");

    define("TMDB_API_KEY", "208f12d7c947fe1e0edc0f341b5bdc36");
?>