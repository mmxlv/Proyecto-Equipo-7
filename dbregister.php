<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$link = mysqli_connect("localhost", "root", "", "register");

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

// Escape user inputs for security
$first_name = mysqli_real_escape_string($link, $_REQUEST['nombre-register']);
$email = mysqli_real_escape_string($link, $_REQUEST['email']);
$password = mysqli_real_escape_string($link, $_REQUEST['password']);

// attempt insert query execution
$sql = "INSERT INTO register (nombre, password, email) VALUES ('$first_name', '$password', '$email')";
if(mysqli_query($link, $sql)){
    echo "Records added successfully.<br>";

    echo '<a href="login.php">Go Back</a>';
//    agregar return, si es automatico mejor
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}

// close connection
mysqli_close($link);
?>