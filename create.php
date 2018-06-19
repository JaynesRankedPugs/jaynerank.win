<?php
$servername = "localhost";
$username = "JayneRate";
$password = "tSkqm3Cs9gI4CCiy";
$dbname = "JayneRating";
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
