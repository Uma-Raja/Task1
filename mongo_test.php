<?php
require 'vendor/autoload.php';
$c = new MongoDB\Client("mongodb://127.0.0.1:27017");
echo "Mongo OK";
