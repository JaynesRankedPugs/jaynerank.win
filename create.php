<?php
$servername = "PEOPLE_ARE_DUMB";
$username = "PEOPLE_ARE_DUMB";
$password = "PEOPLE_ARE_DUMB";
$dbname = "PEOPLE_ARE_DUMB";
$discord_id = "ID";
$d_name = "name";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$sql = "INSERT INTO Main (discord_id, name, rating, wins, losses, draws)
VALUES ('$discord_id', '$d_name', '1600', '0', '0', '0')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
