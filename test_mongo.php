<?php
require 'vendor/autoload.php';  // include Composer autoload

use MongoDB\Client;

// Connect to MongoDB
$client = new Client("mongodb://localhost:27017");

// Select database and collection
$db = $client->testdb;
$collection = $db->testcollection;

// Insert a sample document
$result = $collection->insertOne(['name' => 'Uma', 'age' => 25]);

echo "Inserted with ID: " . $result->getInsertedId() . PHP_EOL;
