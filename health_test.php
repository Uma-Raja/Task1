<?php
require_once __DIR__ . '/php/config.php';


echo "PHP OK<br>";
echo $pdo ? "MySQL OK<br>" : "MySQL FAIL<br>";
echo $redis ? "Redis OK<br>" : "Redis OFF<br>";
echo $mongoClient ? "MongoDB OK<br>" : "MongoDB OFF<br>";
