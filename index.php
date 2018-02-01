<?php

require_once('database.php');

    header("HTTP/1.1", 200);  

if($_REQUEST == null) {
    echo json_encode('API route invalid');
}


$action = $_REQUEST['action'];

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$mobile = $_POST ['mobile'];

if($action == 'register') { 
    $link = openDb();
    if($email == null  || $password == null) {
        echo "Insufficient data";
        exit;
    }
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO user (name, email, password, mobile)
VALUES ('$email', '$passwordHash', '$mobile')";
    
    if(mysqli_query($link, $sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $link->error;
    }
    $link->close();
}
else if($action == 'login') {
    
    //Open db 
    $link = openDb();  
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$passwordHash'";
    $result = mysqli_query($link, $sql);
    if(mysqli_num_rows($result) > 0) {
        while($row = $result -> fetch_assoc()) {
            $id = $row['_id'];
            $token = makeToken($id);    
            $resultArray = array("status_code" => "200", "token" => $token);
        }
    }
    echo json_encode($resultArray);
    $link->close();
    mysqli_close($link);
    
}
//User is logged in and can use various app features provided he gives a valid token
else if ($action == 'home') { 
    if(isset($_POST['oauth_token'])) $token = $_POST['oauth_token']; 
    $link = openDb();
    $sql = "SELECT * FROM user WHERE token = $token";
    $result = mysqli_query($link, $sql);
    $row = $result -> fetch_assoc();
    $savedToken = $row['token'];
    if($token == $savedToken) {
        $resultArray = array("status_code" => "200", "status" => "authorized");
        echo json_encode($resultArray);
    }             
}

/**
 * Method for creating tokens 
 * @param unknown $userId
 * @return unknown
 */
function makeToken ($userId) {
    $token = md5(rand(1,999999999));
    $tokenQuery = "UPDATE users SET token = '$token' WHERE _id = '$userId'";
    return $token;
}
