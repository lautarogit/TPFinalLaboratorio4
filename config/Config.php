<?php 
    namespace Config;

    //ROOT
    define("ROOT", dirname(__DIR__) . "/");
    define("FRONT_ROOT", "/TPFinalMoviePass/");
    
    //VIEWS
    define("VIEWS_PATH", "Views/");
    define("IMG_PATH", FRONT_ROOT.VIEWS_PATH."assets/img/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH."assets/js/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH."assets/css/");
    
    //SQL
    define("DB_HOST", "localhost");
    define("DB_NAME", "TPFinalMoviePass");
    define("DB_USER", "root");
    define("DB_PASS", "");

    //API TheMovieDB
    define("TMDB_API_KEY", "208f12d7c947fe1e0edc0f341b5bdc36");
    define("API_HOST", 'https://api.themoviedb.org/3');
    define("LANG", 'es-AR');
    define("TMDB_IMG_PATH", 'https://image.tmdb.org/t/p/w780/');
?>