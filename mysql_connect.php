<?php 

$link = mysqli_connect("localhost", "user_form", "hushai|h-ee-K8", "kontaktformular");

if (!$link) {
    echo "Error: Unable to connect to Database." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    exit;
}

?>
