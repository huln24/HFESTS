<?php
    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // create session cookie
    session_start();

    

    // connect to db
    function connect() {
        // get db connection info
        include_once('config.php');
        $conn = mysqli_connect($host, $username, $pass, $db, $port);
        return $conn;
    }

    function disconnect($conn) {
        mysqli_close($conn);
    }

    // usage: dump($a, $b)
    function dump()
    {
        $arguments = func_get_args();
        require("views/dump.php");
        exit;
    }

    // usage: redirect("index.php")
    function redirect($location)
    {
        if (headers_sent($file, $line))
        {
            trigger_error("HTTP headers already sent at {$file}:{$line}", E_USER_ERROR);
        }
        header("Location: {$location}");
        exit;
    }


    // usage: render("index.php", ["abc" => $value])
    // 
    function render($view, $values = [])
    {
        if (file_exists("views/{$view}"))
        {
            extract($values);
            require("views/header.php");
            require("views/{$view}");
            require("views/footer.php");
            exit;
        }
        else
        {
            trigger_error("Invalid view: {$view}", E_USER_ERROR);
        }
    }

?>