<?php


//Create a connection
$dbUser = 'user';
$dbPass = '12345678';
$dbHost = 'localhost';
$dbName = 'my_map';

try{
    $conn = new PDO("mysql:host=$dbHost;dbname=$dbName", $dbUser, $dbPass);
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed " . $e->getMessage();
}



$action = $_REQUEST['action'];
if($email != null) {
    echo "<h1 style='align:center'>Your user name is " . $userName + "</h1>";
}

if($action == 'register') {
    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $statement = "SELECT email from users  WHERE email = $email";
    if($statement != null) {
        $resultArray = array("status_code" => "200" , "token" => $generatedToken);
    }
    else {
        $resultArray = array("status_code" => "200" , "token" => "");
    }
    echo json_encode($resultArray);
    
    $conn -> exec($statement);
 
    http_response_code(200);
}