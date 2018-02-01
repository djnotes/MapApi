<?php


//Create a connection
$dbUser = 'user';
$dbPass = '12345678';
$dbHost = 'localhost';
$dbName = 'my_api';



    $link = mysqli_connect('localhost', 'user', '12345678', 'my_api');
if(!$link) {
    echo "Error: Unable to connect to MySQL database.".PHP_EOL;
    echo "Debugging errno: ".mysqli_connect_errno().PHP_EOL;
    echo "Debugging error: ".mysqli_connect_error().PHP_EOL;
    exit;
}

    header("HTTP/1.1", 200);  

if($_REQUEST == null) {
    echo json_encode('API route invalid');
}



$action = $_REQUEST['action'];

$email = $_POST['email'];
$password = $_POST['password'];
$mobile = $_POST ['mobile'];

if($action == 'register') { 
    $sql = "INSERT INTO users (email, password, mobile)
VALUES ('$email', '$password', '$mobile')";
    
    if ($link->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    
    $link->close();
}
else if($action == 'login') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $selectQuery = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
    $queryResult = mysqli_query($selectQuery);
    if(mysqli_num_rows($result) > 0) {
        while($row = $result -> fetch_assoc()) {
            $id = $row['_id'];
            $token = makeToken($id);
            $resultArray = array("status_code" => "200", "token" => $token);
        }
    }
    echo json_encode($resultArray);
    
}

function makeToken ($userId) {
    $token = md5(rand(1,999999999));
    $tokenQuery = "UPDATE users SET token = '$token' WHERE _id = '$userId'";
    return $token;
}
