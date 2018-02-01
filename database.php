<?php
/**
 * Opens databases
 * @return db connection
 */
function openDb() {
    
//     //Create a connection
//     $dbUser = 'gigfa_18332046';
//     $dbPass = 'abcd1357';
//     $dbHost = 'sql203.gigfa.com';
//     $dbName = 'gigfa_18332046_my_api';
    
    //Create a connection
    $dbUser = 'user';
    $dbPass = '12345678';
    $dbHost = 'localhost';
    $dbName = 'my_api';
    
    $link = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName);
    if(!$link) {
        echo "Error: Unable to connect to MySQL database.".PHP_EOL;
        echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
        echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
        exit;
    }
    return $link;
}
