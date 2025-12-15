<?php
$conn = new mysqli("localhost", "root", "", "task1", 3307);
if ($conn->connect_error) {
    die($conn->connect_error);
}
echo "MySQL connection SUCCESS";
